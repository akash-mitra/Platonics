<?php

namespace App;

use App\Article;
//use App\Category;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name', 'parent_id', 'description'
    ];

    // this ensure accessor property is included in the Category object
    protected $appends = [
        'url'
    ];

    public function articles ()
    {
    	return $this->hasMany(Article::class);
    }


    public function parent()
    {
    	return $this->hasOne('App\Category', 'id', 'parent_id');
    }


    public function getUrlAttribute()
    {
        return '/category/' . $this->name;
    }

}
