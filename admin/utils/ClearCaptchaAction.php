<?php

namespace app\utils;

use yii\captcha\CaptchaAction;
use yii\helpers\Url;
use yii\web\Response;

class ClearCaptchaAction extends CaptchaAction
{
    public function __construct($id, $controller, $config = [])
    {
        $this->minLength = 4;
        $this->maxLength = 4;
        $this->padding = 2;
        $this->offset = 2;
        $this->fontFile = '@app/web/statics/font/MarkerFelt.ttc';
        parent::__construct($id, $controller, $config);
    }

    public function run()
    {
        if (\Yii::$app->request->getQueryParam(self::REFRESH_GET_VAR) !== null) {
            // AJAX request for regenerating code
            $code = $this->getVerifyCode(true);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => Url::to([$this->id, 'v' => uniqid()]),
            ];
        } else {
            $this->setHttpHeaders();
           \ Yii::$app->response->format = Response::FORMAT_RAW;
            return $this->renderImage($this->getVerifyCode(true));
        }
    }


    public function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = '2345678bcefhjkmnprsuvwxyz';
        $code = '';
        $max = strlen($letters) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $code .= $letters[mt_rand(0, $max)];
        }
        $test = mt_rand(0, 1) ? $code : strtoupper($code);
      //  \Yii::error('generateVerifyCode---------'.$test.json_encode($_POST));
        return $test;
    }

    public function validate($input, $caseSensitive)
    {
        // 测试环境下忽略验证码
        if(YII_ENV_DEV || YII_ENV_TEST) {
            return true;
        }
        return parent::validate($input, $caseSensitive);
    }
}
