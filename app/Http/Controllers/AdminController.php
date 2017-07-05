<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

	public function __construct()
	{
		// We are using a middleware closure here to minutely control
		// the access to this controller by only specific group of
		// people from author, editor and admin groups
		$this->middleware(function ($request, $next) {
		    if (Auth::user() 
		    	&& in_array (Auth::user()->type, array('Author', 'Editor', 'Admin'))) 
		    {
		    	return $next($request);
		    }

		    // if not allowed, then redirect
		    flash('You do not have permission to this page')->warning();
		    return redirect('/'); // redirecting back may create too many redirect loops
		});
	}

	protected function show ()
	{
		return view ('admin.show');
	}


	protected function users ()
	{
		$users = User::get(User::permittedAttributes())->all();
		return view('admin.users')->withUsers($users);
	}

	protected function designer ()
	{
		return view('admin.designer');
	}
}
