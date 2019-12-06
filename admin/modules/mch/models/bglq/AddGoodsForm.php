<?php


namespace app\modules\mch\models\bglq;


use app\models\BglqGoods;
use app\models\Cat;
use app\models\Coupon;
use app\models\Goods;
use app\modules\mch\models\MchModel;
use yii\db\Exception;

class AddGoodsForm extends MchModel
{

    public $bglq_id;
    public $goods;
    public $store_id;

    public function rules()
    {
        return [
            [['bglq_id', 'goods'], 'required'],
            [['bglq_id','store_id'],'integer'],
            [['goods'],'safe'],
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->errorResponse;

        if (!is_array($this->goods) || count($this->goods)<1 ){
            return [
                'code' => 1,
                'msg' => '商品信息错误'
            ];
        }

        if (!$this->checkGoods()){
            return [
                'code' => 1,
                'msg' => '所选商品可能不存在或已被删除'
            ];
        }
        $t = \yii::$app->db->beginTransaction();
        try{
            foreach ($this->goods as $goods){
                $model = new BglqGoods();
                $model->bglq_id = $this->bglq_id;
                $model->goods_id = $goods['id'];
                $model->goods_name = $goods['name'];
                $model->market_price = $goods['original_price'];
                $model->price = $goods['price'];
                $model->pic = $goods['cover_pic'] ?: $goods['pic'];
                $model->sort = $goods['sort'];
                $model->is_delete = 0;
                $model->coupon_name = $goods['coupon_name'];
                $model->save();
            }
            $t->commit();
        }catch(Exception $e){
            $t->rollBack();
            return [
                'code' => 1,
                'msg' => '添加失败'
            ];
        }

        return [
            'code' => 0,
            'msg' => '添加成功'
        ];
    }

    private function checkGoods()
    {
        foreach ($this->goods as $key=>$goods){
            $g = Goods::findOne(['id' => $goods['id'],'is_delete' => 0,'store_id' => $this->store_id]);
            if (!$g){
                return false;
            }
            $exists = BglqGoods::find()->where(['goods_id' => $goods['id'],'bglq_id' => $this->bglq_id,'is_delete' => 0])->exists();
            if ($exists){
                unset($this->goods[$key]);
                continue;
            }
            $coupon_name = $this->getCoupon($goods['cname'],$goods['id']);
            $this->goods[$key]['coupon_name'] = $coupon_name;
        }
        return true;
    }

    private function getCoupon($cname,$goods_id)
    {
        $cat = Cat::findOne(['name' => $cname,'is_delete' => 0]);
        if (!$cat){
            return '';
        }

        $coupon = Coupon::find()->where('cat_id_list regexp \'\"' . $cat->id . '\"\' or goods_id_list regexp \'\"' . $goods_id . '\"\'')
            ->andWhere(['is_delete' => 0])->asArray()->one();

        return $coupon['name'] ?: '';
    }

}