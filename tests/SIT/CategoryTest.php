<?php

namespace Tests\SIT;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
	use DatabaseTransactions;

	public function test_if_a_category_is_browsable_via_url ()
	{
		// given I have a category
		factory(Category::class, 1)->create(["id" => 100]);

		// when I visit the category url,
		// I am able to see the category description 
		$category = Category::find(100);
		$this->get('/category/' . $category->slug)
			->assertSee($category->description);
		
		// factory(Category::class, 1)->create(["id" => 110]);
		// factory(Category::class, 3)->create();
		// factory(Category::class, 3)->create(["parent_id" => 100]);
		// factory(Category::class, 3)->create(["parent_id" => 110]);
		
	}


}
