<?php

namespace Tests\SIT;

use App\User;
use App\Page;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
	use DatabaseTransactions;

	protected $user, $category1, $category2, $category3, $page1, $page2, $page3;

	public function setUp ()
	{
		parent::setUp();

		// create one user
		$this->user = factory(User::class)->create();

		// create 2 parent level categories
		$this->category1 = factory(Category::class)->create(['parent_id' => null]);
		$this->category2 = factory(Category::class)->create(['parent_id' => null]);

		// and one subcategory under first parent category
		$this->category3 = factory(Category::class)->create(['parent_id' => $this->category1->id]);

		// create a few pages in them
		$this->page1 = factory(Page::class)->create([
			"category_id" => $this->category1->id, 
			"user_id" => $this->user->id
		]);
		$this->page2 = factory(Page::class)->create([
			"category_id" => $this->category1->id, 
			"user_id" => $this->user->id
		]);
		$this->page3 = factory(Page::class)->create([
			"category_id" => $this->category3->id, 
			"user_id" => $this->user->id
		]);
	}

	public function test_if_a_category_and_its_contents_are_viewable_via_url ()
	{
		// given I have a category (1)
		// and an page (1) under this category
		// when I visit the category url,
		$this->get($this->category1->slug)

		// then I am able to see the category description 
			->assertSee($this->category1->description)
		// and I am able to see the page intro text
			->assertSee($this->page1->intro);
	}



	public function test_if_a_category_can_retrieve_all_pages_in_it()
	{
		// given I have a category (1) and 2 pages (1 and 2) in it
		// when I retrieve the pages of this category 
		$pages = $this->category1->pages;
	
		// then I can retrieve exactly 2 pages
		$this->assertCount(2, $pages);
	}


	public function test_if_top_level_categories_are_displayed_in_menu()
	{
		// given we have top level categories (1 and 2)
		// with these names
		$name1 = $this->category1->name;
		$name2 = $this->category2->name;

		// when we vist the homepage
		$this->get('/')

		// then we see the categories are appearing in the page (as part of menu)
			->assertSee($name1)
			->assertSee($name2);
	}
}
