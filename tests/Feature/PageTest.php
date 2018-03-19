<?php

namespace Tests\SIT;

use Tests\TestCase;
use Tests\BlogTestDataSetup;

class PageTest extends BlogTestDataSetup
{

	public function test_if_a_page_is_browsable_via_url ()
	{
		$this->get($this->page1->url)			
		  		->assertSee($this->page1->title) 
		  		->assertSee('<a href="' . $this->author->url . '">' . $this->noHTML($this->author->name) . '</a>'); 
	}

}
