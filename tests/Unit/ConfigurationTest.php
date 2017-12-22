<?php

namespace Tests\Unit;

use App\Configuration;

use Tests\BlogTestDataSetup;

class ConfigurationTest //extends BlogTestDataSetup
{

	protected $key;
	protected $value;

	public function setUp ()
	{
		$this->key = bin2hex(random_bytes(20));
		$this->value = bin2hex(random_bytes(20));
	}



	public function test_if_configuration_can_be_stored_and_retrieved () 
	{
		Configuration::persist ($this->key, $this->value);
		$newValue = Configuration::retrieveValue ($this->key);

		$this->assertEquals ($this->value, $newValue);
	}



	public function test_if_a_configuration_can_be_deleted ()
	{
		Configuration::remove ($this->key);
		$this->assertEquals (null, Configuration::retrieveValue($this->key));
	}

}
