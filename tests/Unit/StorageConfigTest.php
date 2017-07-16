<?php

namespace Tests\Unit;
use Tests\BlogTestDataSetup;

class StorageConfigTest extends BlogTestDataSetup
{

	public function test_non_admin_users_can_not_config_storage () {
		$this->can_not_access_a_url(route('storage'), $this->editor);
		$this->can_not_access_a_url(route('storage-store'), $this->editor);
		$this->can_not_access_a_url(route('storage'), $this->user);
		$this->can_not_access_a_url(route('storage-store'), $this->user);
	}

	public function test_if_storage_config_can_be_configured ()
	{
		$key = bin2hex(random_bytes(20));
		$secret = bin2hex(random_bytes(20));

		// check storage info is saved properly
		$this->actingAs($this->admin)
			->post(route('storage-store'), ["key" => $key, "secret" => $secret])
			->assertRedirect(route('storage'));

		// and can be retrived later
		$this->actingAs($this->admin)
			->get(route('storage'))
			->assertSee($key)
			->assertSee($secret);
	}

}
