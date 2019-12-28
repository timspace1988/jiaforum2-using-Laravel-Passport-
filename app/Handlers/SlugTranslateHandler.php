<?php

namespace App\Handlers;

use GuzzleHttp\CLient;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text){

        //Create a new instance of client
        $http = new Client;

        //Initialize the default config info
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        //if did not set config of baidu translate, use the compatible pinyin automatically
        if(empty($appid) || empty($key)){
            return $this->pinyin($text);
        }

        //According to document, create the sign
        $sign = md5($appid . $text . $salt . $key);

        //Build the request attributes
        $query = http_build_query([
            'q' => $text,
            'from' => 'zh',
            'to' => 'en',
            'appid' => $appid,
            'salt' => $salt,
            'sign' => $sign,
        ]);

        //Send Http Get request
        $response = $http->get($api . $query);

        $result = json_decode($response->getBody(), true);

        /**
        Get result, if the request is successful, dd($result) will be like this:

        array:3 [▼
            "from" => "zh"
            "to" => "en"
            "trans_result" => array:1 [▼
                0 => array:2 [▼
                    "src" => "XSS 安全漏洞"
                    "dst" => "XSS security vulnerability"
                ]
            ]
        ]

        **/

        //Try getting the translation result
        if(isset($result['trans_result'][0]['dst'])){
            return \Str::slug($result['trans_result'][0]['dst']);
        }else{
            //if cannot get result of baidu translation, use the backup one, pinyin
            return $this->pinyin($text);
        }
    }

    public function pinyin($text){
        return \Str::slug(app(Pinyin::class)->permalink($text));

        //app($abstract = null, array $parameters = []) Get the available container instance.
        //it will return Container::getInstance()->make($abstract, $parameters);
        //See documents
    }
}
