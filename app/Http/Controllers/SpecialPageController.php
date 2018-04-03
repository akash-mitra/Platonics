<?php

namespace App\Http\Controllers;

use URL;
use App\Page;
use App\SpecialPage;
use SimpleXMLElement;
use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;

class SpecialPageController extends BaseController
{
    

    public function __construct()
    {
        $this->middleware('admin')->except(['showAbout', 'showPrivacy', 'showTerms', 'showContact', 'showSiteMap']);
        parent::__construct();
    }


    public function index()
    {
        $specialPages = SpecialPage::select('id', 'name', 'type', 'created_at', 'updated_at')->get();
        return view('specialPage.index', compact('specialPages'));
    }


    protected function showContact()
    {
        return $this->_show('contact');
    }


    protected function showAbout()
    {
        return $this->_show('about');
    }

    protected function showPrivacy()
    {
        return $this->_show('privacy');
    }

    protected function showTerms()
    {
        return $this->_show('terms');
    }


    protected function showSiteMap($ext = 'html')
    {
        $pages = Page::with('category:id,slug,name')
                ->select('id', 'title', 'category_id', 'updated_at')
                ->whereNotNull('category_id')
                ->orderBy('category_id')
                ->get();

        if ($ext === 'html') {
            $html = '<table class="table"><thead><tr><th>Category</th><th>Page Title</th><th>Modified</th></tr></thead><tbody>';
            
            foreach ($pages as $page) {
                $html .= '<tr><td><a href="' . $page->category->url . '">' . $page->category->name . '</a></td><td><a href="' . $page->url . '">' . $page->title . '</a></td><td>' . $page->updated_at . '</td></tr>';
            }
            
            return view('specialPage.show', [
                'name' => 'Sitemap',
                'content' => $html . '</tbody></table>'
            ]);
        } elseif ($ext === 'json') {
            $arrayItemsForSiteMap = array_map(function ($page) {
                return [
                    "title" => $page['title'],
                    "loc" => URL::to('/') . $page['url'],
                    "lastmod" => $page['updated_at'],
                    "changefreq" => "daily",
                    "priority" => 0.5
                ];
            }, $pages->toArray());

            return response()->json($arrayItemsForSiteMap);
        } elseif ($ext === 'xml') {
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

            $arrayItemsForSiteMap = array_map(function ($page) {
                return [
                    "loc" => URL::to('/') . $page['url'],
                    "lastmod" => $page['updated_at'],
                    "changefreq" => "daily",
                    "priority" => 0.5
                ];
            }, $pages->toArray());

            $this->array_to_sitemap_xml($arrayItemsForSiteMap, $xml);

            $header['Content-Type'] = 'application/xml';

            return response()->make($xml->asXML(), 200, $header);
        } elseif ($ext === 'rss') {
            return abort(400, "Are you serious?");
        } else {
            return abort(400, "Invalid Sitemap format requested");
        }
    }


    private function array_to_sitemap_xml($data, &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'url' ;
            }
            if (is_array($value)) {
                $subnode = $xml_data->addChild($key);
                $this->array_to_sitemap_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }


    protected function editAbout()
    {
        $page = SpecialPage::where('type', '=', 'about')->first();

        $contents = unserialize($page->markup);

        return view('specialPage.about')->with([
            "name"       => isset($page->name) ? $page->name : '',
            "content"    => isset($contents['content']) ? $contents['content'] : '',
            "updated_at" => isset($page->updated_at)? $page->updated_at->diffForHumans() : ''
        ]);
    }



    protected function saveAbout(Request $request)
    {
        $updated_at = Carbon::now();

        SpecialPage::where('type', '=', 'about')->update([
            "name" => $request->input('header'),
            "markup" => serialize($request->input('markup')),
            "updated_at" => $updated_at
        ]);

        return response()->json([
            "status" => "success",
            "message" => "About page saved successfully",
            "data" => ["updated_at" => $updated_at->diffForHumans()]
        ]);
    }




    protected function editContact()
    {
        $page = SpecialPage::where('type', '=', 'Contact')->first();
        
        $contents = unserialize($page->markup);

        return view('specialPage.contact')->with([
            "name"       => isset($page->name)? $page->name: '',
            "content"    => isset($contents['content']) ? $contents['content']: '',
            "email"      => isset($contents['email']) ? $contents['email']: '',
            "twitter"    => isset($contents['twitter']) ? $contents['twitter']: '',
            "address"    => isset($contents['address']) ? $contents['address']: '',
            "updated_at" => isset($page->updated_at) ? $page->updated_at->diffForHumans() : ''
        ]);
    }


    protected function saveContact(Request $request)
    {
        $updated_at = Carbon::now();
        SpecialPage::where('type', '=', 'Contact')->update([
            "name" => $request->input('header'),
            "markup" => serialize($request->input('markup')),
            "updated_at" => $updated_at
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Contact page saved successfully",
            "data" => ["updated_at" => $updated_at->diffForHumans()]
        ]);
    }



    protected function editPrivacy()
    {
        $page = SpecialPage::where('type', '=', 'privacy')->first();

        $contents = unserialize($page->markup);

        return view('specialPage.privacy')->with([
            "name" => isset($page->name) ? $page->name : '',
            "content" => isset($contents['content']) ? $contents['content'] : '',
            "updated_at" => isset($page->updated_at) ? $page->updated_at->diffForHumans() : ''
        ]);
    }


    protected function savePrivacy(Request $request)
    {
        $updated_at = Carbon::now();

        SpecialPage::where('type', '=', 'privacy')->update([
            "name" => $request->input('header'),
            "markup" => serialize($request->input('markup')),
            "updated_at" => $updated_at
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Privacy page saved successfully",
            "data" => ["updated_at" => $updated_at->diffForHumans()]
        ]);
    }



    protected function editTerms()
    {
        $page = SpecialPage::where('type', '=', 'terms')->first();

        $contents = unserialize($page->markup);

        return view('specialPage.terms')->with([
            "name" => isset($page->name) ? $page->name : '',
            "content" => isset($contents['content']) ? $contents['content'] : '',
            "updated_at" => isset($page->updated_at) ? $page->updated_at->diffForHumans() : ''
        ]);
    }


    protected function saveTerms(Request $request)
    {
        $updated_at = Carbon::now();

        SpecialPage::where('type', '=', 'terms')->update([
            "name" => $request->input('header'),
            "markup" => serialize($request->input('markup')),
            "updated_at" => $updated_at
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Terms page saved successfully",
            "data" => ["updated_at" => $updated_at->diffForHumans()]
        ]);
    }



    private function _show($type)
    {
        $page = SpecialPage::where('type', $type)->first();

        return view('specialPage.show', [
            'name' => $page->name,
            'content' => unserialize($page->markup)['content']
        ]);
    }
}
