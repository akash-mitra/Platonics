<?php

namespace App;

use App\Page;
//use App\Category;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name', 'slug', 'parent_id', 'description'
    ];

    // this ensure accessor property is included in the Category object
    protected $appends = [
        'url'
    ];

    public function pages ()
    {
    	return $this->hasMany(Page::class);
    }


    public function parent()
    {
    	return $this->hasOne('App\Category', 'id', 'parent_id');
    }


    public function getUrlAttribute()
    {
        return '/' . $this->slug;
    }

}
