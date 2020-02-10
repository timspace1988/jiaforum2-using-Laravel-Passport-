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
                //Get a user's info (visitors can access)
                Route::get('users/{user}', 'UsersController@show')
                    ->name('users.show');
                //The apis for users who have have signed in
                //Get current signed-in user's info
                Route::middleware('auth:api')->group(function(){
                    Route::get('user', 'UsersController@me')
                    ->name('user.show');
                });
            });

});

// Route::prefix('v2')->name('api.v2.')->group(function(){
//     Route::get('version', function(){
//         return 'This is version v2';
//     })->name('version');
// });
