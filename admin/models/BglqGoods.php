<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bglq_goods}}".
 *
 * @property int $id
 * @property int $goods_id 商品id
 * @property int $bglq_id 表格拉群活动id
 * @property string $pic 商品主图
 * @property string $market_price 市场价
 * @property string $price 售价
 * @property int $sort 排序
 */
class BglqGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bglq_goods}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_id', 'bglq_id', 'pic'], 'required'],
            [['goods_id', 'bglq_id', 'sort'], 'integer'],
            [['market_price', 'price'], 'number'],
            [['province','city','district'],'string','max' => 25],
            [['coupon_name','goods_name'],'string','max' => 255],
            [['pic'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'bglq_id' => 'Bglq ID',
            'pic' => 'Pic',
            'market_price' => 'Market Price',
            'price' => 'Price',
            'sort' => 'Sort',
        ];
    }
}
