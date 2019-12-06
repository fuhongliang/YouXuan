<?php
namespace app\commands;
use app\models\User;
use yii\console\Controller;

class MemberController extends Controller
{

    /**
     * @desc 根据会员到期时间调整会员
     */
    public function actionMemberAutoChange()
    {
        $time = time();
        \Yii::$app->db->createCommand()->update(User::tableName(), ['level' => -1], "vip_end_time < {$time}")
            ->execute();
    }




}