<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    	protected $fillable = [
		'user_id', 'page_id', 'body'
	];
	

	public static function byUser($slug, $order = 'desc')
	{
		return self::getCommentsFromDatabase($order)->where('users.slug', '=', $slug);
	}


	public static function onPage($id, $order = 'desc')
	{
		return self::getCommentsFromDatabase($order)->where('pages.id', '=', $id);
	}


	private static function getCommentsFromDatabase($order) 
	{
		return DB::table('comments')
    			->join('users', 'users.id', '=', 'comments.user_id')
    			->join('pages', 'pages.id', '=', 'comments.page_id')
    			->leftjoin('categories', 'categories.id', '=', 'pages.category_id')
    			->select(self::getFields())
    			->orderBy('comments.created_at', $order);
	}


	private static function getFields()
	{
		return [
			'comments.body', 
			'comments.created_at',
			'users.name', 
			'users.slug', 
			'users.avatar', 
			'users.type', 
			'pages.title', 
			'pages.intro', 
			'pages.id', 
    			'categories.slug as category'
    		];
	}
}
