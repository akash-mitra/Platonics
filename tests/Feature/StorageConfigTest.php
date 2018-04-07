<?php

namespace Tests\Unit;

use Tests\BlogTestDataSetup;

class StorageConfigTest extends BlogTestDataSetup
{
    public function test_non_admin_users_can_not_config_storage()
    {
        $this->can_not_access_a_url(route('get-config', 'storage'), $this->editor);
        $this->can_not_access_a_url(route('set-config', 'storage'), $this->editor);
        $this->can_not_access_a_url(route('get-config', 'storage'), $this->user);
        $this->can_not_access_a_url(route('set-config', 'storage'), $this->user);
    }

    public function test_if_storage_config_can_be_configured()
    {
        // check storage info is saved properly
        $this->actingAs($this->admin)
            ->post(route('set-config', 'storage'), [
                'value' => [
                                'type' => 's3',
                                'apiKey' => env('AWS_TEST_KEY'),
                                'apiSecret' => env('AWS_TEST_SECRET'),
                                'region' => env('AWS_TEST_REGION'),
                                'bucket' => env('AWS_TEST_BUCKET')
                            ]
            ])
            ->assertStatus(200)
            ->assertJsonFragment(['status' => 'success']);

        // and can be retrived later
        $this->actingAs($this->admin)
            ->get(route('get-config', 'storage'))
            ->assertStatus(200)
            ->assertSee(env('AWS_TEST_KEY'));
    }
}
