<?php

namespace app\modules\mch\models\bglq;

use app\modules\mch\models\MchModel;

class editForm extends MchModel
{
    public $name;
    public $code;
    public $store_id;
    public $type;

    public $model;

    public function rules()
    {
        return [
            [['name', 'code','store_id','type'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '活动名称',
            'code' => '微信群二维码'
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->errorResponse;

        $model = $this->model;
        if ($model->isNewRecord){
            $model->addtime = time();
            $model->is_delete = 0;
            $model->store_id = $this->store_id;
        }
        $model->attributes = $this->attributes;
        $model->is_open = 0;
        if ($model->save()){
            return [
                'code' => 0,
                'msg' => '保存成功'
            ];
        }

        return $this->getErrorResponse($model);

    }

}