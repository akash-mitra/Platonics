<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
use App\Config\ImageConfig;
use App\Config\StorageConfig;

class ConfigurationController extends Controller
{
	// only admin should access config pages
	public function __construct ()
	{
		$this->middleware('admin');
	}


    	protected function showStorage ()
	{
		$storage = Configuration::retrieveObjectByKey('storage', StorageConfig::class);
		return view('storage.setup')->withStorage($storage);
	}


	protected function saveStorage (Request $req) 
	{
		// validation
		// TODO

		// create a new storage of given type
		$storage = new StorageConfig();

		// set the relevant params
		$storage->type($req->input('type'))
			->apiKey($req->input('key'))
			->apiSecret($req->input('secret'))
			->save();

		flash('Storage Configuration saved successfully')->success();
		return redirect()->to(route('storage'));
	}


	protected function showImage ()
	{
		$image = Configuration::retrieveObjectByKey('image', ImageConfig::class);
		return view('image.setup')->withImage($image);;
	}


	protected function saveImage (Request $req) 
	{
		// validation
		// TODO
		
		// create a new storage of given type
		$image = new ImageConfig();

		// set the relevant params
		$image->storageProvider($req->input('storageProvider'))
			->baseLocation ($req->input('baseLocation'))
			->save();

		flash('Image Configuration saved successfully')->success();
		return redirect()->to(route('image'));
	}
}
