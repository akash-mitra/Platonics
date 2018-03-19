<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends BaseController
{

    protected function show ($categorySlug)
    {
        $category = Category::with('pages')->whereSlug($categorySlug)->firstOrFail();
        
        return view ('category.show', [
            'category' => $category, 
            'pages' => $category->pages
        ]);
    }
}
