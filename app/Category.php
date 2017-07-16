<?php

namespace App;

use App\Page;
use App\Content;

class Category extends Content
{
    protected $fillable = [
    	'name', 'slug', 'parent_id', 'description'
    ];

    // this ensure accessor property is included in the Category object
    protected $appends = ['url'];

    protected $subcategories;

    /**
     * Returns all the pages under this category
     */
    public function pages ()
    {
    	return $this->hasMany(Page::class);
    }


    /*
     * Returns the list of subcategories under this category
     */
    public function subcategories()
    {
        // return if cached to save database hit
        if (! empty($this->subcategories)) return $this->subcategories;

        $this->subcategories = $this->hasMany(self::class, 'parent_id');
        return $this->subcategories;
    }


    /*
     * Returns the parent category
     */
    public function parent()
    {
    	return $this->belongsTo(self::class, 'parent_id');
    }


    /*
     * Returns true if this category contains other categories
     */
    public function hasSubCategories ()
    {
        // check if already available in cache, requery if not
        if (empty($this->subcategories))
            return $this->subcategories()->count() > 0;
        else 
            return $this->subcategories->count() > 0;
    }


    /*
     * Returns the full URL of the category
     */
    public function getUrlAttribute()
    {
        return '/' . $this->slug;
    }

}
