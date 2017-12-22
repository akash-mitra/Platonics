<?php

namespace Tests\SIT;
use Tests\BlogTestDataSetup;

class PermissionTest extends BlogTestDataSetup
{
	/*
	 *--------------------------------------------------------------------------------
	 * Permission to open editor to create new pages
	 *--------------------------------------------------------------------------------
	 */
	public function test_author_can_open_editor_to_create_new_page ()
	{
		$this->can_access_a_url_and_assert_see(route('page-editor'), $this->author, "Compose an epic");
	}

	public function test_editor_can_open_editor_to_create_new_page ()
	{
		$this->can_access_a_url_and_assert_see(route('page-editor'), $this->editor, "Compose an epic");
	}

	public function test_admin_can_open_editor_to_create_new_page ()
	{
		$this->can_access_a_url_and_assert_see(route('page-editor'), $this->admin, "Compose an epic");
	}

	public function test_registered_users_can_not_open_editor_to_create_new_page ()
	{
		// given I have a general registered user
		// she should not be able to open a page editor
		$this->can_not_access_a_url(route('page-editor'), $this->user);
	}

	public function test_visitors_can_not_open_editor_to_create_new_page ()
	{
		$this->can_not_access_a_url(route('page-editor'));
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
		$this->can_access_a_url_and_assert_see (
				route('page-editor', $this->page->id), 
				$this->author,
				$this->page->markup
			);
	}

	public function test_author_can_not_edit_others_pages ()
	{
		// author trying to open 'page1' (whereas 'page' was owned by him)
		$this->can_not_access_a_url(route('page-editor', $this->page1->id), $this->author);
	}


	public function test_editor_can_edit_any_pages ()
	{
		// given I have an editor, she can open any page for edit
		$this->can_access_a_url_and_assert_see ( 
				route('page-editor', $this->page->id), 
				$this->editor,
				$this->page->markup
			);
	}

	public function test_admin_can_edit_any_pages ()
	{
		// given I have an editor, she can open any page for edit
		$this->can_access_a_url_and_assert_see (
				route('page-editor', $this->page1->id), 
				$this->admin, 
				$this->page1->markup
			);
	}


	/*
	 *--------------------------------------------------------------------------------
	 * Permissions to create category
	 *--------------------------------------------------------------------------------
	 */

	public function test_admin_can_create_category ()
	{
		$this->can_access_a_url_and_assert_see (
				route('category-create'), 
				$this->admin, 
				'URL Slug'
			);
	}

	public function test_non_admin_can_not_create_category ()
	{
		$this->can_not_access_a_url(route('category-create'), $this->author);
		$this->can_not_access_a_url(route('category-create'), $this->user);
		$this->can_not_access_a_url(route('category-create')); // visitors
	}

}
