<?php

namespace App;

use DB;

class RenderModule 
{

    /** 
     * Certain modules may need certain JavaScript file to be included
     * with the page. This variable keeps track of those JavaScripts
     */
    public static $scripts = [];



    /** 
     * Returns the module related HTML code to the page after
     * checking if the module should be visible on that page 
     */
    public static function getModuleHTML ($moduleId, $module, $pageMeta)
    {
        if (self::_isModuleVisible ($module, $pageMeta))
        {
            //TODO vari varkam cache needed
            $contents = DB::table('modules')->select('type', 'config')->where('id', $moduleId)->first();
            
            $config   = unserialize($contents->config);

            if ($contents->type === 'comments') 
            {
                self::$scripts ["comments.js"] = true;
                
                return view('partials.comment.show', ['page_id' => $pageMeta['page_id']])->render();
            }
            
            if ($contents->type === 'custom') 
            {
                return self::_renderCustomHTMLModule($config);
            }
        }

        return '';
    }



    /**
     * Returns the correspoding JavaScript code if
     * needed by the module
     */
    public static function getModuleScripts ()
    {
        $scriptsUrl = '';

        foreach(self::$scripts as $script => $value)
        {
            $scriptsUrl .= '<script src="' . url('/js/' . $script) . '"></script>' . PHP_EOL;
        }

        return $scriptsUrl;
    }
    

    /**
     * Helper function for custom HTML module
     */
    private static function _renderCustomHTMLModule ($config)
    {
        return $config['content'];
    }



    /**
     * Helper function to do all the heavy lifting to
     * determine of the module should be visible on
     * the given page
     */
    private static function _isModuleVisible ($module, $pageMeta)
    {
        $category_inclusion = false;
        $article_exclusion  = false;

        if (!empty($module['visible']))
        {
            foreach ($module['visible'] as $key=>$val) {
                if ($val == $pageMeta['category_id']) {
                    $category_inclusion = true;
                    break;
                }
            }
        }

        if (! empty($module['exceptions']))
        {
            foreach ($module['exceptions'] as $id) {
                if ($id == $pageMeta['page_id']) {
                    $article_exclusion = true;
                    break;
                }
            }
        }

        return $category_inclusion && !$article_exclusion;
    }
}
