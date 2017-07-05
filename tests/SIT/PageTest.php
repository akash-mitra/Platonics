<?php

namespace Tests\SIT;

// use App\User;
// use App\Page;
// use App\Category;
// use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\BlogTestDataSetup;

class PageTest extends BlogTestDataSetup
{
	// use DatabaseTransactions;

	// protected $user, $category, $page;

	// public function setUp ()
	// {
	// 	parent::setUp();

	// 	// create one user
	// 	$this->user = factory(User::class)->create();

	// 	// and one category
	// 	$this->category = factory(Category::class)->create(['parent_id' => null]);

	// 	// create a page in the category
	// 	$this->page = factory(Page::class)->create([
	// 		"category_id" => $this->category->id, 
	// 		"user_id" => $this->user->id
	// 	]);
	// }

	public function test_if_a_page_is_browsable_via_url ()
	{
		$page = $this->articles[0];
		// given I have a category
		// and a user
		// and I have an page in this category written by this user
		// when I visit the page URL - 
		$this->get($page->url)
			// then I am able to see the page title
		  	->assertSee($page->title) 
		  	// and it's written by the same user
		  	->assertSee('Written by <a href="' . $this->author->url . '">' . $this->noHTML($this->author->name) . '</a>'); 
	}

}
