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

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');



//    Route::post('register', 'UserController@register')->middleware('guest');
//    Route::post('login', 'UserController@authenticate');

    Route::resource('tasks', 'TaskController');
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('/{task}', 'TaskController@show');
            Route::get('{task}/project', 'TaskController@getTaskProject');
            Route::get('{task}/user', 'TaskController@getTaskUser');
        });

    Route::resource('projects', 'ProjectController');
        Route::group(['prefix' => 'projects'], function () {
            Route::get('/{project}', 'ProjectController@show');
            Route::get('/{project}/tasks', 'ProjectController@getProjectTasks');
            Route::get('/{project}/tasks/{task}', 'ProjectController@getSingleProjectTask');
            Route::get('/{project}/users', 'ProjectController@getProjectUsers');
            Route::get('/{project}/users/{user}', 'ProjectController@getSingleProjectUser');
        });

    Route::resource('users', 'UserController');
        Route::group(['prefix' => 'users'], function () {
            Route::get('/{user}', 'userController@show');
            Route::get('/{user}/profile', 'UserController@getUserProfile');
            Route::get('/{user}/tasks', 'UserController@getUserTasks');
            Route::get('/{user}/tasks/{task}', 'UserController@getSingleUserTask');
            Route::get('/{user}/project', 'UserController@getUserProject');
            Route::get('/{user}/project/tasks', 'UserController@getSingleProjectUser');
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => ['jwt.verify']], function () {
//        Route::post('logout', 'UserController@postLogout');
//        Route::get('user', 'UserController@getAuthenticatedUser');
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@getAuthUser');

        Route::get('user/profile', 'UserController@getAuthenticatedProfile');
        Route::get('user/project', 'UserController@getAutenticatedProject');
        Route::get('user/tasks', 'UserController@getAuthenticatedTasks');
        Route::get('user/tasks/{task}', 'UserController@getSingleAuthenticatedTask');
    });



});
