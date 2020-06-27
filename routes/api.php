<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/**
 * Authentication endpoints
 */
Route::middleware('auth:sanctum')->post('login', '\App\Services\Api\Http\Controllers\AuthController@index')->name('login');

/**
 * File upload API endpoint
 */
Route::middleware('auth:sanctum')->post('upload', '\App\Services\Api\Http\Controllers\UploadController@index');

/**
 * Assignees API endpoints
 */
Route::middleware('auth:sanctum')->get('proj/{owner}/{projectName}/assignees', '\App\Services\Api\Http\Controllers\IssueController@index')->name('all-assignees');
Route::middleware('auth:sanctum')->post('proj/{owner}/{projectName}/{issueId}/assignees', '\App\Services\Api\Http\Controllers\IssueController@store')->name('add-assignees');

/**
 * Labels API endpoints
 */
Route::middleware('auth:sanctum')->patch('proj/{owner}/{projectName}/issues/{issueId}', '\App\Services\Api\Http\Controllers\IssueController@update')->name('update-issue');
/**
 * Issues API endpoints
 */
Route::middleware('auth:sanctum')->get('proj/{owner}/{projectName}/issues', '\App\Services\Api\Http\Controllers\IssueController@index')->name('all-issues');
Route::middleware('auth:sanctum')->post('proj/{owner}/{projectName}/issues', '\App\Services\Api\Http\Controllers\IssueController@store')->name('new-issue');
Route::middleware('auth:sanctum')->get('proj/{owner}/{projectName}/issues/{issueId}', '\App\Services\Api\Http\Controllers\IssueController@show')->name('get-issue');
Route::middleware('auth:sanctum')->patch('proj/{owner}/{projectName}/issues/{issueId}', '\App\Services\Api\Http\Controllers\IssueController@update')->name('update-issue');
Route::middleware('auth:sanctum')->put('proj/{owner}/{projectName}/issues/{issueId}/lock', '\App\Services\Api\Http\Controllers\IssueController@update')->name('lock-issue');
Route::middleware('auth:sanctum')->delete('proj/{owner}/{projectName}/issues/{issueId}/unlock', '\App\Services\Api\Http\Controllers\IssueController@destroy')->name('unlock-issue');

Route::middleware('auth:sanctum')->post('proj/{owner}/{projectName}/issues/{issueId}/comments', '\App\Services\Api\Http\Controllers\CommentController@store')->name('new-comment');

/**
 * Comment votes API endpoints
 */
Route::middleware('auth:sanctum')->post('proj/{owner}/{projectName}/issues/comments/{commentId}/votes', '\App\Services\Api\Http\Controllers\VoteController@store')->name('new-vote');

/**
 * Projects API endpoints
 */
Route::middleware('auth:sanctum')->get('projects/all', '\App\Services\Api\Http\Controllers\ProjectController@index')->name('all-projects');
Route::middleware('auth:sanctum')->post('projects/list', '\App\Services\Api\Http\Controllers\ProjectController@list')->name('list-projects');
Route::middleware('auth:sanctum')->get('proj/{owner}/{projectName}', '\App\Services\Api\Http\Controllers\ProjectController@show')->name('get-project');
// Route::middleware('auth:sanctum')->put('proj/:owner/:projectName', '\App\Services\Api\Http\Controllers\ProjectController@update')->name('update-project');
Route::middleware('auth:sanctum')->patch('proj/{owner}/{projectName}', '\App\Services\Api\Http\Controllers\ProjectController@update')->name('update-project');
Route::middleware('auth:sanctum')->delete('proj/{owner}/{projectName}', '\App\Services\Api\Http\Controllers\ProjectController@destroy')->name('delete-project');

/**
 * User API endpoints
 */
Route::middleware('auth:sanctum')->post('/user/projects', '\App\Services\Api\Http\Controllers\ProjectController@store')->name('new-project');
Route::middleware('auth:sanctum')->get('/user/projects', '\App\Services\Api\Http\Controllers\ProjectController@getUserProjects')->name('get-my-projects');
Route::middleware('auth:sanctum')->post('/user/projects/import', '\App\Services\Api\Http\Controllers\ProjectController@importUserProjects')->name('import-my-projects');

/**
 * Users API endpoints
 */
Route::middleware('auth:sanctum')->get('/users', '')->name('get-all-users');
Route::middleware('auth:sanctum')->get('/users/{username}', '')->name('get-user');
Route::middleware('auth:sanctum')->get('/users/{username}/projects', '\App\Services\Api\Http\Controllers\ProjectController@getProjects')->name('get-user');
