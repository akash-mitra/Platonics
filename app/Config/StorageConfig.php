<?php

namespace App\Config;

use App\Configuration;
use Illuminate\Support\Facades\Config;

class StorageConfig
{
    public $type;
    public $region;
    public $apiKey;
    public $apiSecret;
    public $bucket;

    public function __construct(array $attributes = null)
    {
        if ($attributes) {
            $this->type = $attributes['type'];
            $this->region = $attributes['region'];
            $this->apiKey = $attributes['apiKey'];
            $this->apiSecret = $attributes['apiSecret'];
            $this->bucket = $attributes['bucket'];
        }
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

    public function bucket($bucket)
    {
        $this->bucket = $bucket;

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

    // public function delete()
    // {
    //     return Configuration::remove('storage');
    // }

    public function validate()
    {
        if ($this->type === 's3') {
            $this->validateS3Parameters();
        }
    }

    public function setUpFileSystem()
    {
        if ($this->type === 's3') {
            $this->setUpS3FileSystem();
        }
    }

    private function setUpS3FileSystem()
    {
        Config::set('filesystems.disks.s3.key', $this->apiKey);
        Config::set('filesystems.disks.s3.secret', $this->apiSecret);
        Config::set('filesystems.disks.s3.region', $this->region);
        Config::set('filesystems.disks.s3.bucket', $this->bucket);
    }

    private function validateS3Parameters()
    {
        if (empty($this->apiKey)) {
            abort(500, 'AWS S3 Storage Parameters (API Key) are not set.');
        }

        if (empty($this->apiSecret)) {
            abort(500, 'AWS S3 Storage Parameters (API Secret) are not set.');
        }

        if (empty($this->region)) {
            abort(500, 'AWS S3 Storage Parameters (Bucket Region) are not set.');
        }

        if (empty($this->bucket)) {
            abort(500, 'AWS S3 Bucket name not set in Storage Configuration.');
        }
    }
}
