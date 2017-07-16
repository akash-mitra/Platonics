<?php

namespace App\Http\Controllers;

use App\Page;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function __construct()
    {
        // Permission scheme
        // -------------------------------------------------
        //             |  User  | Author | Editor | Admin
        // create      |  N     | Y      | Y      | Y
        // store       |  N     | Y      | Y      | Y
        // edit        |  N     | Y      | Y      | Y
        // save        |  N     | Y      | Y      | Y
        // destroy     |  N     | N      | N      | Y
        // index       |  Y     | Y      | Y      | Y
        // show        |  Y     | Y      | Y      | Y
        // -------------------------------------------------

        $this->middleware('admin')->only('destroy');

        $this->middleware(function ($request, $next) {

            if (Auth::user() 
                && in_array (Auth::user()->type, array('Author', 'Editor', 'Admin'))) 
            {
                return $next($request);
            }

            // if not allowed, then redirect
            flash ('You do not have permission to perform this action')->warning();
            return redirect()->back();

        })->only(['create', 'store', 'edit', 'save']);
    }


    protected function index ()
    {
    	$pages = $this->list();
    	return view ('page.index', compact('pages'));
    }

    protected function show ($categorySlug, $pageSlug = null)
    {
    	// The Id is determined by cutting the slug from the
    	// beginning to the first occurance of "-" sign.
    	// Because sometimes "-" might not appear in  
    	// the slug, we append extra "-" with it.
    	$id = substr($pageSlug, 0, strpos($pageSlug . '-', '-'));

    	$page = Page::findOrFail($id);
        
        
    	if ($page->publish == '1' 
                && ($page->category_id === null || $page->category->slug === $categorySlug))
    	   return view ('page.show', compact('page'));

        abort(404, 'Page Not Found');
    }


    protected function create ()
    {
        if(! $this->hasPermission ('create')) return redirect()->back();
    	return view ('page.create');
    }

    protected function store (Request $request)
    {      

        if(! $this->hasPermission ('store')) return redirect()->back();

        $markdown = $request->input('body');
        $markup   = $this->_getHTML($markdown);
    	$doc = new Page ([
    		'title'       => $request->input('head'),
    		'intro'       => $request->input('summary'),
            'category_id' => $request->input('cat'),
    		'markup'      => $markup,
            'markdown'    => $markdown,
    		'metakey'     => $request->input('keys'),
    		'metadesc'    => $request->input('desc'),
            'publish'     => $request->has('publish') ? 1 : 0
    	]);

    	$page = Auth::user()->pages()->save($doc);
    	
        flash('Page saved successfully')->success();
    	return redirect()->route('page-edit', $page->id);
    }


    protected function edit ($id)
    {
        $page = Page::findOrFail($id);

        if(! $this->hasPermission ('edit', $page)) return redirect()->back();

        return view ('page.edit', compact('page'));
    }


    protected function save (Request $request)
    {
        $id = $request->input('id');
        $page = Page::findOrFail($id);
        
        if(! $this->hasPermission ('save', $page)) return redirect()->back();

        $page->title         = $request->input('head');
        $page->intro         = $request->input('summary');
        $page->category_id   = $request->input('cat');
        $page->markdown      = $request->input('body'); 
        $page->markup        = $this->_getHTML($request->input('body'));
        $page->metakey       = $request->input('keys');
        $page->metadesc      = $request->input('desc');
        $page->publish       = $request->has('publish') ? 1 : 0;

        $page->save();
        
        flash('Page saved successfully')->success();
        return redirect()->route('page-edit', $id);
    }


    protected function destroy ($id)
    {
        if(! $this->hasPermission ('delete'))  return redirect()->back();

        $page = Page::findOrFail($id);
        $page->delete();

        flash('Page deleted successfully')->success();
        return redirect()->route('page-index');
            
    }



    private function hasPermission ($action, $resource = null)
    {
            $type = Auth::user()->type;

            // admin should be able to do anything
            if ($type == 'Admin') {
                return true;
            }
            
            // editor is like admin, but does not have delete rights
            if($type == 'Editor' && $action != 'delete') {
                return true;
            }

            // authors are like editors, but when it comes to 
            // edit or update, they can do so only in their
            // own articles.
            if($type == 'Author') 
            {
                // creation is fine, after all that's what authors do
                if(in_array($action, array('create', 'store')))
                    return true;

                // but update is only restricted to own contents
                if (in_array($action, array('edit', 'save')) && !empty($resource) && $resource->author->id === Auth::user()->id) 
                    return true;
            }

            // for everything else, deny permission
            flash ('You do not have permission to ' . $action . ' this page')->warning();
            return false;
    }


    /*
     * This is a helper function to query only the attributes
     * required in this view. This helps in avoiding selection
     * of large text columns and clog up memory
     */
    private function list ()
    {
        return DB::select('select 
                a.id, 
                a.title, 
                a.created_at, 
                a.updated_at, 
                u.name author, 
                case 
                    when c.name is null then "uncategorized" 
                    else c.name
                end category
            from pages a 
            left outer join users u on a.user_id = u.id 
            left outer join categories c on a.category_id = c.id
            order by a.updated_at desc');
    }


    private function _getHTML ($markdown) 
    {
        /* 
         * We will convert the markdown to html
         * markup and store both the markup and the
         * markdown versions in the database for future.
         */
        $parser   = new \Parsedown();
        return $parser->text($markdown);
    }
}
