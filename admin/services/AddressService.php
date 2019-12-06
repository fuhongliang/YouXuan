<?php
namespace app\services;

use app\models\District;
use app\hejiang\ApiCode;
use app\models\Address;

class AddressService
{

    /**
     * id          int auto_increment primary key,
    store_id    int                   not null,
    user_id     int                   not null,
    name        varchar(255)          not null comment '姓名',
    mobile      varchar(255)          not null comment '手机号',
    province_id int         default 0 not null,
    province    varchar(255)          not null comment '省份名称',
    city_id     int         default 0 not null,
    city        varchar(255)          not null comment '城市名称',
    district_id int         default 0 not null,
    district    varchar(255)          not null comment '县区名称',
    detail      varchar(1000)         not null comment '详细地址',
    is_default  smallint(1) default 0 not null comment '是否是默认地址：0=否，1=是',
    addtime     int         default 0 not null,
    is_delete   smallint(6) default 0 not null
     */

    /**
     * 'name', 'mobile', 'province_id', 'city_id', 'district_id', 'detail'
     * address_id
     * @param $data
     * @return array
     */
    public function saveAddress($data)
    {
        //areaCode  获取district_id  province_id  city_id
        //addressDetail  detail
        //name  name
        //tel   mobile
        //address_id   id

        if (empty($data['id'])) {
            $address = new Address();
        } else {
            $address = Address::findOne([
                'id' => $data['id'],
                'is_delete' => 0,
                'user_id' => $data['user_id']
            ]);
            if (empty($address)) {
                $address = new Address();
            }
        }
        $address->store_id = $data['store_id'];
        $address->user_id = $data['user_id'];
        $address->is_delete = Address::DELETE_STATUS_FALSE;
        $address->is_default = Address::DEFAULT_STATUS_FALSE;
        $address->addtime = time();
        $address->areaCode = $data['areaCode'];
        //手机号
        if (!preg_match('/^1\d{10}$/', $data['tel'])) {
            return [
                'code' => 1,
                'msg' => '请输入正确的手机号'
            ];
        }
        if (empty($data['name'])) {
            return [
                'code' => 1,
                'msg' => '请输入姓名'
            ];
        }
        if (empty($data['addressDetail'])) {
            return [
                'code' => 1,
                'msg' => '请输入详细地址'
            ];
        }
        $address->name = trim($data['name']);
        $address->mobile = $data['tel'];
        $address->detail = trim($data['addressDetail']);

        $areaCode = $data['areaCode'];
        $district = District::find()->where(['adcode' => $areaCode])->one();
        if (empty($district)) {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '地区数据错误，请重新选择',
            ];
        }
        $address->district_id = $district->id;
        $address->district = $district->name;

        $city = District::find()->where(['id'=> $district['parent_id']])->one();
        if (empty($city)) {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '城市数据错误，请重新选择',
            ];
        }
        $address->city_id = $city->id;
        $address->city = $city->name;

        $province = District::find()->where(['id'=> $city['parent_id']])->one();
        if (empty($province)) {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '省份数据错误，请重新选择',
            ];
        }
        $address->province_id = $province->id;
        $address->province = $province->name;

        if ($address->save()) {
            return [
                'code' => ApiCode::CODE_SUCCESS,
                'msg'  => '保存成功',
            ];
        } else {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => $address->getErrors(),
            ];
        }
    }

}