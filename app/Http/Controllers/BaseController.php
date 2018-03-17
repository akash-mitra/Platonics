<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    protected $meta; 

    public function __construct ()
    {
        
        $this->meta = unserialize (Configuration::where('key', 'blog')->first()->value); 

        View::share('meta', $this->meta);
    }

    // $this->meta = ["bg-color-primary" => "#FFFFFF",
    //     "enable-terms" => "1",
    //     "enable-privacy" => "1",
    //     "layout" => "right",
    //     "blogName" => "BDO Birpara Madarihat",
    //     "blogDesc" => "1",
    //     "enable-about" => "0",
    //     "left-modules" => ["about", "popular"]];

    
}
