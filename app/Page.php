<?php

namespace App;

use App\User;
use App\Comment;
use App\Category;
use App\Content;

class Page extends Content
{
    protected $fillable = [
        'title', 'intro', 'category_id', 'markup', 'metakey', 'metadesc', 'publish', 'featured'
    ];

    // this ensure accessor property is included in the Page object
    protected $appends = [
        'url'
    ];


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function scopeFeatured($query)
    {
        return $query->whereNotNull('featured');
    }
    

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function getUrlAttribute()
    {
        return '/'
        . (empty($this->category->slug)? 'general' : $this->category->slug)
        . '/'
        . str_slug($this->id . ' ' . $this->title);
    }
}
