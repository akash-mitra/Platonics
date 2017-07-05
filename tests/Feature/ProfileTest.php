<?php

namespace Tests\Feature;
use Tests\BlogTestDataSetup;

class ProfileTest extends BlogTestDataSetup
{  

	public function test_auth_user_can_access_own_profile_page()
	{
		$this->actingAs($this->user)
			->get('/profile')
			->assertStatus(200)
			->assertSee('Profile Page for ' . $this->user->name);
	}


	public function test_auth_user_can_access_any_profile_page() 
	{
		// when user tries to visit the profile page 
		// of another user 
		$this->actingAs($this->user)
			->get(route('user', $this->author->slug))
			->assertStatus(200)
			->assertSee('Profile Page for ' . $this->author->name);
	}


	public function test_non_auth_user_can_not_access_any_profile_page()
	{
		$this->get('/profile')
			->assertStatus(302);

		$this->get(route('user', $this->user->slug))
			->assertStatus(302);
	}


	public function test_an_incorrect_slug_throws_error ()
	{
		$this->get(route('user', '1234.1234.1234'))
			->assertStatus(302);
	}


	public function test_admin_and_editor_can_see_user_email ()
	{
		$someUserProfilePage = route('user', $this->user->slug);

		$this->actingAs($this->admin)
			->get($someUserProfilePage)
			->assertSeeText($this->user->email);

		$this->actingAs($this->editor)
			->get($someUserProfilePage)
			->assertSeeText($this->user->email);
	}


	public function test_author_can_not_see_user_email ()
	{
		$someUserProfilePage = route('user', $this->user->slug);
		$this->actingAs($this->author)
			->get($someUserProfilePage)
			->assertDontSeeText($this->user->email);
	}


	public function test_registered_users_can_not_see_user_email ()
	{
		// assume the other user is author
		$someUserProfilePage = route('user', $this->author->slug);
		// try to view author email as a registered user
		$this->actingAs($this->user)
			->get($someUserProfilePage)
			->assertDontSeeText($this->user->email);
	}


	public function test_user_can_see_own_email ()
	{
		// own profile
		$someUserProfilePage = route('profile');

		$this->actingAs($this->user)
			->get($someUserProfilePage)
			->assertSeeText($this->user->email);
	}


	public function test_that_articles_by_a_user_appear_in_profile_page ()
	{
		$this->actingAs($this->user)
			->get(route('user', $this->author->slug))
			->assertSeeText($this->articles[0]->title)
			->assertSeeText($this->articles[1]->title);
	}
}
