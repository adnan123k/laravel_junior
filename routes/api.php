<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\DiscussionLikesController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\QuestionAttempController;
use App\Http\Controllers\LevelController;
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

Route::group(['middleware' => 'XSS'], function () {
    Route::post('/sign_up', [UserController::class, 'sign_up']);
    Route::post('/sign_in', [UserController::class, 'sign_in']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['middleware' => 'XSS'], function () {
        Route::group(['middleware' => 'isAdmin'], function () {
            Route::post('/add_teacher', [UserController::class, 'add_teacher']);
            Route::get('/get_teacher', [UserController::class, 'get_teacher']);
            Route::put('/put_teacher/{id}', [UserController::class, 'put_teacher']);
            Route::delete('/delete_teacher/{id}', [UserController::class, 'delete_teacher']);
            Route::delete('/delete_subject/{id}', [SubjectController::class, 'delete']);
            Route::delete('/delete_lesson/{id}', [LessonController::class, 'delete']);
            Route::post('/post_subject', [SubjectController::class, 'post']);
        Route::post('/post_lesson', [LessonController::class, 'post']);
        });
        Route::group(['middleware' => 'isTeacher'], function () {

            Route::put('/put_video/{id}', [VideoController::class, 'put']);
            Route::delete('/delete_video/{id}', [VideoController::class, 'delete']);
            Route::patch('/block_user/{id}', [UserController::class, 'block_user']);
            Route::post('/add_video', [VideoController::class, 'post']);
            Route::post('/add_question/{id}', [QuestionController::class, 'post']);
      
        });
        
        Route::group(['middleware' => 'isStudent'], function () {
        Route::post('/post_user_level/{id}', [UserLevelController::class, 'post']);
        Route::post('/post_user_attemp', [QuestionAttempController::class, 'post']);
        Route::patch('/update_point', [UserController::class, 'point_update']);
    });
        Route::get('/get_subject_levels/{id}', [LevelController::class, 'get']);
        Route::post('/post_discussion', [DiscussionController::class, 'post_discussion']);
        Route::delete('/delete_discussion/{id}', [DiscussionController::class, 'delete_discussion']);
        Route::post('/post_comment', [CommentController::class, 'post_comment']);
        Route::delete('/delete_comment/{id}', [CommentController::class, 'delete_comment']);
        Route::put('/toggle_like_on_comment/{id}', [CommentLikesController::class, 'toggle_likes']);
        Route::put('/toggle_like_on_discussion/{id}', [DiscussionLikesController::class, 'toggle_likes']);
        Route::get('/get_subject', [SubjectController::class, 'get']);
        Route::get('/get_lesson/{id}', [SubjectController::class, 'get_lessons']);
        Route::get('/get_video_discussion/{id}', [DiscussionController::class, 'get_video_discussion']);
        Route::get('/get_discussion_comment/{id}', [CommentController::class, 'get_discussion_comment']);
        Route::get('/get_videos/{id}', [VideoController::class, 'get_videos']);
        Route::get('/get_user_discussion', [DiscussionController::class, 'get_discussion']);
        Route::post('/sign_out', [UserController::class, 'sign_out']);
 
        Route::get('/getQuiz/{id}',[QuestionController::class,'get']);
    });
    Route::get('/top', [UserController::class, 'top_10_students']);
});
