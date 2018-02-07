<?php

namespace App\Http\Controllers;

use App\Page;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        // only admin can delete an article
        $this->middleware('admin')->only('destroy');

        // Author, Editor and Admin can access page editor or save page
        $this->middleware(function ($request, $next) 
        {
            if (Auth::user() && in_array (Auth::user()->type, array('Author', 'Editor', 'Admin'))) 
            {
                return $next($request);
            }

            flash ('You do not have permission to perform this action')->warning();
            return redirect()->route('page-index');

        })->only(['editor', 'save']);
    }



    /**
     * Returns a page containing the list of all articles
     */
    protected function index ()
    {
    	$pages = $this->list();
    	return view ('page.index', compact('pages'));
    }



    /**
     * Returns a single article page 
     */
    protected function show ($categorySlug, $pageSlug = null)
    {
    	// The Id is determined by cutting the slug from the
    	// beginning to the first occurance of "-" sign.
    	// Because sometimes "-" might not appear in  
    	// the slug, we append extra "-" with it.
        $id = substr($pageSlug, 0, strpos($pageSlug . '-', '-'));

        $page = Page::findOrFail($id);
        
    	if ($page->category_id === null || $page->category->slug === $categorySlug) {
           return view ('page.show', compact('page'));
        }

        abort(404, 'Page Not Found');
    }



    /**
     * Opens up a blank page editor if id is not provided.
     * If Id is provided, opens up a page editor with the page contents.
     */
    protected function editor ($id = null)
    {
        $page = $this->getPageObject ($id);

        if (!$this->hasPermission('edit', $page)) {
            return redirect()->route('page-index');
        }

        return view('page.editor', compact('page'));
    }



    /**
     * Saves a the contents of the page to the database.
     * If the page does not already exists, then create 
     * new page. If the page exists, then update the page.
     */
    protected function save (Request $request)
    {
        $page = $this->getPageObject ($request->input('id'));

        if (! $this->hasPermission('save', $page)) {
            return redirect()->route('page-index');
        }

        $page->fill($request->input());
    	
        try {
            $page = Auth::user()->pages()->save($page);
            return response()->json($page->id, 200);
        }
        catch (HttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getStatusCode());
        }
    }



    /**
     * A handy function to get a new or existing page object
     */
    private function getPageObject ($id = null)
    {
        if (empty($id)) {
            return new Page();
        } else {
            return Page::findOrFail ($id);
        }
    }
    


    /**
     * Deletes the page from the database
     */
    protected function destroy ($id)
    {
        if(! $this->hasPermission ('delete'))  return redirect()->route('page-index');

        $page = Page::findOrFail($id);
        $page->delete();

        flash('Page deleted successfully')->success();
        return redirect()->route('page-index');
            
    }




    /**
     * Checks whether the user accessing the page has permission
     * to perform the intended operation, e.g., edit or delete
     */
    private function hasPermission ($action, $resource = null)
    {
            $userType = Auth::user()->type;

            // admin should be able to do anything
            if ($userType == 'Admin') {
                return true;
            }
            
            // editor is like admin, but does not have delete rights
            if ($userType == 'Editor' && $action != 'delete') {
                return true;
            }

            // authors are like editors, but they can only change
            // their own documents or create new documents
            if ($userType == 'Author' && in_array($action, ['edit', 'save'])) 
            {
                // access editor or save route to create new page is fine
                if(empty($resource->id))
                    return true;

                // access editor to save own page is fine
                if (! empty($resource->id) && $resource->author->id === Auth::user()->id) 
                    return true;
            }

            // for everything else, deny permission
            flash ('You do not have permission to ' . $action . ' this page')->warning();
            return false;
    }



    /**
     * This is a helper function to query only the attributes
     * required in this view. This helps in avoiding selection
     * of large text columns and clog up memory
     */ 
    private function list ()
    {

        return DB::table('pages')
                ->leftJoin('users', 'pages.user_id', 'users.id')
                ->leftJoin('categories', 'pages.category_id', 'categories.id')
                ->select(DB::raw('pages.id, pages.title, pages.created_at, pages.updated_at, users.name as author, case when categories.name is null then "uncategorized" else categories.name end as category'))
                ->get();
                // paginatin will be handled in frontend for smaller (less than 5000 entries) lists
                //->paginate(20);
    }
}