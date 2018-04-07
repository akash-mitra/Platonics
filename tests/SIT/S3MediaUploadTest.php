<?php

namespace Tests\SIT;

use App\Configuration;
use Tests\BlogTestDataSetup;
use Illuminate\Support\Facades\Storage;

class S3MediaUploadTest extends BlogTestDataSetup
{
    public function test_image_is_uploaded_and_exists_in_s3()
    {
        Configuration::setConfig('storage', [
            'apiKey' => env('AWS_TEST_KEY'),
            'apiSecret' => env('AWS_TEST_SECRET'),
            'region' => env('AWS_TEST_REGION'),
            'bucket' => env('AWS_TEST_BUCKET'),
            'type' => 's3'
        ]);

        // post a fake image file
        $response = $this->actingAs($this->user)
            ->post(route('media-store'), ['file' => $this->fakePNGImage])
            ->assertStatus(200)
            ->assertJsonStructure(['name', 'uri', 'username']);

        $storedFile = $response->decodeResponseJson();

        // test if the file is accessible
        $this->assertTrue(Storage::disk('s3')->exists($storedFile['name']));

        Storage::disk('s3')->delete($storedFile['name']);

        Configuration::delConfig('storage');
    }
}
