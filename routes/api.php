<?php

use Illuminate\Http\Request;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::group(['prefix' => 'categories'], function(){
    Route::post('/', 'CategoryController@store')->middleware('jwt.auth');
    /** 
            TODO: add routes for Categories
            - patch: for updating a category with auth middleware and Policy (only Admin user rule can do that)
            - delete: for deleting a category with auth middleware and Policy (only Admin user rule can do that)
        */
});
Route::group(['prefix' => 'posts'], function(){
    Route::get('/', 'PostController@index');
    Route::get('/{post}', 'PostController@single');
    Route::post('/', 'PostController@store')->middleware('jwt.auth');
    Route::patch('/{post}', 'PostController@update')->middleware('jwt.auth');
    Route::delete('/{post}', 'PostController@destroy')->middleware('jwt.auth');

    Route::group(['prefix' => '/{post}/comments'], function(){
       Route::post('/', 'CommentController@store')->middleware('jwt.auth'); 
        /** 
            TODO: add routes for Comments
            - patch: for updating a comment with auth middleware and Policy (user can only update its own comment) - duplicated behaviour of Posts:patch route
            - delete: for deleteing a comment with auth middleware and Policy (user can only delete its own comment if not as Admin) - duplicated behaviour of Posts:delete route
        */
    });
});
