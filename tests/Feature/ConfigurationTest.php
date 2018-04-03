<?php

namespace Tests\Unit;

use App\Configuration;

use Tests\BlogTestDataSetup;

class ConfigurationTest extends BlogTestDataSetup
{


    public function test_if_configuration_can_be_stored_and_retrieved()
    {
        $this->actingAs($this->admin)
            ->post(route('set-config', '_KEY_'), ["value" => [
                "property1" => "value1",
                "property2" => "value2",
            ]])
            ->assertStatus(200)
            ->assertJsonFragment(["status" => "success"]);

        $this->actingAs($this->admin)
            ->get(route('get-config', '_KEY_'))
            ->assertStatus(200)
            ->assertJsonFragment(["property1" => "value1", "property2" => "value2"]);
    }



    // public function test_if_a_configuration_can_be_deleted ()
    // {
    // 	Configuration::remove ($this->key);
    // 	$this->assertEquals (null, Configuration::retrieveValue($this->key));
    // }
}
