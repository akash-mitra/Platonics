<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Page;
use App\SpecialPage;

class HomepageController extends BaseController
{
    public function get()
    {
        //TODO
        // need cache
        $featured = Page::featured()
                    ->select('id', 'category_id', 'title', 'intro', 'created_at', 'updated_at')
                    ->latest()
                    ->get();
        
        //TODO
        // need cache
        $latest   = Page::latest()
                    ->select('id', 'category_id', 'title', 'intro', 'created_at', 'updated_at')
                    ->take(3)
                    ->get();
        
        return view('homepage.default', [
            "featured" => $featured,
            "latest" => $latest
        ]);
    }
}
