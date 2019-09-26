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

Route::group(['prefix' => config('app.admin_path')], function () {
    Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function () {
        /*
         * Profile management routes
         */
        Route::patch('account/update', 'AccountController@update')
            ->name('account.update');
        Route::patch('password/change', 'AccountController@changePassword')
            ->name('password.change');

        /*
         * Admin resources management routes
         */
        Route::group(['namespace' => 'Admin', 'prefix' => 'backend'], function () {
            Route::group(['namespace' => 'Generic'], function () {
                /*
                 * Generic resource routes (counters + bulk)
                 */
                Route::get('counter/{model}', 'ResourceController@counter')->name('counter');
                Route::post('toggle/{model}/{id}/{attribute}', 'ResourceController@toggle')->name('toggle');
                Route::post('move/{model}/{id}/{direction}', 'ResourceController@move')->name('move');

                Route::get('bulk/actions/{model}', 'BulkController@actions')->name('bulk.actions');
                Route::post('bulk/process/{model}/{action}', 'BulkController@process')->name('bulk.process');

                Route::post('associate/{model}/{id}/{related}/{related_id}', 'RelationshipController@associate')->name('relationships.associate');
                Route::post('dissociate/{model}/{id}/{related}', 'RelationshipController@dissociate')->name('relationships.dissociate');
                Route::post('attach/{model}/{id}/{related}/{related_id}', 'RelationshipController@attach')->name('relationships.attach');
                Route::post('detach/{model}/{id}/{related}/{related_id}', 'RelationshipController@detach')->name('relationships.detach');
            });

            /*
             * Wysiwyg Image Upload
             */
            Route::post('upload', 'ImageController@upload')->name('upload');

            /*
             * Resources management routes
             */
            Route::apiResource('users', 'UserController')->middleware('can:manage-users');
            Route::get('users/{user}/impersonate', 'UserController@impersonate')
                ->name('users.impersonate')->middleware('can:manage-users');

            /*
             * Content ressources
             */
            Route::apiResource('posts', 'PostController');
            Route::apiResource('tags', 'TagController');
        });

        /*
         * Vue SPA admin route
         */
        Route::get('/{vue_capture?}', 'HomeController@index')
            ->where('vue_capture', '[\/\w\.-]*')
            ->where('vue_capture', '^(?!api).*')
            ->name('home');
    });
});
