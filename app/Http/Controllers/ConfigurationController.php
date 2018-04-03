<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
use App\Config\CdnConfig;
use App\Config\BlogConfig;
use App\Config\StorageConfig;
use Illuminate\Validation\Rule;

class ConfigurationController extends BaseController
{
    // only admin should access config pages
    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }


    protected function showStorage()
    {
        $storage = Configuration::retrieveObjectByKey('storage', StorageConfig::class);
        return view('storage.setup')->withStorage($storage);
    }


    protected function saveStorage(Request $req)
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
        } else {
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


    protected function showCdn()
    {
        $cdn = Configuration::retrieveObjectByKey('cdn', CDNConfig::class);
        return view('cdn.setup')->withCdn($cdn);
        ;
    }


    protected function saveCdn(Request $req)
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


    

    // protected function changeLayout(Request $request)
    // {
    // 	//TODO
    // 	// $validatedData = $request->validate([
    // 	// 	'layout' => [
    //  //      'required',
    // 	// 		Rule::in(['first-zone', 'second-zone']),
    // 	// 	],
    // 	// ]);
    // 	$layout = $request->input('layout');

    // 	$blog = Configuration::retrieveObjectByKey('blog', BlogConfig::class);

    // 	$blog->layout($layout)->save();

    // 	return response()->json([
    // 		"message" => "Layout saved successfully",
    // 		"status"  => "success"
    // 	]);
    // }


    // protected function saveBlog (Request $request)
    // {
    // 	//TODO
    // 	// validation

    // 	$blogName = $request->input('blogName');

    // 	$blogDesc = $request->input('blogDesc');

    // 	// $blog = new BlogConfig();
    // 	$blog = Configuration::retrieveObjectByKey('blog', BlogConfig::class);
        
    // 	$blog->blogName($blogName)->blogDesc($blogDesc)->save();

    // 	return response()->json([
    // 		"message" => "Layout saved successfully",
    // 		"status" => "success"
    // 	]);
    // }


    // protected function saveColor (Request $request)
    // {
    // 	//TODO
    // 	// validation

    // 	$className  = $request->input('className');
    // 	$colorValue = $request->input('color');

    // 	$blog = Configuration::retrieveObjectByKey('blog', BlogConfig::class);
    // 	if ($className === 'bg-color-primary') $blog->bgColorPrimary($colorValue)->save();

    // 	return response()->json([
    // 		"message" => "Color saved successfully",
    // 		"status" => "success"
    // 	]);
    // }



    /**
     * Returns an array object pertaining to the
     * given key from the configuration table.
     */
    protected function getConfig($config)
    {
        //TODO caching
        $configRecord = Configuration::where('key', $config)->first();
        
        return response()->json(unserialize($configRecord->value));
    }



    /**
     * Stores the serialized value against
     * the configuration key provided. If
     * the configuration key exists, then
     * the values are merged and updated.
     *
     */
    protected function setConfig($config, Request $request)
    {
        //TODO validation
        $newParameters = $request->input('value');

        $configRecord = Configuration::where('key', $config)->first();
        
        if ($configRecord) {
            $existingParams = unserialize($configRecord->value ?: '{}');
            
            $newParameters = array_merge($existingParams, $newParameters);
        }

        $serializedValueArray = serialize($newParameters);
        
        if (strlen($serializedValueArray) >= 4000) {
            return response()->json([
                "status" => "failure",
                "message" => "Configuration exceeds size limit"
            ], 400);
        }

        Configuration::updateOrCreate(['key' => $config], ['value' => $serializedValueArray]);
        
        return response()->json([
            "status" => "success",
            "message" => "Configuration stored successfully"
        ]);
    }
}
