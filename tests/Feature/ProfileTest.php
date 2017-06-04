<?php

namespace Tests\Feature;
use App\User;
use App\Page;
use App\Category;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{
	use DatabaseTransactions;
   
    	protected $user, $userWithArticles, $adminUser, $articles, $category;

    	public function setUp ()
    	{
    		parent::setUp();
    		
    		// create a few users
    		$this->user = factory(User::class)->create();
    		$this->userWithArticles = factory(User::class)->create();
    		$this->adminUser = factory(User::class)->create(["type" => "Admin"]);
    		
    		// create couple of articles by one user
    		$this->category = factory(Category::class)->create(['parent_id' => null]);
		$this->articles = factory(Page::class, 2)->create([
			"user_id" => $this->userWithArticles->id,
			"category_id" => $this->category->id,
		]);
    	}


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
		// of another user (in this case userWithArticles)
		$this->actingAs($this->user)
			->get('/profile/user/' . $this->userWithArticles->slug)
			->assertStatus(200)
			->assertSee('Profile Page for ' . $this->userWithArticles->name);
	}


	public function test_non_auth_user_can_not_access_any_profile_page()
	{
		$this->get('/profile')
			->assertStatus(302);

		$this->get('/profile/user/' . $this->user->slug)
			->assertStatus(302);
	}


	public function test_an_incorrect_slug_throws_error ()
	{
		$this->get('/profile/user/1234.1234.1234')
			->assertStatus(302);
	}


	public function test_only_admin_user_can_see_email ()
	{
		$someUserProfilePage = '/profile/user/' . $this->user->slug;

		// we will need to test 2 things...
		// first - admin can see the email when s/he visits the profile page
		$this->actingAs($this->adminUser)
			->get($someUserProfilePage)
			->assertSeeText($this->user->email);

		// and second - non-admin can not see the email on the same page
		$this->actingAs($this->userWithArticles)
			->get($someUserProfilePage)
			->assertDontSeeText($this->user->email);
	}


	public function test_that_articles_by_a_user_appear_in_profile_page ()
	{
		$this->actingAs($this->user)
			->get('/profile/user/' . $this->userWithArticles->slug)
			->assertSeeText($this->articles[0]->title)
			->assertSeeText($this->articles[1]->title);
	}
}
