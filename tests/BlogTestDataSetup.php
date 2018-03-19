<?php

namespace Tests;

use App\User;
use App\Page;
use App\Comment;
use App\Category;
use Tests\TestCase;
use App\Configuration;
use App\SpecialPage;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTestDataSetup extends TestCase
{
    use DatabaseTransactions;
   
    protected $user, $author, $author1, $editor, $admin;
	protected $category, $category2, $category3;
	protected $page1, $page2, $page3;
	protected $comment1;


	public function setUp ()
	{
	
		parent::setUp();
		
		// create basic configuration / metadata
		$configs = factory(Configuration::class)->create();

		// create 1 general, 2 authors, 1 editor and 1 admin type users
		$this->user = factory(User::class)->create();
		$this->author = factory(User::class)->create(["type" => "Author"]);
		$this->author1 = factory(User::class)->create(["type" => "Author"]);
		$this->editor = factory(User::class)->create(["type" => "Editor"]);
		$this->admin = factory(User::class)->create(["type" => "Admin"]);

		/*-----------------------------------------------------------------------------------------
		| create 3 categories as per below hierarchy
		|                 |
		|      |---------------------|
		|   category             category2
		|   |
		| category3
		|----------------------------------------------------------------------------------------*/

		$this->category = factory(Category::class)->create(['parent_id' => null]);
		$this->category2 = factory(Category::class)->create(['parent_id' => null]);
		// and one subcategory under first parent category
		$this->category3 = factory(Category::class)->create(['parent_id' => $this->category->id]);

		
		// create a few pages in them
		$this->page1 = factory(Page::class)->create([
			"category_id" => $this->category->id,
			"user_id" => $this->author->id
		]);
		$this->page2 = factory(Page::class)->create([
			"category_id" => null,
			"user_id" => $this->author->id
		]);
		$this->page3 = factory(Page::class)->create([
			"category_id" => $this->category3->id,
			"user_id" => $this->author1->id
		]);
		$this->page4 = factory(Page::class)->create([
			"category_id" => $this->category3->id,
			"user_id" => $this->editor->id
		]);

		// create a few comments on the article
		$this->comment1 = factory(Comment::class)->create([
			'user_id' => $this->user->id,
			'page_id' => $this->page1->id,
		]);


		// special page
		$sp = factory(SpecialPage::class)->create();

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
