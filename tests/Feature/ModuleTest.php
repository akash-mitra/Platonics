<?php

namespace Tests\SIT;

use App\Module;
use Tests\TestCase;
use Tests\BlogTestDataSetup;

class ModuleTest extends BlogTestDataSetup
{

    public function test_a_module_can_be_created ()
    {
        $data = [
            "name" => str_random(15),
            "type" => 'custom',
            "config" => [
                "content" => "Some <b>HTML</b> Texts."
            ]
        ];
        $this->actingAs($this->admin)
            ->patch(route('module-update'), $data)
            ->assertSuccessful()
            ->assertJsonFragment([
                "status" => "success",
                "message" => "Module successfully created.",
                "url"
            ]);
    }

    public function test_existing_module_can_be_accessed_by_admin()
    {
        
        $this->actingAs($this->admin)
            ->get(route('module-show', $this->customModule->id))
            ->assertSuccessful();
    }


    public function test_existing_module_can_not_be_accessed_by_non_admin()
    {
        $this->actingAs($this->author)
            ->get(route('module-show', $this->customModule->id))
            ->assertStatus(302);
    }

    public function test_existing_module_can_be_updated ()
    {
        $data = [
            "id" => $this->customModule->id,
            "name" => $this->customModule->name . ' -Updated',
            "type" => "custom",
            "config" => [
                "content" => "TRACER CONTENT"
            ]
        ];

        $this->actingAs($this->admin)
            ->patch(route('module-update'), $data)
            ->assertSuccessful()
            ->assertJsonFragment([
                "status" => "success",
                "message" => "Module successfully updated.",
                "url"
            ]);

        $this->actingAs($this->admin)
                ->get(route('module-show', ["type" => "custom", "id" => $this->customModule->id]))
                ->assertSee('TRACER CONTENT');

    }

    public function test_existing_module_can_be_deleted ()
    {
        $this->actingAs($this->admin)
            ->post(route('module-delete'), ["id" => $this->customModule->id])
            ->assertSuccessful()
            ->assertJsonFragment([
                "status" => "success",
                "message" => "Module successfully deleted",
            ]);
    }


    public function test_module_position_can_be_saved ()
    {
        $moduleVisibility = [
            "moduleId" => $this->customModule->id,
            "position" => "left",
            "categories" => array($this->category->id, $this->category3->id),
            "exceptions" => $this->page4->id
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('module-visibility'), $moduleVisibility)
            ->assertSuccessful();

        //dump($response->baseResponse->original);

        $response->assertJson([
                "status" => "success",
                "message" => "Module Visibility Stored Successfully",
                "meta" => [
                    "left" => [
                        $this->customModule->id => [
                            "id" => $this->customModule->id,
                            "position" => "left",
                            "visible" => [$this->category->id, $this->category3->id],
                            "exceptions" => [$this->page4->id]
                        ]
                    ]
                ]
            ]);
    }


    public function test_module_is_viewable_only_in_category_selected ()
    {
        $moduleVisibility = [
            "moduleId" => $this->customModule2->id,
            "position" => "bottom",
            "categories" => array($this->category3->id),
            "exceptions" => $this->page4->id
        ];

        $this->actingAs($this->admin)
            ->post(route('module-visibility'), $moduleVisibility)
            ->assertSuccessful();

        // the module is visible in selected category
        $this->get($this->category3->url)
            ->assertSee('Some <b>HTML</b> Texts');

        // not visible in other category
        $this->get($this->category->url)
            ->assertDontSee('Some <b>HTML</b> Texts');
        $this->get($this->category2->url)
            ->assertDontSee('Some <b>HTML</b> Texts');

        // visible in the article page of the selected category
        $this->get($this->page3->url)
            ->assertSee('Some <b>HTML</b> Texts');

        // not visible in exception article
        $this->get($this->page4->url)
            ->assertDontSee('Some <b>HTML</b> Texts');
        
    }



    public function test_new_comment_module_can_be_created ()
    {
        $this->actingAs($this->admin)
            ->patch(route('module-update'), [
                "name" => "Comment Module",
                "type" => "comments",
                "config" => []
            ])
            ->assertSuccessful();

        $module = Module::where('type', 'comments')->first();

        $this->actingAs($this->admin)
            ->post(route('module-visibility'), [
                "moduleId"   => $module->id,
                "position"   => "bottom",
                "categories" => array($this->category3->id),
                "exceptions" => '1'
            ])->assertSuccessful();

        $this->get($this->page3->url)
            ->assertSee("Comments")
            ->assertSee('js/comments.js">');
    }
}