<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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


Route::post('login', 'AuthController@login');
Route::get('sanctum/csrf-cookie', 'AuthController@sanctumCookies');


Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::post('logout', 'AuthController@logout');
    //users
    Route::put('users', 'UserController@updateOrCreate');
    Route::post('update-dashboard-settings', 'UserController@udpateDashboardSettings');
    Route::apiResource('users', 'UserController');
    Route::get('search-users/{query}', 'UserController@search');
    Route::get('users-all', 'UserController@all');

    //customers
    Route::put('customers', 'CustomerController@updateOrCreate');
    Route::apiResource('customers', 'CustomerController');

    Route::get('company-groups-all', 'CompanyGroupController@all');
    Route::put('company-groups', 'CompanyGroupController@updateOrCreate');
    Route::apiResource('company-groups', 'CompanyGroupController');


    Route::apiResource('newsletters', 'NewsletterController');
    Route::post('newsletters/{uuid}/send-email', 'NewsletterController@sendTestEmail');
    Route::post('newsletters/{uuid}/send-emails', 'NewsletterController@sendNewsLetterEmails');
    Route::get('newsletters/{uuid}/stats', 'NewsletterController@stats');

    Route::apiResource('forms', 'FormController');

    Route::get('form/{formId}/fields', 'FormFieldController@index');
    Route::get('form-fields/{fieldId}', 'FormFieldController@show');
    Route::post('form-fields/{formId}', 'FormFieldController@store');
    Route::delete('form-fields/{fieldId}', 'FormFieldController@delete');
    Route::patch('form-fields/sort', 'FormFieldController@sort');


    //project statues
    Route::get('project-statuses-all', 'ProjectStatusController@all');
    Route::get('project-statuses', 'ProjectStatusController@index');
    Route::get('project-statuses/{uuid}', 'ProjectStatusController@show');
    Route::put('project-statuses', 'ProjectStatusController@updateOrCreate')->middleware('role:company-admin');
    Route::delete('project-statuses/{uuid}', 'ProjectStatusController@destroy')->middleware('role:company-admin');


    //projects
    Route::get('projects-all', 'ProjectController@all');
    Route::get('projects', 'ProjectController@index');
    Route::get('projects/{uuid}', 'ProjectController@show');
    Route::put('projects', 'ProjectController@updateOrCreate')->middleware('role:company-admin|supervisor');;
    Route::delete('projects/{uuid}', 'ProjectController@destroy')->middleware('role:company-admin|supervisor');;

    //project user
    Route::post('project-user', 'ProjectUserController@store')->middleware('role:company-admin|supervisor');
    Route::delete('project-user', 'ProjectUserController@destroy')->middleware('role:company-admin|supervisor');

    //project comments
    Route::post('/project-comments/{uuid}', 'ProjectCommentController@store');

    //task statues
    Route::get('task-statuses-all', 'TaskStatusController@all');
    Route::get('task-statuses', 'TaskStatusController@index')->middleware('role:company-admin|supervisor');;;
    Route::get('task-statuses/{uuid}', 'TaskController@show')->middleware('role:company-admin|supervisor');;;
    Route::put('task-statuses', 'TaskStatusController@updateOrCreate')->middleware('role:company-admin');
    Route::delete('task-statuses/{uuid}', 'TaskStatusController@destroy')->middleware('role:company-admin');

    // tasks
    Route::get('tasks', 'TaskController@index');
    Route::get('tasks/{uuid}', 'TaskController@show');
    Route::put('tasks', 'TaskController@updateOrCreate')->middleware('role:company-admin|supervisor');;
    Route::delete('tasks/{uuid}', 'TaskController@destroy')->middleware('role:company-admin|supervisor');;

    //task user
    Route::post('task-user', 'TaskUserController@store')->middleware('role:company-admin|supervisor');
    Route::delete('task-user', 'TaskUserController@destroy')->middleware('role:company-admin|supervisor');

    Route::post('task-comments/{uuid}', 'TaskCommentController@store');

    // templates
    Route::get('templates-all', 'TemplateController@getAll');
    Route::resource('templates', 'TemplateController');
});

Route::get('fields/{formId}', 'FormFieldController@getFields');
