<?php

namespace App\Http\Controllers;

use App\Page;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'list']);
    }


    protected function list ()
    {
    	$categories = Category::all();
    	return view('category.list', compact('categories'));
    }


    protected function show ($categorySlug)
    {
        $category = Category::whereSlug($categorySlug)->first();
        $pages = $category->pages;
        if (count($pages) != 0)
            return view ('category.show', [
                'category' => $category, 
                'pages' => $pages
            ]);
        else 
            return view ('category.empty')->withCategory($category);
    }


    protected function create ()
    {
    	return view ('category.create');
    }


    protected function store (Request $request)
    {
    	$doc = new Category ([
    		'name' => strip_tags($request->input('head')),
            'slug' => strip_tags($request->input('url')),
    		'description' => $request->input('body'),
            'parent_id' => $request->input('cat'),
    	]);

    	$doc->save();
    	
    	return redirect()
    		->route('category-list')
    		->withMessage('New category created');
    }


    protected function edit ($id)
    {
        $category = Category::findOrFail($id);
        return view ('category.edit', compact('category'));
    }


    protected function save (Request $request)
    {
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
        
        return redirect()
            ->route('category-edit', $id)
            ->withMessage('Category saved');
    }


    private function hasCyclicDependency ($id, $parent_id)
    {
        $parent_category = Category::findOrFail($parent_id);
        $p = $parent_category->parent;
        if(empty($p)) return false;
        if ($p->id == $id) return true;
        else return false;
    }
}
