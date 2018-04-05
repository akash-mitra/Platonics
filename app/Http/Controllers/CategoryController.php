<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends BaseController
{
    protected function show($categorySlug)
    {
        $category = Category::whereSlug($categorySlug)->firstOrFail();

        return view('category.show', [
            'category' => $category,
            'pages' => $category->pages,
            'pageMeta' => [
                'type' => 'category',
                'page_id' => null,
                'category_id' => $category->id,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at
            ]
        ]);
    }
}
