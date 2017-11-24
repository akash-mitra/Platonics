<?php

namespace App\Config;
use App\Configuration;

class StorageConfig {

	public $type, $region, $apiKey, $apiSecret, $user;

	public function save()
	{
		return Configuration::persist('storage', json_encode($this), true);
	}


	public function type($type)
	{
		$this->type = $type;
		return $this;
	}


	public function region($region)
	{
		$this->region = $region;
		return $this;
	}


	public function apiKey($apiKey)
	{
		$this->apiKey = $apiKey;
		return $this;
	}

	public function apiSecret($apiSecret)
	{
		$this->apiSecret = $apiSecret;
		return $this;
	}
}