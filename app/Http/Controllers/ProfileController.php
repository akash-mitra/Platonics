<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseController
{

	public function __construct()
	{
		$this->middleware('auth');
		parent::__construct();
	}


	protected function user ($slug = null)
	{
		// $slug will be null if an anuthenticated
		// user wants to visit his/her own profile
		if ($slug == null) 
		{
			$user = Auth::user()->load('comments');
		}
		else 
		{
			$user = User::whereSlug($slug)
					->with('comments')
					->get(User::permittedAttributes())
					->first();
		}

		// if user does not exists, return
		if(empty($user)) abort(404, 'Page does not exist');

		// get all article pages and comments written by this user
		$pages = $user->articles();
		
		return view('profile.index', [
			'user' => $user, 
			'pages' => $pages,
			]);	
	}


	protected function setType (Request $request)
	{
		// only admins can change profile type
		if (Auth::user()->type != 'Admin') 
			return response('Unauthorised action', 403);
		
		$type = $request->input('type');
		$slug = $request->input('slug');

		// update the type
		$user = User::whereSlug($slug)->first();
		$user->setType ($type);

		return response('done');
	}
}
