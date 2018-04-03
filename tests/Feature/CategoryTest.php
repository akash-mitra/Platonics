<?php

namespace Tests\SIT;

use Tests\BlogTestDataSetup;

class CategoryTest extends BlogTestDataSetup
{
    

    public function test_if_a_category_and_its_contents_are_viewable_via_url()
    {
        // when I visit the category url,
        $this->get($this->category->slug)
        // then I am able to see the category description
            ->assertSee($this->category->description)
        // and I am able to see the page1 intro text (as page1 is setip in category)
            ->assertSee($this->page1->intro);
    }



    public function test_if_a_category_model_can_retrieve_all_pages_in_it()
    {
        $pages = $this->category3->pages;
    
        $this->assertCount(2, $pages);
    }


    public function test_if_top_level_categories_are_displayed_in_menu()
    {
        // given we have top level categories (1 and 2)
        // with these names
        $name1 = $this->category->name;
        $name2 = $this->category2->name;

        // when we vist the homepage
        $this->get('/')
            ->assertSee($name1)
            ->assertSee($name2);
    }


    public function test_categories_api_list_returns_all_categories()
    {
        $this->get(route('api-categories'))
            ->assertJsonStructure(["*" => ["record", "parent_record", "label"]])
            ->assertSuccessful();
    }
}
