<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
use App\Config\CdnConfig;
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


		// IMPORTANT
		// if all the storage parameters come as blank, we should remove the storage config
		if (empty($req->input('key')) 
			&& empty($req->input('secret')) 
			&& empty($req->input('region')) 
			&& empty($req->input('bucket'))) {
			
				$storage->delete();
				flash('Storage Configuration Deleted Successfully')->success();
		}
		else 
		{
			// set the relevant params
			$storage->type($req->input('type'))
				->apiKey($req->input('key'))
				->apiSecret($req->input('secret'))
				->region($req->input('region'))
				->bucket($req->input('bucket'))
				->save();

			flash('Storage Configuration Saved Successfully')->success();
		}

		return redirect()->to(route('storage'));
	}


	protected function showCdn ()
	{
		$cdn = Configuration::retrieveObjectByKey('cdn', CDNConfig::class);
		return view('cdn.setup')->withCdn($cdn);;
	}


	protected function saveCdn (Request $req) 
	{
		// validation
		// TODO
		
		// create a new storage of given type
		$cdn = new CDNConfig();

		// set the relevant params
		$cdn->css($req->input('css-cdn'))
			->js($req->input('js-cdn'))
			->media($req->input('media-cdn'))
			->save();

		flash('CDN Configuration saved successfully')->success();

		return redirect()->to(route('cdn'));
	}
}
