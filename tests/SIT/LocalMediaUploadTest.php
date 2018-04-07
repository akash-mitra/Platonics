<?php

namespace Tests\SIT;

use Tests\BlogTestDataSetup;
use Illuminate\Support\Facades\Storage;

class LocalMediaUploadTest extends BlogTestDataSetup
{
    public function test_unauthenticated_users_cant_upload_media()
    {
        $this->post(route('media-store'), ['file' => $this->fakeJPGImage])
            ->assertStatus(302);
    }

    public function test_auth_user_can_upload_in_local_storage()
    {
        // post a fake image file
        $response = $this->actingAs($this->user)
            ->post(route('media-store'), ['file' => $this->fakeJPGImage])
            ->assertStatus(200)
            ->assertJsonStructure(['name', 'uri', 'username']);

        $storedFile = $response->decodeResponseJson();

        // test the file exists
        $this->assertTrue(Storage::disk('local')->exists($storedFile['name']));
    }
}
