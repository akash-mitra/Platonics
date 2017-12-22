<?php

namespace Tests;

use App\User;
use App\Page;
use App\Comment;
use App\Category;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTestDataSetup extends TestCase
{
    use DatabaseTransactions;
   
    protected $user, $admin, $author;
	protected $category;
	protected $page, $page1, $articles;


	public function setUp ()
	{
		parent::setUp();
		
		// create a few users
		$this->user = factory(User::class)->create();
		$this->author = factory(User::class)->create(["type" => "Author"]);
		$this->author1 = factory(User::class)->create(["type" => "Author"]);
		$this->editor = factory(User::class)->create(["type" => "Editor"]);
		$this->admin = factory(User::class)->create(["type" => "Admin"]);
		
		// create couple of articles by one user
		$this->category = factory(Category::class)->create(['parent_id' => null]);
		$this->articles = factory(Page::class, 2)->create([
			"user_id" => $this->author->id,
			"category_id" => $this->category->id,
		]);

		$this->page = $this->articles[0];
		$this->page1 = factory(Page::class)->create([
			"category_id" => $this->category->id, 
			"user_id" => $this->author1->id
		]);

		// create a few comments on the article
		$this->comment = factory(Comment::class)->create([
			'user_id' => $this->user->id,
			'page_id' => $this->articles[0]->id,
		]);

	}

	protected function can_access_a_url_and_assert_see ($url, $user = null, $content)
	{
		if($user) return $this->actingAs($user)->can_access_a_url($url, $content);
		else return $this->can_access_a_url($url, $content);
	}

	protected function can_access_a_url ($url, $content)
	{
		// if i visit route
		return $this->get($url)
			// then page loads successfully
			->assertStatus(200)
			// and I am able to see the content
		  	->assertSee($content);
	}

	protected function can_not_access_a_url ($url, $user = null, $failureStatus = 302)
	{
		if(empty($user))
		{
			$this->get($url)->assertStatus($failureStatus);	
		}
		else {
			$this->actingAs($user)
			// if I visit
			->get($url)
			// then page fails to load
			->assertStatus($failureStatus);	
		}
	}

	protected function noHTML($input, $encoding = 'UTF-8')
	{
		//return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
		return htmlentities($input, ENT_QUOTES, $encoding);
	}
}
