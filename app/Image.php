<?php

namespace App;

use App\User;
use App\Config\ImageConfig;
use App\Config\StorageConfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	protected $fillable = ['url', 'name', 'storage'];

	private $fileName = null; 
	private $location = null;

	protected function uploadedBy()
	{
		return $this->belongsTo(User::class);
	}


	public static function validateAndStore ($uploadedFile, $maxsize = 1, $types = ['jpeg', 'png'])
	{
		if (! $uploadedFile->isValid()) 
    		{
			return self::clientValidityError ($uploadedFile);
		}

		if (! in_array($uploadedFile->guessExtension(), $types))
		{
			return self::clientExtensionError($uploadedFile);
		}

		$size = $uploadedFile->getClientSize(); // bytes
		if ($size > ($maxsize * 1024 * 1024))
		{
			return self::clientSizeError ($uploadedFile, $maxsize);
		}

		// determine where do we need to store the file from image configuration
		$imageConfig = Configuration::retrieveObjectByKey('image', ImageConfig::class);

		if ($imageConfig->storageProvider === 'aws')
		{
			// change the aws s3 configuration parameters
			$awsStorage = Configuration::retrieveObjectByKey('storage', StorageConfig::class);

			// validate aws s3 required paramters
			if (empty($awsStorage->apiKey)) 
			{
				return self::serverError (121, 'AWS S3 Storage Parameters (API Key) are not set.');
			}
			if (empty($awsStorage->apiSecret)) 
			{
				return self::serverError (122, 'AWS S3 Storage Parameters (API Secret) are not set.');
			}
			if (empty($awsStorage->region)) 
			{
				return self::serverError (123, 'AWS S3 Storage Parameters (Bucket Region) are not set.');
			}
			if (empty($imageConfig->baseLocation)) 
			{
				return self::serverError (124, 'AWS S3 Bucket name not set in Image Configuration.');
			}

			// all validated; set them
			Config::set('filesystems.disks.s3.key', $awsStorage->apiKey);
			Config::set('filesystems.disks.s3.secret', $awsStorage->apiSecret);
			Config::set('filesystems.disks.s3.bucket', $imageConfig->baseLocation);
			Config::set('filesystems.disks.s3.region', $awsStorage->region);

			try {
				$uploadedFileName = $uploadedFile->store($imageConfig->baseLocation, 's3');
			} catch (\Exception $e) {
				return self::serverError (110, $e->getMessage());
			}
		}
		else // if image configuration is not defined 
		{
			// determine local directory
			$location = $imageConfig->baseLocation ?? 'images';

			Config::set('filesystems.disks.public.root', public_path());
			Config::set('filesystems.disks.public.url', env('APP_URL') . $location);

			// save the file to local directory
    			try {
				$uploadedFileName = $uploadedFile->store($location, 'public');
			} catch (\Exception $e) {
				return self::serverError (109, $e->getMessage());
			}
		}

		$image = new Image([
				"name" => $uploadedFileName,
				"size" => round($size / (1024 * 1024), 2), // mega bytes
				"storage" => $imageConfig->storageProvider,
			]);

		return auth()->user()->assets()->save($image);
		
		//return response()->json(['status' => 'success','file' => $uploadedFileName,], 200 );
	}




	public static function clientValidityError ($uploadedFile)
	{
		return self::clientError(100, 
				sprintf ('File [%s] upload error: %s', 
					 $uploadedFile->getClientOriginalName(), 
					 $uploadedFile->getErrorMessage()
					)
				);
	}
	

	public static function clientSizeError ($uploadedFile, $size)
	{
		return self::clientError(101, 
				sprintf ('File [%s] size is too large (%sMB). Must be less than %sMB.', 
					 $uploadedFile->getClientOriginalName(), 
					 round ($uploadedFile->getClientSize() / 1024 / 1024, 2),
					 $size
					)
				);
	}
	
	
	public static function clientExtensionError ($uploadedFile)
	{
		return self::clientError(105, 
				sprintf ('File [%s] extension is determined as (%s). This extension type is not accepted.', 
					 $uploadedFile->getClientOriginalName(), 
					 $uploadedFile->guessExtension()
					)
				);
	}


	public static function clientError ($code, $message)
	{
		return self::httpError(400, $code, $message);
	}


	public static function serverError ($code, $message)
	{
		return self::httpError(500, $code, $message);
	}


	public static function httpError ($httpErrorCode, $code, $message)
	{
		return response()->json([
			'status' => 'error',
			'code' => $code,
			'message' => $message,
		], $httpErrorCode);
	}
}
