<?php

namespace Tests\Unit;

use App\Configuration;

use Tests\BlogTestDataSetup;

class ConfigurationTest extends BlogTestDataSetup
{

	public function test_if_configuration_can_be_stored_and_retrieved () {

		$key = bin2hex(random_bytes(20));
		$value = bin2hex(random_bytes(20));

		Configuration::persist($key, $value);
		$newValue = Configuration::retrieveValue($key);

		$this->assertEquals($value, $newValue);
	}

}
