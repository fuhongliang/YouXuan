<?php

namespace app\modules\mch\controllers\bglq;


use app\models\Bglq;
use app\models\BglqGoods;
use app\models\Cat;
use app\models\Coupon;
use app\models\Goods;
use app\models\GoodsCat;
use app\models\GoodsPic;
use app\modules\mch\models\bglq\AddGoodsForm;
use app\modules\mch\models\bglq\editForm;
use app\modules\mch\models\bglq\EditGoodsForm;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $status = \yii::$app->request->get('status');
        $type = \yii::$app->request->get('type');
        $keyword = \yii::$app->request->get('keyword');

        $query = Bglq::find()->alias('b')
            ->leftJoin(['bg' => BglqGoods::tableName()],'b.id=bg.bglq_id and bg.is_delete=0')
            ->where(['b.is_delete' => 0,'b.store_id' => $this->store->id])
            ->groupBy('b.id');

        if ($status == 1){
            $query->andWhere(['b.is_open' => 1]);
        }elseif ($status == 2){
            $query->andWhere(['b.is_open' => 0]);
        }

        if ($type){
            $query->andWhere(['b.type' => $type]);
        }

        if ($keyword){
            $query->andWhere(['like','b.name',$keyword]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $list = $query->select('b.*,count(bg.id) as goods_count')
            ->limit($pagination->limit)->offset($pagination->offset)->orderBy('b.addtime DESC')
            ->asArray()->all();

        return $this->render('index',[
            'list' => $list,
            'pagination' => $pagination,
        ]);
    }

    public function actionEdit($id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'is_delete' => 0,'store_id' => $this->store->id]);
        if (!$model){
            $model = new Bglq();
        }

        if (\yii::$app->request->isPost){
            $form = new editForm();
            $form->attributes = \yii::$app->request->post('model');
            $form->store_id = $this->store->id;
            $form->model = $model;
            return $form->save();
        }

        return $this->render('edit',[
            'model' => $model
        ]);
    }

    // 删除活动
    public function actionDel()
    {
        $id = \yii::$app->request->post('id');
        $model = Bglq::findOne(['id' => $id]);
        if (!$model){
            return [
                'code' => 1,
                'msg' => '未发现活动信息',
            ];
        }
        $model->is_delete = 1;
        $model->save();
        return [
            'code' => 0,
            'msg' => 'success'
        ];
    }

    // 活动开启与关闭
    public function actionOpenAndDown($id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'is_delete' => 0,'store_id' => $this->store->id]);
        if (!$model){
            return [
                'code' => 1,
                'msg' => '当前活动不存在或已被删除'
            ];
        }
        $is_open = \yii::$app->request->post('is_open');
        $model->is_open = $is_open;
        $model->save();
        return [
            'code' => 0,
            'msg' => '操作成功'
        ];
    }

    // 商品列表
    public function actionGoods($id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'is_delete' => 0,'store_id' => $this->store->id]);
        if (!$model){
            return [
                'code' => 1,
                'msg' => '当前活动不存在或已被删除'
            ];
        }
        $keyword = \yii::$app->request->get('keyword');
        $status = \yii::$app->request->get('status');
        $cat_name = trim(\yii::$app->request->get('cat'));

        $query = Goods::find()->alias('g')
            ->leftJoin(['c' => Cat::tableName()],'c.id=g.cat_id and c.is_delete=0')
            ->leftJoin(['gc' => GoodsCat::tableName()],'gc.goods_id=g.id and gc.is_delete=0')
            ->leftJoin(['c2' => Cat::tableName()],'c2.id=gc.cat_id and c2.is_delete=0')
            ->where(['g.store_id' => $this->store->id, 'g.is_delete' => 0, 'g.mch_id' => 0]);


        if ($status == 1){
            $query->andWhere(['exists',(new Query())->from(BglqGoods::tableName())->where('g.id=goods_id')->andWhere(['bglq_id' => $id,'is_delete' => 0])]);
        }elseif ($status == 2){
            $query->andWhere(['not exists',(new Query())->from(BglqGoods::tableName())->where('g.id=goods_id')->andWhere(['bglq_id' => $id,'is_delete' => 0])]);
        }

        if ($keyword){
            $query->andWhere(['like','g.name',$keyword]);
        }

        if ($cat_name) {
            $query->andWhere([
                'or',
                ['c.name' => $cat_name],
                ['c2.name' => $cat_name],
            ]);
        }

        $query->groupBy('g.id');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);

        $pic_query = GoodsPic::find()
            ->where('goods_id=g.id')
            ->andWhere(['is_delete' => 0])
            ->limit(1)
            ->select('pic_url');

        $cat_list = Cat::find()->where(['is_delete' => 0])->select('name')->asArray()->column();

        $list = $query->leftJoin(['bg' => BglqGoods::tableName()],'bg.goods_id=g.id and bg.is_delete=0 and bg.bglq_id=' . $id)
            ->orderBy('bg.sort,bg.id DESC,g.sort ASC,g.addtime DESC')
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->select(['status' => new Expression('IF(bg.id,1,0)'),'cname' => new Expression('IF(c.name,c.name,c2.name)')])
            ->addSelect(['g.id','g.name','g.original_price','g.price','g.sort','g.cover_pic','pic' => $pic_query])
            ->asArray()
            ->all();
        $goods_ids = array_column($list,'id');
        $bglq_list = BglqGoods::find()->where(['bglq_id' => $id,'is_delete' => 0,'goods_id' => $goods_ids])->asArray()->all();

        return $this->render('goods',[
            'pagination' => $pagination,
            'cat_list' => $cat_list,
            'list' => $list,
            'bglq_list' => $bglq_list,
            'model' => $model
        ]);
    }

    // 添加商品到活动
    public function actionAddGoods($id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'is_delete' => 0]);
        if (!$model)
            return [
                'code' => 1,
                'msg' => '活动未找到或已被删除'
            ];
        $form = new AddGoodsForm();
        $form->goods = \yii::$app->request->post('goods');
        $form->store_id = $this->store->id;
        $form->bglq_id = $id;
        return $form->save();
    }

    // 活动商品修改
    public function actionEditGoods(){

        $form = new EditGoodsForm();
        $form->attributes = \yii::$app->request->post('model');
        return $form->save();
    }

    // 从活动中删除商品
    public function actionDelGoods($id = 0)
    {
        $goods_id = \yii::$app->request->post('goods_id');
        BglqGoods::updateAll(['is_delete' => 1],['bglq_id' => $id,'goods_id' => $goods_id]);
        return [
            'code' => 0,
            'msg' => 'success'
        ];
    }

}