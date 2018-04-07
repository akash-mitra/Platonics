<?php

namespace App;

use App\Config\StorageConfig;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Allowable configuration keys with
     * default values.
     *
     * Default values are either class names or arrays
     */
    public static $configurations = [
        'storage' => StorageConfig::class,
        'blogmeta' => [
            'bg-color-primary' => '#FFFFFF',
            'enable-terms' => '1',
            'enable-privacy' => '1',
            'layout' => 'center',
            'blogName' => 'Platonics',
            'blogDesc' => '',
            'positions' => ['hidden', 'banner', 'left', 'right', 'top', 'bottom']
        ],
        'cdn' => [],
        '__TEST_KEY__' => []
    ];

    /**
     * Returns the array containing the stored configuration
     * of the given key.
     *
     * If an invalid key is supplied, NULL
     * will be returned.
     *
     * If the key is not present in the database,
     * default values of the configuration
     * will be returned.
     */
    public static function getConfig($key)
    {
        if (!array_key_exists($key, self::$configurations)) {
            return null;
        }

        $configModel = self::where('key', $key)->first();

        if ($configModel == null) {
            $defaultType = self::$configurations[$key];

            if (is_array($defaultType)) {
                return $defaultType;
            } else {
                return new $defaultType;
            }
        } else {
            return unserialize($configModel->value);
        }
    }

    /**
     * Sets the configurations values against the given config key.
     *
     * Configuration parameters need to be provided as an array.
     * The config key must exist in configurations array list.
     * Given configuration parameters are used to generate
     * the class or array based on the type of the key.
     */
    public static function setConfig($key, array $config)
    {
        if (!array_key_exists($key, self::$configurations)) {
            return null;
        }

        // if the config data struture is a class,
        // then instantiate the class.
        $defaultType = self::$configurations[$key];
        if (!is_array($defaultType)) {
            $config = new $defaultType($config);
        }

        $serializedConfig = serialize($config);

        return self::updateOrCreate(['key' => $key], ['value' => $serializedConfig]);
    }

    /**
     * Deletes the configuration record for a given key
     */
    public static function delConfig($key)
    {
        if (!array_key_exists($key, self::$configurations)) {
            return null;
        }

        return self::where('key', $key)->delete();
    }
}
