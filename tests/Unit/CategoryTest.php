<?php

namespace Tests\SIT;

use Tests\BlogTestDataSetup;

class CategoryTest extends BlogTestDataSetup
{
	

	public function test_if_a_category_and_its_contents_are_viewable_via_url ()
	{
		// when I visit the category url,
		$this->get($this->category->slug)
		// then I am able to see the category description 
			->assertSee($this->category->description)
		// and I am able to see the page1 intro text (as page1 is setip in category)
			->assertSee($this->page1->intro);
	}



	public function test_if_a_category_model_can_retrieve_all_pages_in_it()
	{
		// given I have a category (1) and 2 pages (1 and 2) in it
		// when I retrieve the pages of this category 
		$pages = $this->category3->pages;
	
		// then I can retrieve exactly 2 pages
		$this->assertCount(2, $pages);
	}


	public function test_if_top_level_categories_are_displayed_in_menu()
	{
		// given we have top level categories (1 and 2)
		// with these names
		$name1 = $this->category->name;
		$name2 = $this->category2->name;

		// when we vist the homepage
		$this->get('/')
			// ->assertSuccessful()
		// then we see the categories are appearing in the page (as part of menu)
			->assertSee($name1)
			->assertSee($name2);
	}
}
