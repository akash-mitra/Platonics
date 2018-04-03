<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    public function getContentHierarchies()
    {
        $hierarchy = [];
        $parent = $this->parent;

        while (! empty($parent)) {
            $hierarchy[] = [
                'name' => $parent->name,
                'url' => $parent->getUrlAttribute(),
            ];
            $parent = $parent->parent;
        }

        return array_reverse($hierarchy);
    }

    //TODO getUrLAttribute should be moved here
}
