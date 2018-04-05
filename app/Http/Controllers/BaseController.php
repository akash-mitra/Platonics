<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

/**
 * Use BaseController when you need to inject
 * additional meta data information to page
 */
class BaseController extends Controller
{
    protected $meta;

    public function __construct()
    {
        $this->meta = Cache::remember('blogmeta', 60, function () {
            $meta = Configuration::where('key', 'blogmeta')->first()->value;

            return unserialize($meta);
        });

        View::share('meta', $this->meta);
    }
}
