<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected function list ()
    {
    	$categories = Category::all();
    	return view('category.list', compact('categories'));
    }

    protected function create ()
    {
    	return view ('category.create');
    }

    protected function store (Request $request)
    {
    	$doc = new Category ([
    		'name' => strip_tags($request->input('head')),
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
        $category = Category::findOrFail($id);

        $category->name = strip_tags($request->input('head'));
        $category->description = $request->input('body'); 
        $category->parent_id = $request->input('cat'); 
        $category->save();
        
        return redirect()
            ->route('category-edit', $id)
            ->withMessage('Category saved');
    }


    protected function show ($name)
    {
        $articles = Category::whereName($name)->first()->articles()->get();
        if (count($articles) != 0)
            return view ('category.show', compact('articles'));
        else 
            return view ('category.empty')->withCategory($name);
    }
}
