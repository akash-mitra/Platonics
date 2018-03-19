<?php

namespace Tests\SIT;

use Tests\BlogTestDataSetup;

class AdminConsoleTest extends BlogTestDataSetup
{

    public function test_admin_can_access_admin_console()
    {
        $this->actingAs($this->admin)
            ->get(route('admin'))
            ->assertSuccessful()
            ->assertSee($this->admin->name);
    }

    public function test_general_auth_users_can_not_access_admin_console()
    {
        $this->actingAs($this->user)
            ->get(route('admin'))
            ->assertStatus(302);
    }


    /* ------------------------------------------------------------------
     * ADMIN > Pages : Related Test Cases
     * ------------------------------------------------------------------ */

    public function test_that_admin_can_open_pages ()
    {
        $this->actingAs($this->admin)
            ->get(route('page-index'))
            ->assertSee($this->page1->title)
            ->assertSuccessful();
    }

    public function test_that_editor_can_open_pages()
    {
        $this->actingAs($this->editor)
            ->get(route('page-index'))
            ->assertSuccessful();
    }

    public function test_that_author_can_open_pages()
    {
        $this->actingAs($this->author)
            ->get(route('page-index'))
            ->assertSuccessful();
    }

    public function test_that_non_administrative_users_can_not_open_pages()
    {
        $this->actingAs($this->user)
            ->get(route('page-index'))
            ->assertStatus(302);
    }

    public function test_admin_can_access_page_editor ()
    {
        $this->actingAs($this->admin)
            ->get(route('page-editor'))
            ->assertSuccessful();
    }

    public function test_author_can_access_page_editor()
    {
        $this->actingAs($this->author)
            ->get(route('page-editor'))
            ->assertSuccessful();
    }

    public function test_editor_can_access_page_editor()
    {
        $this->actingAs($this->editor)
            ->get(route('page-editor'))
            ->assertSuccessful();
    }

    public function test_non_administrative_users_can_not_access_page_editor()
    {
        $this->actingAs($this->user)
            ->get(route('page-editor'))
            ->assertStatus(302);
    }

    public function test_page_editor_can_open_an_existing_article ()
    {
        $this->actingAs($this->admin)
            ->get(route('page-editor', $this->page1->id))
            ->assertSee($this->page1->title)
            ->assertSee($this->page1->intro);
    }

    public function test_a_new_page_can_be_saved ()
    {
        $newPage = [
            "title" => "Test Page", 
            "intro" => "Just a test", 
            "markup" => "The main contents",
            "publish" => "1"
        ];

        $this->actingAs($this->author)
            ->post(route('page-save'), $newPage)
            ->assertSuccessful();
    }


    public function test_admin_can_edit_page ()
    {
        $this->can_save_page_edit ($this->admin, $this->page2);
    }


    public function test_editor_can_edit_page()
    {
        $this->can_save_page_edit ($this->editor, $this->page4);
    }


    public function test_author_can_edit_own_page ()
    {
        // $this->author created page1 and page2
        $this->can_save_page_edit ($this->author, $this->page2);
    }

    public function test_author_can_not_edit_others_page()
    {
        // $this->author created page1 and page2, so test with page4
        $this->can_not_save_page_edit($this->author, $this->page4);
    }


    /* ------------------------------------------------------------------
     * ADMIN > Category : Related Test Cases
     * ------------------------------------------------------------------ */
     
    public function test_admin_can_view_category()
    {
        $this->can_view_admin_category_list($this->admin);
    }

    public function test_editor_can_view_category()
    {
        $this->can_view_admin_category_list($this->editor);
    }

    public function test_author_can_view_category()
    {
        $this->can_view_admin_category_list($this->author);
    }

    public function test_non_admin_users_can_not_view_category()
    {
        $this->can_not_view_admin_category_list($this->user);
    }

    public function test_admin_can_open_new_category_form()
    {
        $this->actingAs($this->admin)
            ->get(route('category-create'))
            ->assertSuccessful()
            ->assertSee('Create New Category');
    }

    public function test_non_administrative_users_can_not_open_new_category_form()
    {
        $this->actingAs($this->user)
            ->get(route('category-create'))
            ->assertStatus(302);
    }

