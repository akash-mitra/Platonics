<?php

namespace App;

use App\Category;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = [
		'title', 'intro', 'category_id', 'fulltext', 'metakey', 'metadesc', 'publish'
	];

	// this ensure accessor property is included in the Article object
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

	public function getTommyAttribute()
	{
		return $this->id;
	}

	public function getUrlAttribute ()
	{
		return '/' . $this->category->slug . '/' . str_slug($this->id . ' ' . $this->title);
	}
}
