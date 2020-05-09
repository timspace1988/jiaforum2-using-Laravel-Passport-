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

//RouteServiceProvider defaultly find the controllers in namespace 'App\Http\Controllers'
//So we need to add name space 'Api/V1' to group
//Otherwise, use controler like 'Api/Vi/VerificationCodesController@store'
Route::namespace('Api\V1')
    ->prefix('v1')->name('api.v1.')
    ->group(function(){
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function (){
                //Captchas verification
                Route::post('captchas', 'CaptchasController@store')->name('captchas.store');
                //sms verification
                Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
                //User registration
                Route::post('users', 'UsersController@store')->name('users.store');
                //Login
                Route::post('authorizations', 'AuthorizationsController@store')
                    ->name('api.authorizations.store');
                //Login using third parth application
                Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
                    ->where('social_type', 'weixin|weibo')
                    ->name('socials.authorizations.store');
                //Refresh login access token
                Route::put('authorizations/current', 'AuthorizationsController@update')
                    ->name('authorizations.update');
                //Delete the login access token
                Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                    ->name('authorizations.destroy');
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {
                //Apis for visitors
                //Get a user's info (visitors can access)
                Route::get('users/{user}', 'UsersController@show')
                    ->name('users.show');
                //Get categories list
                Route::get('categories', 'CategoriesController@index')
                    ->name('categories.index');
                //A user's topics(posts) list
                Route::get('users/{user}/topics', 'TopicsController@userIndex')
                    ->name('users.topics.index');
                //Topics list and details
                Route::resource('topics', 'TopicsController')
                    ->only(['index', 'show']);
                //A topic's replies list
                Route::get('topics/{topic}/replies', 'RepliesController@index')
                    ->name('topics.replies.index');
                //A user's replies list
                Route::get('users/{user}/replies', 'RepliesController@userIndex')
                    ->name('users.replies.index');
                //Resources recommendation
                Route::get('links', 'LinksController@index')
                    ->name('links.index');

                //The apis for users who have have signed in
                Route::middleware('auth:api')->group(function(){
                    //Get current signed-in user's info
                    Route::get('user', 'UsersController@me')
                        ->name('user.show');
                    //Edit current signed-in user's info
                    Route::patch('user', 'UsersController@update')
                        ->name('user.update');
                    //Upload image
                    Route::post('images', 'ImagesController@store')
                        ->name('images.store');
                    //Create update and delete topic
                    Route::resource('topics', 'TopicsController')
                        ->only(['store', 'update', 'destroy']);
                    //Post a reply
                    Route::post('topics/{topic}/replies', 'RepliesController@store')
                        ->name('topics.replies.store');
                    //Delete a reply
                    Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                        ->name('topics.replies.destroy');
                    //Get notification list
                    Route::get('notifications', 'NotificationsController@index')
                        ->name('notifications.index');
                    //Get notification stats (unread notification reminder)
                    Route::get('notifications/stats', 'NotificationsController@stats')
                        ->name('notifications.stats');
                    //Mark the notifications as read
                    Route::patch('user/read/notifications', 'NotificationsController@read')
                        ->name('user.notifications.read');
                    //Get current logged in user's permission list
                    Route::get('user/permissions', 'PermissionsController@index')
                        ->name('user.permissions.index');
                });
            });

});

// Route::prefix('v2')->name('api.v2.')->group(function(){
//     Route::get('version', function(){
//         return 'This is version v2';
//     })->name('version');
// });
