<?php
namespace Tests\SIT;

use App\User;
use Tests\TestCase;
use App\Config\StorageConfig;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3MediaUploadTest extends TestCase
{

    protected $user, $storage, $fakePNGImage, $storedFile;

    public function setUp()
    {
        parent::setUp();

        // create one user
        $this->user = factory(User::class)->create();

        // create fake images
        $this->fakePNGImage = UploadedFile::fake()->image('fake.png');

        // create a new storage config for s3
        $this->storage = new StorageConfig();
        $this->storage->type('s3')
            ->apiKey(env('AWS_TEST_KEY'))
            ->apiSecret(env('AWS_TEST_SECRET'))
            ->region(env('AWS_TEST_REGION'))
            ->bucket(env('AWS_TEST_BUCKET'))
            ->save();
    }


    public function tearDown()
    {
        $this->storage->delete();                               // delete config
        Storage::disk('s3')->delete($this->storedFile["name"]); // delete the actual s3 file
    }



    public function test_image_is_uploaded_and_exists_in_s3()
    {
        // post a fake image file
        $response = $this->actingAs($this->user)
            ->post(route('media-store'), ['file' => $this->fakePNGImage])
            ->assertStatus(200)
            ->assertJsonStructure(["name", "uri", "username"]);


        $this->storedFile = $response->decodeResponseJson();

        // test if the file is accessible
        $this->assertTrue(Storage::disk('s3')->exists($this->storedFile["name"]));
    }
}
