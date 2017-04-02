<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	protected function self()
	{
		$user = Auth::user();
		return view('profile.index', compact('user'));	
	}


	protected function user ($slug)
	{
		$user = User::whereSlug($slug)
			->get($this->profileVisibility(Auth::user()->type))
		             	->first();
		return view('profile.index', compact('user'));	
	}


	protected function setType (Request $request)
	{
		$type = $request->input('type');
		$slug = $request->input('slug');

		// only admins can change profile type
		if (Auth::user()->type != 'Admin') 
			return response('Unauthorised action', 403);

		// update the type
		$user = User::whereSlug($slug)->first();
		$user->setType ($type);

		return response('done');
	}




	private function profileVisibility ($lookerType)
	{
		if ($lookerType == 'Registered') 
			return ['name', 'avatar', 'created_at', 'updated_at'];
		if ($lookerType == 'Admin') 
			return ['name', 'avatar', 'email', 'created_at', 'updated_at', 'slug'];
		return ['slug'];
	}
}
