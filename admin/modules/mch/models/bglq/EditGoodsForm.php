<?php


namespace app\modules\mch\models\bglq;


use app\models\BglqGoods;
use app\modules\mch\models\MchModel;

class EditGoodsForm extends MchModel
{
    public $id;
    public $goods_name;
    public $coupon_name;
    public $market_price;
    public $price;
    public $pic;
    public $sort;


    public function rules()
    {
        return [
            [['id', 'goods_name','pic','price','market_price'], 'required'],
            [['coupon_name','goods_name'],'string','max' => 255],
            [['province','city','district'],'string','max' => 25],
            [['price','market_price'],'number','max' => 10000000,'min' => 0.01],
            [['pic'],'string','max' => 1000],
            [['sort'],'integer','max' => 1000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'goods_name' => '商品名称',
            'pic' => '商品图片',
            'price' => '活动价',
            'market_price' => '市场价',
            'coupon_name' => '优惠信息',
            'sort' => '商品排序',
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->errorResponse;

        $model = BglqGoods::findOne(['id' => $this->id,'is_delete' => 0]);
        if (!$model){
            return [
                'code' => 1,
                'msg' => '编辑活动商品不存在或已被移除,请刷新页面重试'
            ];
        }

        $model->attributes = $this->attributes;
        if ($model->save()){
            return [
                'code' => 0,
                'msg' => 'success'
            ];
        }
        return $this->getErrorResponse($model);
    }

}