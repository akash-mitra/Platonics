<?php

namespace App\Config;
use App\Configuration;

class ImageConfig {

	public $storageProvider, $baseLocation;

	public function save()
	{
		return Configuration::persist('image', json_encode($this), true);
	}


	public function storageProvider($storageProvider)
	{
		$this->storageProvider = $storageProvider;
		return $this;
	}


	public function baseLocation($baseLocation)
	{
		$this->baseLocation = $baseLocation;
		return $this;
	}
	
}