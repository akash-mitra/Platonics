<?php
namespace App\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Transformers are used to rename the database column
 * names to more meaningful attribute names in the returned
 * API responses. 
 * 
 * Transformers implements a transform() method for converting
 * the column names found in models to correponding mapped
 * field names.
 * 
 * PaginateTransformer is a special type of transformer that works
 * if the model output is of Illuminate\Pagination\LengthAwarePaginator
 * type.
 */
class PaginateTransformer
{


    /**
     * @param Illuminate\Pagination\LengthAwarePaginator $items
     * @param array $fieldMaps
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function transform(LengthAwarePaginator $items, array $fieldMaps)
    { 
        // convert the Paginator object to object array
        $jsonArray = $items->toArray();

        // pick out the data property from the object
        $dataItems = $jsonArray["data"];

        // transform that
        $transformedDataItems = [];
        foreach ($dataItems as $item) 
        {
            $transformed = [];
            foreach ($item as $origKey => $value) {
                $newKey = $fieldMaps[$origKey] ?? null;

                if (!empty($newKey)) $transformed[$newKey] = $value;
            }
            array_push($transformedDataItems, $transformed);
        }

        // replace the original data property with the transformed data
        $jsonArray["data"] = $transformedDataItems;
        
        return $jsonArray;
    }
}
