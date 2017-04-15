<?php

use App\Article;
use App\Category;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // setup
    	$noOfUsers = 10;
    	$noOfCategories = 7;
    	$noOfParentCategories = 2;
    	$maxArticlePerCategory = 10;

        // create a few users
        $userIds = factory(User::class, $noOfUsers)->create()->pluck('id')->all();

        // create a few parent level categories
        $parentCategories = factory(Category::class, $noOfParentCategories)->create()->pluck('id')->all();

        // then create a few categories 
    	$categories = factory(Category::class, $noOfCategories)->create([
    			"parent_id" => function() use ($parentCategories) {
    				$r = rand(1,100);
    				if ($r <= 50) return null;
    				if ($r > 50 && $r <= 75) return $parentCategories[0];
    				else $parentCategories[1];
    			},
    		])
    		// and under each of these categories
    		->each(function ($category) use ($maxArticlePerCategory, $noOfUsers, $userIds) {
    			// create articles
    			$articles = factory(Article::class, rand(0, $maxArticlePerCategory))
    				->make([
    					// written by one of the users previously created
    					'user_id' => function () use ($noOfUsers, $userIds) { 
    						return $userIds[rand(0, $noOfUsers-1)];
    						}
    					]);
    			$category->articles()->saveMany($articles);
    		});
    }
}
