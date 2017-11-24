<?php

namespace App\Http\Controllers;

use App\Image;
use App\Configuration;
use Illuminate\Http\Request;

class ImageController extends Controller
{
	public function __constructor () {
		//$this->middleware('admin');
	}

	public function store () 
	{
		return Image::validateAndStore(
			request()->file('file'), 
			1, 
			['jpeg', 'jpg', 'png', 'bmp', 'gif']
			);
	}
}