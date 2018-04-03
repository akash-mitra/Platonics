<?php

namespace App\Config;

use App\Configuration;

/**
 * Represents the configurations for the Blog
 */
class BlogConfig
{


    /**
     * Name of the Blog
     */
    public $blogName, $blogDesc;

    /**
     * Layout of the blog. 3 Possible values are -
     * center, left, right.
     */
    public $layout;

    /**
     * Color classes
     */
    public $bgColorPrimary = '#FFFFFF';


    /**
     * Saves the Blog Configuration to the database
     */
    public function save()
    {
        return Configuration::persist('blog', json_encode($this), true);
    }


    /**
     * Sets the blog layout
     *
     * @param string layout
     *
     */
    public function layout($layout)
    {
        $this->layout = $layout;
        return $this;
    }



    /**
     * Sets the blog Name
     *
     * @param string blogName
     *
     */
    public function blogName($blogName)
    {
        $this->blogName = $blogName;
        return $this;
    }



    /**
     * Sets the blog Description
     *
     * @param string blogDesc
     *
     */
    public function blogDesc($blogDesc)
    {
        $this->blogDesc = $blogDesc;
        return $this;
    }


    public function bgColorPrimary($color)
    {
        $this->bgColorPrimary = $color;
        return $this;
    }
}
