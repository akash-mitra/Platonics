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

	protected $user, $category, $article;

	public function setUp ()
	{
		parent::setUp();

		// create one user
		$this->user = factory(User::class)->create();

		// and one category
		$this->category = factory(Category::class)->create(['parent_id' => null]);

		// create an article in the category
		$this->article = factory(Article::class)->create([
			"category_id" => $this->category->id, 
			"user_id" => $this->user->id
		]);
	}

	public function test_if_a_article_is_browsable_via_url ()
	{
		// given I have a category
		// and a user
		// and I have an article in this category written by this user
		// when I visit the article URL - 
		$this->get($this->article->url)
			// then I am able to see the article title
		  	->assertSee($this->article->title) 
		  	// and it's written by the same user
		  	->assertSee('Written by <a href="' . $this->user->url . '">' . $this->user->name . '</a>'); 
	}

}
