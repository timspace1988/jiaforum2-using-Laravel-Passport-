<?php

namespace App\Http\Controllers\Api\V1;


//use App\Http\Controllers\Api\V1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Handlers\SmsHandler;
use App\Http\Requests\Api\V1\VerificationCodeRequest;
use Illuminate\Auth\AuthenticationException;

//t will automatically extends the Controller in same namespace
class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, SmsHandler $sender){
        //return response()->json(['test_message' => 'store verification code']);

        $captchaData = \Cache::get($request->captcha_key);

        //If cannot retrieve the captcha data
        if(!$captchaData){
            abort(403, 'The captcha does not exist or has been expired.');
        }

        //If input captcha code does not match the code in cache
        if(!hash_equals($captchaData['code'], $request->captcha_code)){
            //Clear the cache
            \Cache::forget($request->captcha_key);
            throw new AuthenticationException('The input captcha is incorrect');
        }

        $phone = $captchaData['phone'];


        //In local or test environment, use '1234' as code for test.
        //And only send message in production environment
        if(!app()->environment('production')){
            $code = '1234';
        }else{
            //Generate a random 4 digits code, add 0 to left if need e.g. 0066
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            $message = "Welcome to JiaForum.\nYour verification code is $code, it will be expired in 5 minutes.";


            try{
                $result = $sender->sendMessage($phone, $message, 'JiaForum');
            }catch(GuzzleHttp\Exception\RequestException $e){
                $exceptionMsg = $e->getMessage();

                abort(500, $exceptionMsg ?: 'Error occurs when sending message.');
            }
        }


        $key = 'verificationCode_' . Str::random(15);
        $expiredAt = now()->addMinutes(5);

        //Put verification code in cache and set it expired in 5 minutes
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
        //Clear the captcha key in cache
        \Cache::forget($request->captcha_key);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
