<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categories', 'CategoryController');
Route::resource('tasks', 'TaskController');
Route::resource('groups', 'GroupController');


Route::post('register', 'UserController@register')->middleware('guest');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('user', 'UserController@getAuthenticatedUser');


//    Route::group(function () {
//        Route::resource('tasks', 'TaskController');
//        Route::get('tasks/{task}/items', 'TaskRelationsController@getItems');
//    });

    Route::resource('products', 'ProductController');

});
