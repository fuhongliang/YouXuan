<?php

namespace app\modules\api\controllers;

use app\models\User;
use app\models\Share;
use app\modules\api\models\LoginForm;
use app\hejiang\ApiResponse;
use app\services\WechatService;

class PassportController extends Controller
{
    public function actionLogin()
    {
        $form = new LoginForm();
        $form->attributes = \Yii::$app->request->post();
        $form->wechat_app = $this->wechat_app;
        $form->store_id = $this->store->id;
        if(\Yii::$app->fromAlipayApp()) {
            return $form->loginAlipay();
        } else {
            return $form->login();
        }
    }


    /**
     * @desc h5微信登录
     */
    public function actionWebLogin()
    {
        $post_data = \Yii::$app->request->post();
        if (empty($post_data['code'])) {
            return new ApiResponse(1,'缺少code参数',$post_data);
        }
        $wechatService = new WechatService();

        /**
         * {
        "access_token":"ACCESS_TOKEN",
        "expires_in":7200,
        "refresh_token":"REFRESH_TOKEN",
        "openid":"OPENID",
        "scope":"SCOPE"
        }
         */
        $accessTokenRes = $wechatService->getWebAccessToken($post_data['code']);
        if (empty($accessTokenRes['errcode'])) {
            $openid = empty($accessTokenRes['openid']) ? '' : $accessTokenRes['openid'];
            $access_token = empty($accessTokenRes['access_token']) ? '' : $accessTokenRes['access_token'];
            $userInfoRes = $wechatService->getUserInfo($access_token,$openid);
            if (empty($userInfoRes['errcode'])) {
                /**
                 * {
                "openid":" OPENID",
                " nickname": NICKNAME,
                "sex":"1",
                "province":"PROVINCE"
                "city":"CITY",
                "country":"COUNTRY",
                "headimgurl":       "http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
                "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
                "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
                }
                 */

                if (!empty($userInfoRes['unionid'])) {
                    $user = User::findOne(['wechat_union_id' => $userInfoRes['unionid'], 'store_id' => $this->store->id]);
                }
                if (empty($user)) {
                    $user = User::findOne(['wechat_open_id' => $userInfoRes['openid'], 'store_id' => $this->store->id]);
                }
                if (!$user) {
                    $user = new User();
                    $user->type = 1;
                    $user->username = $userInfoRes['openid'];
                    $user->password = \Yii::$app->security->generatePasswordHash(\Yii::$app->security->generateRandomString(), 5);
                    $user->auth_key = \Yii::$app->security->generateRandomString();
                    $user->access_token = \Yii::$app->security->generateRandomString();
                    $user->addtime = time();
                    $user->is_delete = 0;
                    $user->wechat_open_id = $userInfoRes['openid'];
                    $user->wechat_union_id = isset($userInfoRes['unionid']) ? $userInfoRes['unionid'] : '';
                    $user->nickname = preg_replace('/[\xf0-\xf7].{3}/', '', $userInfoRes['nickname']);
                    $user->avatar_url = $userInfoRes['headimgurl'] ? $userInfoRes['headimgurl'] : \Yii::$app->request->hostInfo . \Yii::$app->request->baseUrl . '/statics/images/avatar.png';
                    $user->store_id = $this->store->id;
                    $user->platform = 0; // 微信
                    $user->save();
                } else {
                    $user->nickname = preg_replace('/[\xf0-\xf7].{3}/', '', $userInfoRes['nickname']);
                    $user->avatar_url = $userInfoRes['headimgurl'];
                    $user->wechat_union_id = isset($userInfoRes['unionid']) ? $userInfoRes['unionid'] : '';
                    $user->save();
                }
                $share = Share::findOne(['user_id' => $user->parent_id]);
                $share_user = User::findOne(['id' => $share->user_id]);
                $data = [
                    'parent_id' => $user->parent_id,
                    'access_token' => $user->access_token,
                    'nickname' => $user->nickname,
                    'avatar_url' => $user->avatar_url,
                    'is_distributor' => $user->is_distributor ? $user->is_distributor : 0,
                    'parent' => $share->id ? ($share->name ? $share->name : $share_user->nickname) : '总店',
                    'id' => $user->id,
                    'is_clerk' => $user->is_clerk === null ? 0 : $user->is_clerk,
                    'integral' => $user->integral === null ? 0 : $user->integral,
                    'money' => $user->money === null ? 0 : $user->money,
                    'binding' => $user->binding,
                    'level' => $user->level ? $user->level : -1,
                    'blacklist' => $user->blacklist,
                    'accessTokenRes' => $accessTokenRes,
                    'userInfoRes' => $userInfoRes
                ];
                return new ApiResponse(0, 'success', $data);
            } else {
                return new ApiResponse(1,'获取用户信息失败',$userInfoRes);
            }
        } else {
            return new ApiResponse(1,'获取access_token失败',$accessTokenRes);
        }

    }







}
