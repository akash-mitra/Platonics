<?php

namespace App\Transformers;

use Illuminate\Support\Collection;

class Transformer {


	public function transform (Collection $items, array $field_mapper)
	{	
		$arr = $items->toArray();
		$transformedCollection = [];
		foreach ($arr as $e) {
			$transformed = [];
			foreach( $e as $origKey => $value ) {
				$newKey = $field_mapper[$origKey] ?? null;
				
				if (! empty($newKey)) $transformed[$newKey] = $value;
			}
			array_push($transformedCollection, $transformed);
		}
		return $transformedCollection;
	}
}