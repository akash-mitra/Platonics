<?php

namespace Tests\SIT;

use App\User;
use App\Article;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
	use DatabaseTransactions;

	public function test_if_a_article_is_browsable_via_url ()
	{
		// given I have a category
		$category = factory(Category::class)->create();

		// and a user
		$user = factory(User::class)->create();

		// and I have an article in this category written by this user
		$article = factory(Article::class)
			->create([
				"category_id" => $category->id,
				"user_id" => $user->id
			]);
			
		// when I visit the article URL - 
		$this->get($article->url)
			// then I am able to see the article title
		  	->assertSee($article->title) 
		  	// and it's written by the same user
		  	->assertSee('Written by ' . $user->name); 
	}

	
}
