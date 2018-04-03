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
Route::get('/', 'HomepageController@get')->name('homepage');


/* 
 |--------------------------------------------------------------------------
 | General blogging routes for displaying blog contents
 |--------------------------------------------------------------------------
 */
Route::get('/admin/pages', 'AdminController@pages')->name('page-index');
Route::get('/admin/categories', 'AdminController@categories')->name('category-index');


/* 
 |--------------------------------------------------------------------------
 | User authentication and profile related routes 
 |--------------------------------------------------------------------------
 */
// disabling the default login routes as we will only use social login
// Auth::routes();
// only relevant login routes are selected below.
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/redirect/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');
Route::get('/profile', 'ProfileController@user')->name('profile');
Route::get('/profile/{slug}', 'ProfileController@user')->name('user');
Route::post('/profile/user/change/type', 'ProfileController@setType')->name('user-change-type');
Route::post('/profile/user/delete', 'ProfileController@delete')->name('delete-user');


/* 
 |--------------------------------------------------------------------------
 | ADMIN user and related routes 
 |--------------------------------------------------------------------------
 */
Route::get('/admin', 'AdminController@show')->name('admin');
Route::get('/admin/users', 'AdminController@users')->name('admin-users');
Route::get('/admin/comments', 'AdminController@comments')->name('admin-comments');
Route::get('/admin/comments/delete/{id}', 'AdminController@deleteComment')->name('comment-delete');
Route::get('/admin/design', 'AdminController@design')->name('admin-design');
Route::post('/admin/layout/change', 'ConfigurationController@changeLayout')->name('change-layout');
Route::post('/admin/blog/general', 'ConfigurationController@saveBlog')->name('save-blog');
Route::post('/admin/blog/color', 'ConfigurationController@saveColor')->name('save-color');

/* 
 |--------------------------------------------------------------------------
 | Special Page related routes 
 |--------------------------------------------------------------------------
 */
Route::get('/admin/special-pages', 'SpecialPageController@index')->name('special-page-index');
Route::get('/contact-us', 'SpecialPageController@showContact')->name('show-contact');
Route::get('/about-us', 'SpecialPageController@showAbout')->name('show-about');
Route::get('/privacy-policy', 'SpecialPageController@showPrivacy')->name('show-privacy');
Route::get('/terms-of-use', 'SpecialPageController@showTerms')->name('show-terms');
Route::get('/sitemap/{ext?}', 'SpecialPageController@showSiteMap')->name('show-sitemap');

/* 
 |--------------------------------------------------------------------------
 | Special Page related routes that only admin can access
 |--------------------------------------------------------------------------
 */
Route::get('/admin/special-pages/terms', 'SpecialPageController@editTerms')->name('special-pages-terms');
Route::post('/admin/special-pages/terms', 'SpecialPageController@saveTerms')->name('special-pages-terms-save');
Route::get('/admin/special-pages/privacy', 'SpecialPageController@editPrivacy')->name('special-pages-privacy');
Route::post('/admin/special-pages/privacy', 'SpecialPageController@savePrivacy')->name('special-pages-privacy-save');
Route::get('/admin/special-pages/about', 'SpecialPageController@editAbout')->name('special-pages-about');
Route::post('/admin/special-pages/about', 'SpecialPageController@saveAbout')->name('special-pages-about-save');
Route::get('/admin/special-pages/contact', 'SpecialPageController@editContact')->name('special-pages-contact');
Route::post('/admin/special-pages/contact', 'SpecialPageController@saveContact')->name('special-pages-contact-save');
/* 
 |--------------------------------------------------------------------------
 | Category related routes that only admin can access
 |--------------------------------------------------------------------------
 */
Route::get('/admin/category/create', 'AdminController@createCategory')->name('category-create');
Route::post('/admin/category/store', 'AdminController@storeCategory')->name('category-store');
Route::get('/admin/category/edit/{id}', 'AdminController@editCategory')->name('category-edit');
Route::patch('/admin/category/save', 'AdminController@saveCategory')->name('category-save');

/* 
 |--------------------------------------------------------------------------
 | Blogging related routes that only admin can access
 |--------------------------------------------------------------------------
 */
Route::get('/admin/page/editor/{id?}', 'AdminController@editor')->name('page-editor');
Route::post('/admin/page/save', 'AdminController@savePage')->name('page-save');
Route::post('/admin/page/delete/{id}', 'AdminController@destroyPage')->name('page-delete');


/* 
 |--------------------------------------------------------------------------
 | Blogging related routes that only admin can access
 |--------------------------------------------------------------------------
 */
Route::get('/admin/modules',        'ModuleController@home')->name('module-home');
Route::post('/admin/modules',       'ModuleController@index')->name('module-index');
Route::get('/admin/module/{type}/{id?}',   'ModuleController@showOrCreate')->name('module-show');
Route::patch('/admin/module/save',  'ModuleController@updateOrCreate')->name('module-update');
Route::post('/admin/module/delete', 'ModuleController@destroy')->name('module-delete');
Route::post('/admin/module/visibility', 'ModuleController@saveModuleMeta')->name('module-visibility');


/* 
 |--------------------------------------------------------------------------
 | Media management related APIs
 |--------------------------------------------------------------------------
 */
Route::get('/admin/media', 'MediaController@index')->name('media-index');
Route::post('/admin/media', 'MediaController@store')->name('media-store');


/* 
 |--------------------------------------------------------------------------
 | Site setup related routes
 |--------------------------------------------------------------------------
 */
//Route::get('/admin/config/storage', 'ConfigurationController@showStorage')->name('storage');
//Route::post('/admin/config/storage', 'ConfigurationController@saveStorage')->name('storage-store');
//Route::get('/admin/config/cdn', 'ConfigurationController@showCdn')->name('cdn');
//Route::post('/admin/config/cdn', 'ConfigurationController@saveCdn')->name('cdn-config-store');
Route::get('/admin/config/{config}', 'ConfigurationController@getConfig')->name('get-config');
Route::post('/admin/config/{config}', 'ConfigurationController@setConfig')->name('set-config');

/* 
 |--------------------------------------------------------------------------
 | Comments
 |--------------------------------------------------------------------------
 */
Route::get('/users/{slug}/comments', 'CommentsController@commentsByUser')->name('comments-by-user');

Route::post('/comments/store', 'CommentsController@store')->name('comments-store');


/* 
 |--------------------------------------------------------------------------
 | APIs
 |--------------------------------------------------------------------------
 */
Route::get('/api/v1/get/categories', 'API\v1\APICategoryController@getCategories')->name('api-categories');
Route::get('/api/v1/get/pages/related/{category_id}/{limit?}', 'API\v1\APICategoryController@getRelatedPages')->name('api-related-pages');
Route::get('/api/v1/get/media', 'API\v1\APIMediaController@getMedia')->name('api-media');
Route::get('/api/v1/comments', 'CommentsController@comments')->name('comments-on-page');


Route::get('/test/meta', function () {
    return unserialize(App\Configuration::where('key', 'blog')->first()->value);
});


/* 
 |--------------------------------------------------------------------------
 | Page and Category Related Routes
 |--------------------------------------------------------------------------
 */
Route::get('/{CategorySlug}', 'CategoryController@show')->name('category-view');
Route::get('/{categorySlug}/{page}', 'PageController@show')->name('page-view');
