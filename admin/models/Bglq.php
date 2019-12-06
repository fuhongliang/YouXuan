<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bglq}}".
 *
 * @property int $id
 * @property int $store_id
 * @property string $name 活动名称
 * @property int $addtime 创建时间
 * @property int $expire_time 活动过期时间
 * @property string $code 微信二维码图片
 * @property int $is_delete 1已删除
 */
class Bglq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bglq}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'addtime', 'expire_time', 'is_delete','is_open','type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'name' => '名称',
            'addtime' => '添加时间',
            'expire_time' => '过期时间',
            'code' => '微信二维码',
            'is_delete' => '是否删除',
            'is_open' => '是否开启',
        ];
    }
}
