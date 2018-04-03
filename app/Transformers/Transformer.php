<?php

namespace App\Transformers;

use Illuminate\Support\Collection;

class Transformer
{


    public function transform(Collection $items, array $field_mapper)
    {
        $itemsArray = $items->toArray();
        $transformedCollection = [];
        foreach ($itemsArray as $item) {
            $transformed = [];
            foreach ($item as $origKey => $value) {
                $newKey = $field_mapper[$origKey] ?? null;
                
                if (! empty($newKey)) {
                    $transformed[$newKey] = $value;
                }
            }
            array_push($transformedCollection, $transformed);
        }
        return $transformedCollection;
    }
}
