<?php

namespace Tests\SIT;

use App\User;
use Tests\BlogTestDataSetup;

class PageTest extends BlogTestDataSetup
{
    // protected $admin;

    // public function setUp()
    // {
    //     parent::setUp();

    //     $this->admin = factory(User::class)->create(['type' => 'Admin']);
    // }

    public function test_if_a_page_is_browsable_via_url()
    {
        $this->get($this->page1->url)
                ->assertSee($this->page1->title)
                ->assertSee('<a href="' . $this->author->url . '">' . $this->noHTML($this->author->name) . '</a>');
    }
}
