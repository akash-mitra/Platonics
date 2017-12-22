<?php

namespace App\Config;

use App\Configuration;

/**
 * Represents the configurations for CDN
 */
class CdnConfig {


	public $cssCdnPath, $jsCdnPath, $mediaCdnPath;


	/**
	 * Saves the CDN Configuration to the database
	 */
	public function save()
	{
		return Configuration::persist('cdn', json_encode($this), true);
	}



	/**
	 * Sets the CDN path for CSS
	 * 
	 * @param string CDN Path
	 * 
	 */ 
	public function css ($cssCdnPath)
	{
		$this->cssCdnPath = $cssCdnPath;
		return $this;
	}



	/**
	 * Sets the CDN path for JS
	 * 
	 * @param string CDN Path
	 * 
	 */ 
	public function js ($jsCdnPath)
	{
		$this->jsCdnPath = $jsCdnPath;
		return $this;
	}



	/**
	 * Sets the CDN path for media
	 * 
	 * @param string CDN Path
	 * 
	 */ 
	public function media ($mediaCdnPath)
	{
		$this->mediaCdnPath = $mediaCdnPath;
		return $this;
	}
}