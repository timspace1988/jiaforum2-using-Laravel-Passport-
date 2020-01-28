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
                //sms verification
                Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
                //User registration
                Route::post('users', 'UsersController@store')->name('users.store');
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {

            });

});

// Route::prefix('v2')->name('api.v2.')->group(function(){
//     Route::get('version', function(){
//         return 'This is version v2';
//     })->name('version');
// });
