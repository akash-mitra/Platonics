<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	protected function user ($slug = null)
	{
		// $slug will be null if an anuthenticated
		// user wants to visit his/her own profile
		if ($slug == null) $user = Auth::user();
		else $user = User::whereSlug($slug)
			->get($this->profileVisibility(Auth::user()->type))
			->first();

		if(empty($user)) 
    			return response()->view('errors.404', [], 404);
		

		// get all article pages written by this user				
		$pages = $user->articles();
		
		return view('profile.index', ['user' => $user, 'pages' => $pages]);	
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
			return ['id', 'name', 'avatar', 'created_at', 'updated_at'];
		if ($lookerType == 'Admin') 
			return ['id', 'name', 'avatar', 'email', 'created_at', 'updated_at', 'slug'];
		return ['id', 'slug'];
	}
}
