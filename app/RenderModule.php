<?php

namespace App;
use DB;
class RenderModule 
{
    //protected $fillable = ['name', 'html'];

    public static function getModuleHTML ($module)
    {
        $head = ''; 
        $content = '';
        
        if ($module === 'about') 
        {
            //TODO vari varkam cache needed
            $contents = DB::table('special_pages')->select('name', 'markup')->where('type', 'about')->first();
            $module = ucwords($contents->name);     
            $content = unserialize($contents->markup)['content'];

            return self::_html($module, $content);
        }

        
    }
    

    private static function _html ($head, $contents)
    {
        $html = '<div class ="p-3 mb-3 bg-light border rounded"><h4>' . $head . '</h4><div class ="my-1">' . $contents . '</div></div>';
        return $html;
    }
}
