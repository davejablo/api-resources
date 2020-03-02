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

Route::group(['prefix' => 'v1'], function () {

    Route::post('register', 'UserController@register')->middleware('guest');
    Route::post('login', 'UserController@authenticate');

    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');

    Route::resource('tasks', 'TaskController');
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('{task}/group', 'TaskController@getTaskGroup');
            Route::get('{task}/user', 'TaskController@getTaskUser');
        });

    Route::resource('groups', 'GroupController');
        Route::group(['prefix' => 'groups'], function () {
            Route::get('/{group}/tasks', 'GroupController@getGroupTasks');
            Route::get('/{group}/tasks/{task}', 'GroupController@getSingleGroupTask');
            Route::get('/{group}/users', 'GroupController@getGroupUsers');
            Route::get('/{group}/users/{user}', 'GroupController@getSingleGroupUser');
        });

    Route::resource('users', 'UserController');
        Route::group(['prefix' => 'users'], function () {
//            Route::get('/{group}/tasks', 'GroupController@getGroupTasks');
//            Route::get('/{group}/tasks/{task}', 'GroupController@getSingleGroupTask');
//            Route::get('/{group}/users', 'GroupController@getGroupUsers');
//            Route::get('/{group}/users/{user}', 'GroupController@getSingleGroupUser');
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('logout', 'UserController@postLogout');
        Route::get('user', 'UserController@getAuthenticatedUser');

//        Route::get('user/profile', 'UserController@getUserProfile');
        Route::get('user/group', 'UserController@getUserGroup');
        Route::get('user/tasks', 'UserController@getUserTasks');
        Route::get('user/tasks/{task}', 'UserController@getSingleUserTask');
    });

});