    public function test_admin_can_create_new_category()
    {
        $data = [
            "head" => "Test Category",
            "url" => "test_category"
        ];

        $this->actingAs($this->admin)
            ->post(route('category-store'), $data)
            ->assertRedirect(route('category-index'));

        $lastSavedCategory = \App\Category::max('id');
        $categoryName = \App\Category::whereId($lastSavedCategory)->pluck('name')->first();
        
        $this->assertEquals($categoryName, $data["head"]);
    }

    public function test_admin_can_open_category_edit_page ()
    {
        $this->actingAs($this->admin)
            ->get(route('category-edit', $this->category->id))
            ->assertSuccessful()
            ->assertSee($this->category->name);
    }

    public function test_admin_can_update_existing_category ()
    {
        // load the existing category3 in a new variable "data"
        $data = [
            "id" => $this->category3->id,
            "cat" => $this->category3->parent_id,
            "head" => $this->category3->name,
            "url" => $this->category3->slug,
            "body" => $this->category3->description
        ];

        // change the name/head
        $data["head"] = $data["head"] . " (Added for Testing)";
        
        // attempt to update
        $this->actingAs($this->admin)
            ->patch(route('category-save'), $data)
            ->assertRedirect(route('category-edit', $this->category3->id));

        // check if it has actually got updated
        $this->get(route('category-view', $this->category3->slug))
            ->assertSee($data["head"]);
    }


    public function test_non_admins_can_not_update_existing_category()
    {
        // load the existing category3 in a new variable "data"
        $data = [
            "id" => $this->category3->id,
            "cat" => $this->category3->parent_id,
            "head" => $this->category3->name,
            "url" => $this->category3->slug,
            "body" => $this->category3->description
        ];

        // change the name/head
        $data["head"] = $data["head"] . " (Added for Testing)";
        
        // attempt to update
        $this->actingAs($this->editor)
            ->patch(route('category-save'), $data)
            ->assertStatus(302);

        $this->actingAs($this->author)
            ->patch(route('category-save'), $data)
            ->assertStatus(302);

        $this->patch(route('category-save'), $data)
            ->assertStatus(302);
    }


    public function test_parent_id_of_category_can_not_be_one_of_descendants_id()
    {
        // we will try to update category's parent_id with category3's id
        $data = [
            "id" => $this->category->id,
            "cat" => $this->category3->id, // changing to category3's Id
            "head" => $this->category->name,
            "url" => $this->category->slug,
            "body" => $this->category->description
        ];
        
        $this->actingAs($this->admin)
            ->patch(route('category-save'), $data)
            ->assertRedirect(route('category-edit', $this->category->id));

        $parent_id = \App\Category::whereId(1)->pluck('parent_id')->first();
        
        $this->assertEquals($parent_id, $this->category->parent_id); // parent ID has not been changed.
    }









    /* ------------------------------------------------------------------
     * Private Functions
     * ------------------------------------------------------------------ */

    private function can_save_page_edit ($user, $page)
    {
        $editPage = [
            "id" => $page->id,
            "intro" => "This line is modified by automated test script"
        ];
        $this->actingAs($user)
            ->post(route('page-save', $editPage))
            ->assertSuccessful();

        $this->get($page->url)
            ->assertSee($editPage["intro"]);
    }

    private function can_not_save_page_edit($user, $page)
    {
        $editPage = [
            "id" => $page->id,
            "intro" => "This line is modified by automated test script"
        ];
        $this->actingAs($user)
            ->post(route('page-save', $editPage))
            ->assertStatus(302);
    }

    private function can_view_admin_category_list ($user)
    {
        $this->actingAs($user)
            ->get(route('category-index'))
            ->assertSuccessful()
            ->assertSee('Categories')
            ->assertSee($this->category->name)
            ->assertSee($this->category2->name)
            ->assertSee($this->category3->name);
    }

    private function can_not_view_admin_category_list ($user)
    {
        $this->actingAs($user)
            ->get(route('category-index'))
            ->assertStatus(302);
    }
}
