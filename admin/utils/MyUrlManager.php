<?php
namespace app\utils;

use yii\web\UrlManager;

/**
 * URL 管理器
 * 继承官方 URL 管理器，同时支持 URL 原始和美化的请求
 */
class MyUrlManager extends UrlManager
{
    /**
     * 解析请求路由
     * 同时支持 URL 原始和美化的请求解析
     *
     * @param yii\web\Request $request
     * @return array|bool
     */
    public function parseRequest($request)
    {
        $route = trim($request->get($this->routeParam));
        $enablePrettyUrl = $this->enablePrettyUrl;

        if ($route != '') $this->enablePrettyUrl = false;
        $result = parent::parseRequest($request);
        if ($route != '') $this->enablePrettyUrl = $enablePrettyUrl;

        return $result;
    }


}