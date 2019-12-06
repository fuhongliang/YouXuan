<?php


namespace app\controllers;


class ErrorController extends \yii\web\Controller
{

    public function actionAuthError($msg = '异常页面')
    {
        return $this->render('auth_error',['msg' => $msg]);
    }
}