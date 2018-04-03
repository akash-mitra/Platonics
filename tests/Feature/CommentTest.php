<?php

namespace Tests\Feature;

use Tests\BlogTestDataSetup;

class CommentTest extends BlogTestDataSetup
{
    public function test_non_auth_user_can_see_page_comments()
    {
        $this->user_can_see_page_comments($this->page1);
    }

    public function test_auth_user_can_see_page_comments()
    {
        $this->user_can_see_page_comments($this->page1, $this->user);
    }

    public function test_non_auth_user_dont_see_post_button()
    {
        $this->get($this->page1->url)
            ->assertDontSee('Post');
    }

    public function test_non_auth_user_can_not_post_comment()
    {

        $this->post(route('comments-store'), ["text" => "sample text", "pageid" => 1])
                ->assertRedirect('/login');
    }

    public function test_auth_user_can_post_comment()
    {
        $this->actingAs($this->user)
            ->post(route('comments-store'), ["text" => "sample text", "pageid" => $this->page4->id])
            ->assertStatus(200);
    }

    public function test_auth_user_can_see_specific_user_comments()
    {
        // first parameter specify the user whose comments are to be viewed
        // second parameter is the user viewing the comment
        $this->user_can_see_user_comments($this->user, $this->author);
    }


    // public function test_non_auth_user_can_not_see_specific_user_comments ()
    // {
    // 	$this->can_not_access_a_url(route('comments-by-user', $this->user->slug));
    // }


    private function user_can_see_page_comments($page, $viewer = null)
    {
        if (! $viewer) {
            return $this->check_comments_by_page($page);
        } else {
            return $this->actingAs($viewer)->check_comments_by_page($page);
        }
    }

    private function user_can_see_user_comments($user, $viewer = null)
    {
        if (! $viewer) {
            return $this->check_comments_by_user($user);
        } else {
            return $this->actingAs($viewer)->check_comments_by_user($user);
        }
    }


    private function check_comments_by_page($page)
    {
        return $this->check_comments(route('comments-on-page') . '?url=' .  $page->url);
    }

    private function check_comments_by_user($user)
    {
        return $this->check_comments(route('comments-by-user', $user->slug));
    }

    private function check_comments($route)
    {
        return $this->json('GET', $route)
        ->assertStatus(200)
        ->assertJsonStructure([[
            'text',
            'when',
            'user' => ['name', 'profile', 'avatar'],
            'page' => ['title', 'url'],
        ]])
        ->assertJson([[
            "text" => $this->noHTML($this->comment1->body)
        ]]);
    }
}
