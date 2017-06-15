<?php

namespace Tests\SIT;

use App\User;
use App\Page;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PermissionTest extends TestCase
{
	use DatabaseTransactions;

	protected $user, $author, $author1, $editor, $admin, $category, $page, $page1;

	public function setUp ()
	{
		parent::setUp();

		// create all types of users
		$this->user = factory(User::class)->create();
		$this->author = factory(User::class)->create(['type' => 'Author']);
		$this->author1 = factory(User::class)->create(['type' => 'Author']);
		$this->editor = factory(User::class)->create(['type' => 'Editor']);
		$this->admin = factory(User::class)->create(['type' => 'Admin']);

		// and one category
		$this->category = factory(Category::class)->create(['parent_id' => null]);

		// create pages in the category written by the authors
		$this->page = factory(Page::class)->create([
			"category_id" => $this->category->id, 
			"user_id" => $this->author->id
		]);

		$this->page1 = factory(Page::class)->create([
			"category_id" => $this->category->id, 
			"user_id" => $this->author1->id
		]);
	}


	/*
	 *--------------------------------------------------------------------------------
	 * Permission to open editor to create new pages
	 *--------------------------------------------------------------------------------
	 */
	public function test_author_can_open_editor_to_create_new_page ()
	{
		$this->some_user_can_open_a_url_and_assert_see($this->author, route('page-create'), "Page Heading");
	}

	public function test_editor_can_open_editor_to_create_new_page ()
	{
		$this->some_user_can_open_a_url_and_assert_see($this->editor, route('page-create'), "Page Heading");
	}

	public function test_admin_can_open_editor_to_create_new_page ()
	{
		$this->some_user_can_open_a_url_and_assert_see($this->admin, route('page-create'), "Page Heading");
	}

	public function test_registered_users_can_not_open_editor_to_create_new_page ()
	{
		// given I have a general registered user
		// she should not be able to open a page editor
		$this->can_not_access_a_url($this->user, route('page-create'));
	}

	public function test_visitors_can_not_open_editor_to_create_new_page ()
	{
		$this->can_not_access_a_url(null, route('page-create'));
	}


	/*
	 *--------------------------------------------------------------------------------
	 * Permissions to edit existing pages
	 *--------------------------------------------------------------------------------
	 */
	public function test_author_can_edit_her_own_pages ()
	{
		// given I have an author, she can open a page
		// owned by her for editing and see the page markdowns
		$this->some_user_can_open_a_url_and_assert_see (
				$this->author, 
				route('page-edit', $this->page->id), 
				$this->page->markdown
			);
	}

	public function test_author_can_not_edit_others_pages ()
	{
		// author trying to open 'page1' (whereas 'page' was owned by him)
		$this->can_not_access_a_url($this->author, route('page-edit', $this->page1->id));
	}


	public function test_editor_can_edit_any_pages ()
	{
		// given I have an editor, she can open any page for edit
		$this->some_user_can_open_a_url_and_assert_see (
				$this->editor, 
				route('page-edit', $this->page->id), 
				$this->page->markdown
			);
	}

	public function test_admin_can_edit_any_pages ()
	{
		// given I have an editor, she can open any page for edit
		$this->some_user_can_open_a_url_and_assert_see (
				$this->admin, 
				route('page-edit', $this->page1->id), 
				$this->page1->markdown
			);
	}


	/*
	 *--------------------------------------------------------------------------------
	 * Permissions to create category
	 *--------------------------------------------------------------------------------
	 */

	public function test_admin_can_create_category ()
	{
		$this->some_user_can_open_a_url_and_assert_see (
				$this->admin, 
				route('category-create'), 
				'URL Slug'
			);
	}

	public function test_non_admin_can_not_create_category ()
	{
		$this->can_not_access_a_url($this->author, route('category-create'));
		$this->can_not_access_a_url($this->user, route('category-create'));
		$this->can_not_access_a_url(null, route('category-create')); // visitors
	}


	private function some_user_can_open_a_url_and_assert_see ($user, $route, $content)
	{
		// given I have a user 
		$this->actingAs($user)
			// if I visit
			->get($route)
			// then page loads successfully
			->assertStatus(200)
			// and I am able to see the content
		  	->assertSee($content);
	}

	private function can_not_access_a_url ($user, $route, $failureStatus = 302)
	{
		if(empty($user))
		{
			$this->get($route)->assertStatus($failureStatus);	
		}
		else {
			$this->actingAs($user)
			// if I visit
			->get($route)
			// then page fails to load
			->assertStatus($failureStatus);	
		}
	}

}
