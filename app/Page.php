<?php

namespace App;

use App\User;
use App\Comment;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = [
		'title', 'intro', 'category_id', 'markup', 'markdown', 'metakey', 'metadesc', 'publish'
	];

	// this ensure accessor property is included in the Page object
	protected $appends = [
	    'url'
	];


	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function category ()
	{
		return $this->belongsTo(Category::class);
	}

	public function comments ()
	{
		return $this->hasMany(Comment::class);
	}

	public function getTommyAttribute()
	{
		return $this->id;
	}

	public function getUrlAttribute ()
	{
		return '/' 
		. (empty($this->category->slug)? 'general' : $this->category->slug)
		. '/' 
		. str_slug($this->id . ' ' . $this->title);
	}
}
