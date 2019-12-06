<?php


namespace app\controllers\wxshare;


use app\models\Bglq;
use app\models\BglqGoods;
use yii\data\Pagination;

class IndexController extends WxShareController
{
    public $layout = false;
    public function actionIndex($store_id = 0,$id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'store_id' => $store_id,'is_delete' => 0,'is_open' => 1]);
        if (!$model){
            $url = \yii::$app->urlManager->createUrl(['error/auth-error','msg' => '当前活动信息不存在']);
            \yii::$app->response->redirect($url)->send();
            return;
        }

        $query = BglqGoods::find()
            ->where(['bglq_id' => $model->id,'is_delete' => 0]);

        $count = $query->count();
        $page = \yii::$app->request->get('page') ?: 1;
        $pagination = new Pagination(['totalCount' => $count,'pageSize' => 15,'page' => $page - 1]);
        $goods_list = $query->limit($pagination->limit)->offset($pagination->offset)->orderBy('sort,id DESC')->asArray()->all();

        if (\yii::$app->request->isAjax){
            return [
                'code' => 0,
                'data' => $goods_list
            ];
        }

        $view = $model->type == 1?'index':'hw-goods-list';
        return $this->render($view,[
            'goods_list' => $goods_list,
            'pagination' => $pagination,
            'model' => $model
        ]);
    }

    public function actionCart($store_id = 0,$id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'store_id' => $store_id,'is_delete' => 0,'is_open' => 1]);
        if (!$model){
            $url = \yii::$app->urlManager->createUrl(['error/auth-error','msg' => '当前活动信息不存在']);
            \yii::$app->response->redirect($url)->send();
            return;
        }
        return $this->render('cart',[
            'model' => $model
        ]);
    }

    public function actionGetGoodsList($store_id = 0,$id = 0)
    {
        $model = Bglq::findOne(['id' => $id,'store_id' => $store_id,'is_delete' => 0,'is_open' => 1]);
        if (!$model){
            return [
                'code' => 1,
                'msg' => '当前活动信息不存在'
            ];
        }

        $data = \yii::$app->request->post('data');
        $ids = array_column($data,'id');
        $goods_list = BglqGoods::find()->where(['id' => $ids,'bglq_id' => $model->id,'is_delete' => 0])
            ->select('id,pic,goods_name AS name,price')->asArray()->all();
        $new_goods = [];
        $total_price = 0.00;
        foreach ($goods_list as $goods){
            $item = $goods;
            foreach ($data as $d){
                if ($goods['id'] == $d['id']){
                    $item['num'] = $d['num'];
                    $total_price = bcadd($total_price,$item['num']*$goods['price']);
                }
            }
            $new_goods[] = $item;
        }

        return [
            'code' => 0,
            'data' => $new_goods,
            'total_price' => $total_price,
        ];
    }
}