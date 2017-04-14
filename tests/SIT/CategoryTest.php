<?php

namespace Tests\SIT;

use App\Article;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
	use DatabaseTransactions;

	public function test_if_a_category_and_its_contents_are_viewable_via_url ()
	{
		// given I have a category
		$category = factory(Category::class)->create();
		// and an article under this category
		$article = factory(Article::class)->create(["category_id" => $category->id]);

		// when I visit the category url,
		$this->get('/category/' . $category->slug)

		// then I am able to see the category description 
			->assertSee($category->description)
		// and I am able to see the article intro text
			->assertSee($article->intro);
	}



	public function test_if_a_category_can_retrieve_all_articles_in_it()
	{
		// given I have a category and 3 articles in it
		$category = factory(Category::class)->create();
		factory(Article::class, 3)->create(["category_id" => $category->id]);

		// when I retrieve the articles of this category 
		$articles = $category->articles;
	
		// then I can retrieve all the articles
		$this->assertCount(3, $articles);
	}


	public function test_if_parent_categories_are_displayed_in_menu()
	{
		// given we have parent level categories
		$categories = factory(Category::class, 3)->create(['parent_id' => null]);

		// with these names
		$categoryNames = $categories->pluck('name');

		// when we vist the homepage
		$this->get('/')

		// then we see the categories are appearing in the page (as part of menu)
			->assertSee($categoryNames[0])
			->assertSee($categoryNames[1])
			->assertSee($categoryNames[2]);
	}


}
