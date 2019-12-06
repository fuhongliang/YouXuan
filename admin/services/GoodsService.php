<?php
namespace app\services;

class GoodsService
{

    /**
     * @desc vant ui sku组件需要的sku数据格式
     * @param $attr_group_list
     * @param $attr
     * @return array
     */
    public function formatSku($attr_group_list,$attr)
    {
        $attr_group_list = object_to_array($attr_group_list);
        $attr = json_decode($attr, true);
        $sku = [];
        $tree = [];
        $list = [];
        $s = 1;
        foreach ($attr_group_list as $key=>$value) {
            $k = $value['attr_group_name'];
            $k_s = 's'.$s;
            $k_id = $value['attr_group_id'];
            $v = [];
            $tmp2 = [];
            $tmp = [];
            foreach ($value['attr_list'] as $k2=>$v2) {
                $id = $v2['attr_id'];
                $name = $v2['attr_name'];
                $tmp['id'] = $id;
                $tmp['name'] = $name;
                $v[] = $tmp;
            }
            $tmp2['k'] = $k;
            $tmp2['k_id'] = $k_id;
            $tmp2['k_s'] = $k_s;
            $tmp2['v'] = $v;
            $tree[] = $tmp2;
            $s ++;
        }
        foreach ($attr as $ak=>$av) {
            $tmp_list['price'] = $av['price']*100; //单位分
            $tmp_list['id'] = '';
            $tmp_list['stock_num'] = $av['num'];
            foreach ($av['attr_list'] as $alk=>$alv) {
                $id = $alv['attr_id']; //怎么判断属于s1 s2 s3 ?
                foreach ($tree as $tk=>$tv) {
                    $tmp = $tv['k_s'];
                    foreach ($tv['v'] as $sk=>$sv) {
                        if ($id == $sv['id']) {
                            $tmp_list[$tmp] = $id;
                        }
                    }
                }
            }
            $list[] = $tmp_list;
        }
        $sku['tree'] = $tree;
        $sku['list'] = $list;
        $sku['none_sku'] = false;
        $sku['hide_stock'] = false;

        return $sku;
    }
}