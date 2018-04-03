<?php

namespace Tests\Unit;

use Tests\BlogTestDataSetup;

class ImageConfigTest extends BlogTestDataSetup
{

    public function test_non_admin_users_can_not_config_image()
    {
        // $this->can_not_access_a_url(route('image'), $this->editor);
        // $this->can_not_access_a_url(route('image-config-store'), $this->editor);
        // $this->can_not_access_a_url(route('image'), $this->user);
        // $this->can_not_access_a_url(route('image-config-store'), $this->user);
    }


    public function test_if_image_config_can_be_configured()
    {
        // $storageProvider = 's3'; // just a sample value
        // $baseLocation = bin2hex(random_bytes(20));

        // // check storage info is saved properly
        // $this->actingAs($this->admin)
        // 	->post(route('image-config-store'), ["storageProvider" => $storageProvider, "baseLocation" => $baseLocation])
        // 	->assertRedirect(route('image'));

        // // and can be retrived later
        // $this->actingAs($this->admin)
        // 	->get(route('image'))
        // 	->assertSee($storageProvider)
        // 	->assertSee($baseLocation);
    }
}
