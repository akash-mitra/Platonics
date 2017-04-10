<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('index'); })->name('homepage');

/* 
 |--------------------------------------------------------------------------
 | User authentication and profile related routes 
 |--------------------------------------------------------------------------
 */
Auth::routes();
Route::get('/redirect/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');
Route::get('/profile', 'ProfileController@self')->name('profile');
Route::get('/profile/user/{slug}', 'ProfileController@user')->name('user');

Route::post('/profile/user/change/type', 'ProfileController@setType')->name('user-change-type');
Route::post('/profile/user/delete', 'ProfileController@delete')->name('delete-user');
/* 
 |--------------------------------------------------------------------------
 | admin user and related routes 
 |--------------------------------------------------------------------------
 */
Route::get('/admin', 'AdminController@show')->name('admin');
Route::get('/admin/users', 'AdminController@users')->name('admin-users');

/* 
 |--------------------------------------------------------------------------
 | Category related routes that only admin can access
 |--------------------------------------------------------------------------
 */
Route::get('/admin/categories', 'CategoryController@list')->name('category-list');
Route::get('/admin/category/create', 'CategoryController@create')->name('category-create');
Route::post('/admin/category/store', 'CategoryController@store')->name('category-store');
Route::get('/admin/category/edit/{id}', 'CategoryController@edit')->name('category-edit');
Route::patch('/admin/category/save', 'CategoryController@save')->name('category-save');

/* 
 |--------------------------------------------------------------------------
 | Blogging related routes that only admin can access
 |--------------------------------------------------------------------------
 */
Route::get('/admin/articles', 'ArticleController@index')->name('article-index');
Route::get('/admin/article/create', 'ArticleController@create')->name('article-create');
Route::post('/admin/article/store', 'ArticleController@store')->name('article-store');
Route::get('/admin/article/edit/{id}', 'ArticleController@edit')->name('article-edit');
Route::patch('/admin/article/save', 'ArticleController@save')->name('article-save');


/* 
 |--------------------------------------------------------------------------
 | General blogging routes for displaying blog contents
 |--------------------------------------------------------------------------
 */
Route::get('/article/{slug}', 'ArticleController@show')->name('article-view');
Route::get('/category/{slug}', 'CategoryController@show')->name('category-view');

Route::get('/api/v1/get/categories', 'API\v1\ApiCategoryController@getCategories')->name('api-categories');
