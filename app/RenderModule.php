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
    public static function getModuleHTML($moduleId, $module, $pageMeta)
    {
        if (self::_isModuleVisible($module, $pageMeta)) {
            //TODO vari varkam cache needed
            $contents = DB::table('modules')->select('type', 'config')->where('id', $moduleId)->first();
            
            $config   = unserialize($contents->config);

            if ($contents->type === 'comments') {
                self::$scripts ["comments.js"] = true;
                
                return view('partials.comment.show', ['page_id' => $pageMeta['page_id']])->render();
            }
            
            if ($contents->type === 'custom') {
                return self::_renderCustomHTMLModule($config);
            }

            if ($contents->type === 'related') {
                self::$scripts["related.js"] = true;

                return self::_renderRelatedArticlesModule($config, $pageMeta);
            }
        }

        return '';
    }



    /**
     * Returns the correspoding JavaScript code if
     * needed by the module
     */
    public static function getModuleScripts()
    {
        $scriptsUrl = '';

        foreach (self::$scripts as $script => $value) {
            $scriptsUrl .= '<script defer src="' . url('/js/' . $script) . '"></script>' . PHP_EOL;
        }

        return $scriptsUrl;
    }
    

    /**
     * Helper function for custom HTML module
     */
    private static function _renderCustomHTMLModule($config)
    {
        return $config['content'];
    }



    /**
     * Helper function for Related Articles (articles under the same category)
     */
    private static function _renderRelatedArticlesModule($config, $pageMeta)
    {
        if (! isset($pageMeta['category_id'])) {
            return;
        }

        $header = (isset($config['header']) ? '<h3>' . $config['header'] . '</h3>' : '');
        $count  = (isset($config['count']) ? $config['count']: 5);
        
        $related = '<div class="related-module" data-category-id="'
                        . $pageMeta['category_id']
                        . '" data-max-count="'
                        . $count
                        . '"></div>';
        
        return $header . $related;
    }



    /**
     * Helper function to do all the heavy lifting to
     * determine of the module should be visible on
     * the given page
     */
    private static function _isModuleVisible($module, $pageMeta)
    {
        $category_inclusion = false;
        $article_exclusion  = false;

        if (!empty($module['visible'])) {
            foreach ($module['visible'] as $key => $val) {
                if ($val == $pageMeta['category_id']) {
                    $category_inclusion = true;
                    break;
                }
            }
        }

        if (! empty($module['exceptions'])) {
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
