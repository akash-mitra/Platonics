<?php
	// first get the list of all categories from the database table
	// Note that the below result will also add one additional 
	// property "url" with id, parent_id and name properties
	$items = App\Category::get(['id', 'parent_id', 'name'])->toArray();

	// pass the array to the builder class to automatically build the menu
	echo BladeHelper::buildSiteMenu($items); 
?>