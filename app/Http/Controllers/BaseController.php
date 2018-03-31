<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Support\Facades\View;

/**
 * Use BaseController when you need to inject
 * additional meta data information to page
 */
class BaseController extends Controller
{
    protected $meta; 

    public function __construct ()
    {   
        $this->meta = unserialize (Configuration::where('key', 'blog')->first()->value); 

        View::share('meta', $this->meta);
    }
}
