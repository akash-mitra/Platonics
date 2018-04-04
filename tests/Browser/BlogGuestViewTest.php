<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class BlogGuestViewTest extends DuskTestCase
{
    public function test_home_page_opens_in_browser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Platonics');
        });
    }

    public function test_signin_modal_is_opened_when_clicked_on_signin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Sign In')
                ->pause(1000)
                ->assertSee('Click on one of the below services to Sign Up or Login');

            // $browser->driver->manage()->deleteAllCookies();
        });
    }
}
