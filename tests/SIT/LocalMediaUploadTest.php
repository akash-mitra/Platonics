<?php
namespace Tests\SIT;

use App\User;
use Tests\TestCase;
use App\Config\StorageConfig;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalMediaUploadTest extends TestCase
{

    protected $user, $fakeJPGImage, $storedFile;

    public function setUp()
    {
        parent::setUp();

        // create one user
        $this->user = factory(User::class)->create();

        // create fake images
        $this->fakeJPGImage = UploadedFile::fake()->image('fake.jpg');
    }


    public function tearDown()
    {
        // delete all test files from the respective storages
        Storage::disk('local')->delete($this->storedFile["name"]);
    }



    public function test_unauthenticated_users_cant_upload_media()
    {
        $this->post(route('media-store'), ['file' => $this->fakeJPGImage])
            ->assertStatus(302);
    }



    public function test_media_is_uploaded_and_exists_in_local_storage()
    {
        // post a fake image file
        $response = $this->actingAs($this->user)
            ->post(route('media-store'), ['file' => $this->fakeJPGImage])
            ->assertStatus(200)
            ->assertJsonStructure(["name", "uri", "username"]);

        $this->storedFile = $response->decodeResponseJson();

        // test the file exists
        $this->assertTrue(Storage::disk('local')->exists($this->storedFile["name"]));

        // // and the file is accessible
        // \Log::info($this->storedFile["uri"]);
        // $this->get($this->storedFile["uri"])->assertStatus(200);
    }
}
