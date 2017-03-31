<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected function show ()
    {
    	return view ('admin.show');
    }


   protected function users ()
   {
   	$users = User::all();
   	return view('admin.users')->withUsers($users);
   }
}
