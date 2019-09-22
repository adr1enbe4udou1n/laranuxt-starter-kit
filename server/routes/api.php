<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('enums', 'EnumController@index')->name('enums.index');

Route::group(['prefix' => 'cms'], function () {
    Route::get('posts', 'PostController@index')->name('cms.posts.index');
    Route::get('posts/{post}', 'PostController@show')->name('cms.posts.show');
    Route::get('pages', 'PageController@index')->name('cms.pages.index');
    Route::get('pages/{page}', 'PageController@show')->name('cms.pages.show');
    Route::get('tags', 'TagController@index')->name('cms.tags');
    Route::get('tags/{tag}', 'TagController@show')->name('cms.tags.show');
});
