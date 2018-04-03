<?php

namespace App\Http\Controllers\API\v1;

use App\Page;
use App\Category;
use Illuminate\Http\Request;
use App\Transformers\Transformer;
use App\Http\Controllers\Controller;

class APICategoryController extends Controller
{

    protected $field_mapper = [
        /* 'database_field' => 'new_label' */
        'name' => 'name',
        'id'  => 'record',
        'parent_id' => 'parent_record',
        'slug' => 'label'
    ];


    protected function getCategories(Transformer $t)
    {
        $categories = Category::all();
        
        return response()->json(
            $t->transform($categories, $this->field_mapper)
        );
    }


    protected function getRelatedPages($category_id, $limit = 10)
    {
        $pages = Page::where('category_id', $category_id)
            ->select(['id', 'title', 'category_id'])
            ->orderBy('updated_at', 'desc')
            ->take($limit)
            ->get();

        return response()->json([
            "status" => "success",
            "message" => "Related pages",
            "count" => count($pages),
            "pages" => $pages
        ]);
    }
}
