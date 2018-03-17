<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use Carbon\Carbon;
use App\Configuration;
use App\Config\BlogConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends BaseController
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

		parent::__construct();
	}

	protected function show ()
	{
		return view ('admin.show');
	}


	/**
	 * Shows a list of all the users registered to the platform
	 */
	protected function users ()
	{
		$users = User::get(User::permittedAttributes())->all();
		return view('admin.users')->withUsers($users);
	}



	/**
	 * Shows a list of all the comments made to any
	 * page in past days (default: past 90 days) 
	 */
	protected function comments($pastDays = 90)
	{
		$comments = Comment::with(['user', 'page:id,title'])
					->whereDate('comments.created_at', '>=', Carbon::today()->subDays($pastDays)->toDateString())
					->orderBy('page_id', 'created_at')
					->paginate(50);
		
					return view('admin.comments')->withComments($comments);
	}


	/**
	 * Permanently deletes a specific comment
	 */
	protected function deleteComment ($id)
	{
		$comment= Comment::findOrFail($id);
		
		$comment->delete();
		
		flash('Comment deleted successfully')->success();
		
		return redirect()->route('admin-comments');
	}



	protected function design ()
	{
		//$blog = Configuration::retrieveObjectByKey('blog', BlogConfig::class);

		return view('admin.design');
	}

}
