<?php

namespace App\Http\Controllers;

use App\Page;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
        parent::__construct();
    }


    protected function index ()
    {
    	$categories = Category::all();
    	return view('category.index', compact('categories'));
    }


    protected function show ($categorySlug)
    {
        $category = Category::whereSlug($categorySlug)->firstOrFail();
        $pages = $category->pages ?? new App\Page();

        //$meta = json_decode(Configuration::where('key', 'blog')->first()->value, true);
        //View::share('meta', $meta);
        
        return view ('category.show', [
            'category' => $category, 
            'pages' => $pages
        ]);
    }


    protected function create ()
    {
        if(! $this->hasPermission ('create')) return redirect()->back();
    	return view ('category.create');
    }



    /**
     * Creates a new category.
     */
    protected function store (Request $request)
    {
        if(! $this->hasPermission ('store')) return redirect()->back();

    	$doc = new Category ([
    		'name' => strip_tags($request->input('head')),
            'slug' => strip_tags($request->input('url')),
    		'description' => $request->input('body'),
            'parent_id' => $request->input('cat'),
    	]);

    	$doc->save();
    	
        flash('New category ' . $doc->name . ' created successfully')->success();
    	return redirect()->route('category-index');		
    }



    /**
     * Shows an edit form to edit a given category
     */
    protected function edit ($id)
    {
        if(! $this->hasPermission ('edit')) return redirect()->back();

        $category = Category::findOrFail($id);

        return view ('category.edit', compact('category'));
    }



    /**
     * Saves changes to existing category
     */
    protected function save (Request $request)
    {

        if(! $this->hasPermission ('save')) return redirect()->back();

        $id = $request->input('id');
        $parent_id = $request->input('cat');

        // make sure the supplied parent is not actually
        // also a child of this category
        if (! empty ($parent_id) && $this->hasCyclicDependency ($id, $parent_id))
            return redirect()
            ->route('category-edit', $id)
            ->withMessage('The selected parent category is also a child of this category');
    	
        $category = Category::findOrFail($id);
        $category->name = strip_tags($request->input('head'));
        $category->slug = $request->input('url'); 
        $category->description = $request->input('body'); 
        $category->parent_id = $parent_id; 
        $category->save();
        
        flash('Category saved')->success();
        return redirect()->route('category-edit', $id);
    }


    private function hasCyclicDependency ($id, $parent_id)
    {
        $parent_category = Category::findOrFail($parent_id);
        $p = $parent_category->parent;
        if(empty($p)) return false;
        if ($p->id == $id) return true;
        else return false;
    }


    private function hasPermission ($action)
    {
            $type = Auth::user()->type;

            // admin should be able to do anything
            if ($type == 'Admin') {
                return true;
            }
            
            // for everything else, deny permission
            flash ('You do not have permission to ' . $action . ' category')->warning();
            return false;
    }
}
