<?php

namespace App;

use Exception;
use App\Config\CdnConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * This class represents media object.
 */
class Media extends Model
{
    protected $fillable = ['name', 'storage', 'size_kb', 'uri'];

    protected $appends = ['url'];

    /**
     * Returns a fully qualified URL of the media resource
     * after applying CDN transformations (if CDN is configured)
     */
    public function getUrlAttribute()
    {
        if ($this->storage === 's3') {
            return $this->CDNWrap($this->uri);
        }

        return $this->CDNWrap(url($this->uri));
    }

    /**
     * Returns the user who uploaded the media
     */
    protected function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Validates and Stores an uploded media file based on storage configuration setup
     */
    public static function store($uploadedFile, $subDirectoryPath = '', $allowedExtensions = ['jpeg', 'png', 'jpg'], $maxSize = 1)
    {
        self::validateAgainstClientErrors($uploadedFile, $allowedExtensions, $maxSize);

        $storageConfig = Configuration::getConfig('storage');
        $storageConfig->validate();
        $storageConfig->setUpFileSystem();

        return self::_store($uploadedFile, $subDirectoryPath, $storageConfig->type);
    }

    /**
     * Tests the Uploaded File and checks against size and type errors
     */
    private static function validateAgainstClientErrors($uploadedFile, array $allowedExtensions, $maxSize = 1)
    {
        if (!$uploadedFile->isValid()) {
            self::clientValidityError($uploadedFile);
        }

        if (!in_array($uploadedFile->guessExtension(), $allowedExtensions)) {
            self::clientExtensionError($uploadedFile);
        }

        $size = $uploadedFile->getClientSize(); // bytes

        if ($size > ($maxSize * 1024 * 1024) || $size <= 0) {
            self::clientSizeError($uploadedFile, $maxSize);
        }
    }

    private static function _store($uploadedFile, $subDirectoryPath, $type, $visibility = 'public')
    {
        $path = '';
        $uri = '';
        $authUser = auth()->user();

        if (empty($type)) {
            $type = 'local';
        }

        try {
            // put the file in the desired disk, under desired location, with given visibility
            $path = Storage::disk($type)->putFile($subDirectoryPath, $uploadedFile, $visibility);

            $size = $uploadedFile->getClientSize();
            $uri = Storage::disk($type)->url($path);
            $media = new Media([
                'name' => $path,
                'size_kb' => round($size / 1024, 2), // killobytes
                'storage' => $type,
                'uri' => $uri
            ]);

            $authUser->assets()->save($media);

            return [
                'name' => $path,
                'uri' => $uri,
                'username' => $authUser->name,
                'storage_type' => $type
            ];
        } catch (Exception $e) {
            if (Storage::disk($type)->exists($path)) {
                Storage::disk($type)->delete($path);
            }

            Media::whereName($path)->delete();

            abort(500, $e->getMessage());
        }
    }

    private static function clientValidityError($uploadedFile)
    {
        self::clientError(sprintf(
             'File [%s] upload error: %s',
             $uploadedFile->getClientOriginalName(),
             $uploadedFile->getErrorMessage()
         ));
    }

    private static function clientSizeError($uploadedFile, $size)
    {
        self::clientError(sprintf(
             'File [%s] size is too large (%sMB). Must be less than %sMB.',
             $uploadedFile->getClientOriginalName(),
             round($uploadedFile->getClientSize() / (1024 * 1024), 2),
             $size
         ));
    }

    private static function clientExtensionError($uploadedFile)
    {
        self::clientError(sprintf(
             'Type of file [%s] is determined as (%s). This extension type is not accepted.',
             $uploadedFile->getClientOriginalName(),
             $uploadedFile->guessExtension()
         ));
    }

    private static function clientError($message)
    {
        abort(400, $message);
    }

    // private static function serverError ($message)
    // {
    // 	self::httpError(500, $message);
    // }

    // private static function httpError ($httpErrorCode, $message)
    // {
    // 	abort ($httpErrorCode, $message);
    // }

    private function getStoragePath()
    {
        switch ($this->storage) {
            case 's3':
                $cdn = Configuration::retrieveObjectByKey('storage', CDNConfig::class);

                return 'https ://' . $cdn->region . 'amazonaws.com/' . $cdn->bucket . '/';

            default:
                return env('LOCAL_MEDIA_PATH', '/media/');
        }
    }

    private function getMediaCDNPath()
    {
        $cdn = Configuration::retrieveObjectByKey('cdn', CDNConfig::class);

        return $cdn->mediaCdnPath;
    }

    private function CDNWrap($fullyQualifiedUrl)
    {
        return $fullyQualifiedUrl;
    }
}
