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
        $this->middleware('auth')->except(['show', 'index']);
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
                && ($page->category_id == null 
                || $page->category->slug === $categorySlug))
    	   return view ('page.show', compact('page'));

        abort(404, 'Page Not Found');
    }


    protected function create ()
    {
    	return view ('page.create');
    }

    protected function store (Request $request)
    {        
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
    	
    	return redirect()
    		->route('page-edit', $page->id)
    		->withMessage('Page saved');
    }


    protected function edit ($id)
    {
        $page = Page::findOrFail($id);
        return view ('page.edit', compact('page'));
    }


    protected function save (Request $request)
    {
        $id = $request->input('id');
        $page = Page::findOrFail($id);
        
        $page->title         = $request->input('head');
        $page->intro         = $request->input('summary');
        $page->category_id   = $request->input('cat');
        $page->markdown      = $request->input('body'); 
        $page->markup        = $this->_getHTML($request->input('body'));
        $page->metakey       = $request->input('keys');
        $page->metadesc      = $request->input('desc');
        $page->publish       = $request->has('publish') ? 1 : 0;

        $page->save();
        
        return redirect()
            ->route('page-edit', $id)
            ->withMessage('Page saved');
    }

    protected function destroy ($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()
            ->route('page-index')
            ->withMessage('Page saved');
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
