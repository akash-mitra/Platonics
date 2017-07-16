<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
	protected $fillable = ['key', 'value'];

	/** 
	 * Saves the value against the given key. If the key is 
	 * already existing, replace the old value with new one. 
	 */
	protected function persist ($key, $val, $overwrite = true)
	{
		if (empty($key)) return -1;

		if ($overwrite) {
			$this->remove($key);
		}

		$record = new Configuration(["key" => $key, "value" => $val]);
		return $record->save();
	}


	/**
	 * Retrieves an object against the given key. The value of the
	 * key is present under the "value" property of the returned object.
	 */ 
	protected function retrieve ($key)
	{
		if (empty($key)) return null;

		return Configuration::where('key', '=', $key)->get()->first();
	}


	/** 
	 * Returns the value of the given key
	 */
	protected function retrieveValue ($key)
	{
		if (empty($key)) return null;

		return Configuration::where('key', '=', $key)->get()->first()->value;
	}


	/** 
	 * Deletes the given key from the configuration store
	 */
	protected function remove ($key)
	{
		if (empty($key)) return null;

		return Configuration::where('key', '=', $key)->delete();
	}


	/** 
	 * Returns the value of the given key casted to the given class.
	 * If the value is null, it returns empty object of the class.
	 */
	protected function retrieveObjectByKey ($key, $class)
	{
		$conf = $this->retrieve($key);

		if (empty($conf)) {
			return new $class;
		}
		else {
			$data = json_decode($conf->value, true);
			$customClass = new $class;
			foreach ($data as $key => $value) $customClass->{$key} = $value;
			return $customClass;
		}
	}
}
