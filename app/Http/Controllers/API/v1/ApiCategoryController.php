<?php

namespace App\Http\Controllers\API\v1;

use App\Article;
use App\Category;
use App\Transformers\Transformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{

	protected $field_mapper = [
		/* 'database_field' => 'new_label' */
		'name' => 'label',
		'id'  => 'record',
		'parent_id' => 'parent_record'
	];


	protected function getCategories (Transformer $t)
	{
		$categories = Category::all();
		return response()->json(
			$t->transform($categories, $this->field_mapper)
		);
	}
}
