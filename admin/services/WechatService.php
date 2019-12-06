<?php
namespace app\services;
use Curl\Curl;

class WechatService
{
    public $appid = 'wxacb03e0a5cf8971f';
    public $secret = 'ba0819d9049ea3336c8e1b8347c1625b';

    public function getWebAccessToken($code)
    {
        $api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->secret}&code={$code}&grant_type=authorization_code";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($api);
        $res = $curl->response;
        $res = json_decode($res, true);
        return $res;
    }


    public function getUserInfo($access_token,$openid)
    {
        $api = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($api);
        $res = $curl->response;
        $res = json_decode($res, true);
        return $res;
    }




}
