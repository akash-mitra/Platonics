<?php

namespace App\Transformers;
use Illuminate\Support\Collection;

class CategoryTransformer {

	private function _transform ($item) 
	{
		return [
			'head' => $item->name,
		];
	}


	public function transform (Collection $categories)
	{	
		return $categories->map(function ($item, $key) {
			return $this->_transform($item);
		})->toArray();
	}
}