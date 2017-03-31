<?php

namespace App;

use App\Category;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	protected $fillable = [
		'title', 'intro', 'category_id', 'fulltext', 'metakey', 'metadesc', 'publish'
	];


	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function category ()
	{
		return $this->belongsTo(Category::class);
	}

	public function getTommyAttribute()
	{
		return $this->id;
	}
}
