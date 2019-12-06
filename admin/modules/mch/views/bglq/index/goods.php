<?php
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$imgurl = Yii::$app->request->baseUrl;
$this->title = '商品管理';
$this->params['active_nav_group'] = 2;

?>
<style>

    table {
        table-layout: fixed;
    }

    th {
        text-align: center;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    td {
        text-align: center;
        line-height: 30px;
    }

    .ellipsis {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    td.nowrap {
        white-space: nowrap;
        overflow: hidden;
    }

    .goods-pic {
        margin: 0 auto;
        width: 3rem;
        height: 3rem;
        background-color: #ddd;
        background-size: cover;
        background-position: center;
    }
</style>

<div class="panel mb-3" id="page">
    <div class="panel-header">微信群分享活动:【
        <span class="text-primary"><?= $model->name ?></span> 】/
        <?= $this->title ?>
    </div>
    <div class="panel-body">
        <?php
        $status = ['已下架', '已上架'];
        ?>
        <div class="mb-3 clearfix">
            <div class="float-left">
                <div class="dropdown float-right ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        批量操作
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                         style="max-height: 200px;overflow-y: auto">
                        <a href="javascript:void(0)" class="batch dropdown-item"
                           data-url="<?= $urlManager->createUrl(['mch/bglq/index/add-goods','id' => $model->id]) ?>" data-content="是否批量添加"
                           data-type="0">批量添加</a>
                        <a href="javascript:void(0)" class="batch dropdown-item"
                           data-url="<?= $urlManager->createUrl(['mch/bglq/index/del-goods','id' => $model->id]) ?>" data-content="是否批量移除"
                           data-type="1">批量移除</a>
                    </div>
                </div>
                <div class="dropdown float-right ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= isset($_GET['cat']) ? $_GET['cat'] : '全部类型' ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                         style="max-height: 200px;overflow-y: auto">
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/goods/goods','id' => $_GET['id']]) ?>">全部类型</a>
                        <?php foreach ($cat_list as $index => $value) : ?>
                            <a class="dropdown-item"
                               href="<?= $urlManager->createUrl(array_merge(['mch/bglq/index/goods'], $_GET, ['cat' => $value])) ?>"><?= $value ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="dropdown float-right ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($_GET['status'] === '1') :
                            ?>已添加
                        <?php elseif ($_GET['status'] === '2') :
                            ?>未添加
                        <?php elseif ($_GET['status'] == '') :
                            ?>全部商品
                        <?php else : ?>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu" style="min-width:8rem">
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/goods','id' => $_GET['id']]) ?>">全部商品</a>
                        <a class="dropdown-item"
                           href="<?= $urlManager->createUrl(['mch/bglq/index/goods','id' => $_GET['id'] ,'status' => 1]) ?>">已添加</a>
                        <a class="dropdown-item"
                           href="<?= $urlManager->createUrl(['mch/bglq/index/goods', 'id' => $_GET['id'],'status' => 2]) ?>">未添加</a>
                    </div>
                </div>
            </div>
            <div class="float-right">
                <form method="get">

                    <?php $_s = ['keyword', 'page', 'per-page'] ?>
                    <?php foreach ($_GET as $_gi => $_gv) :
                        if (in_array($_gi, $_s)) {
                            continue;
                        } ?>
                        <input type="hidden" name="<?= $_gi ?>" value="<?= $_gv ?>">
                    <?php endforeach; ?>

                    <div class="input-group">
                        <input class="form-control" placeholder="商品名" name="keyword"
                               value="<?= isset($_GET['keyword']) ? trim($_GET['keyword']) : null ?>">
                        <span class="input-group-btn">
                    <button class="btn btn-primary">搜索</button>
                </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered bg-white table-hover">
            <thead>
            <tr>
                <th style="text-align: center;text-overflow:clip;">
                    <label class="checkbox-label" style="margin-right: 0px;">
                        <input type="checkbox" class="goods-all">
                        <span class="label-icon"></span>
                    </label>
                </th>
                <th>
                    <span class="label-text">商品ID</span>
                </th>
                <th>商品类型</th>
                <th>商品名称</th>
                <th>商品图片</th>
                <th>市场价</th>
                <th>活动价</th>
                <th>状态</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <col style="width: 2.5%">
            <col style="width: 5%">
            <col style="width: 6%">
            <col style="width: 12%">
            <col style="width: 7%">
            <col style="width: 7%">
            <col style="width: 8%">
            <col style="width: 5%">
            <col style="width: 5%">
            <col style="width: 5%">
            <tbody>
            <template>
                <tr v-for="(goods,index) in list">

                    <td class="nowrap" style="text-align: center;">
                        <label class="checkbox-label" style="margin-right: 0;">
                            <input type="checkbox" class="goods-one" :data-index="index" :value="goods.id">
                            <span class="label-icon"></span>
                        </label>
                    </td>
                    <td data-toggle="tooltip"
                        data-placement="top" :title="goods.id">
                        <span class="label-text">{{goods.id}}</span>
                    </td>
                    <td class="ellipsis" data-toggle="tooltip"
                        data-placement="top"
                        :title="goods.cname">
                        <span class="badge badge-info" style="width: 100%">{{goods.cname}}</span>
                    </td>
                    <td class="text-left ellipsis" data-toggle="tooltip"
                        data-placement="top" :title="goods.name">
                        {{goods.name}}
                    </td>
                    <td class="p-0" style="vertical-align: middle">
                        <div class="goods-pic"
                             :style="renderPic(goods.cover_pic,goods.pic)"></div>
                    </td>
                    <td class="nowrap text-danger">{{goods.original_price}} 元</td>
                    <td class="nowrap text-danger">{{goods.price}} 元</td>
                    <td class="nowrap">
                        <span class="badge badge-success" v-if="goods.status == 1">已添加</span>
                        <span class="badge badge-danger" v-else>未添加</span>
                    </td>
                    <td class="nowrap">{{goods.sort}}</td>
                    <td class="nowrap">
                        <button class="btn btn-success" @click="add(goods,index)" v-if="goods.status != 1">添加</button>
                        <button class="btn btn-sm btn-danger" @click="remove(goods,index)" v-if="goods.status == 1">移除</button>
                        <button class="btn btn-sm btn-outline-secondary" @click="editGoods(goods.id)" v-if="goods.status == 1">编辑</button>
                    </td>
                </tr>
            </template>
            </tbody>

        </table>
        <div class="text-center">
            <nav aria-label="Page navigation example">
                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '尾页',
                    'maxButtonCount' => 5,
                    'options' => [
                        'class' => 'pagination',
                    ],
                    'prevPageCssClass' => 'page-item',
                    'pageCssClass' => "page-item",
                    'nextPageCssClass' => 'page-item',
                    'firstPageCssClass' => 'page-item',
                    'lastPageCssClass' => 'page-item',
                    'linkOptions' => [
                        'class' => 'page-link',
                    ],
                    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
                ])
                ?>
            </nav>
        </div>
    </div>
</div>

<!-- 活动商品编辑 -->
<div class="modal fade" id="goodsEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding: 30px 15px;">
                <form class="send-form" method="post" action="<?= $urlManager->createUrl(['mch/bglq/index/edit-goods'])?>">

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label required">活动商品名称</label>
                        </div>
                        <div class="col-9">
                            <div class="input-group">
                                <input class="form-control" placeholder="" type="text" autocomplete="off"
                                       name="model[goods_name]" :value="goods.goods_name">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label">优惠描述</label>
                        </div>
                        <div class="col-9">
                            <div class="input-group">
                                <input class="form-control" placeholder="" type="text" autocomplete="off"
                                       name="model[coupon_name]" :value="goods.coupon_name">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label required">商品图片</label>
                        </div>
                        <div class="col-9">
                            <div class="upload-group short-row">
                                <div class="input-group">
                                    <input class="form-control file-input" name="model[pic]"
                                           :value="goods.pic">
                                    <span class="input-group-btn">
                                        <a class="btn btn-secondary upload-file" href="javascript:"
                                           data-toggle="tooltip"
                                           data-placement="bottom" title="上传文件">
                                            <span class="iconfont iconshangchuan"></span>
                                        </a>
                                    </span>
                                    <span class="input-group-btn">
                                        <a class="btn btn-secondary select-file" href="javascript:"
                                           data-toggle="tooltip"
                                           data-placement="bottom" title="从文件库选择">
                                            <span class="iconfont iconpic"></span>
                                        </a>
                                    </span>
                                    <span class="input-group-btn">
                                        <a class="btn btn-secondary delete-file" href="javascript:"
                                           data-toggle="tooltip"
                                           data-placement="bottom" title="删除文件">
                                            <span class="iconfont iconlajixiang"></span>
                                        </a>
                                    </span>
                                </div>
                                <div class="upload-preview text-center upload-preview">
                                    <span class="upload-preview-tip">325&times;325</span>
                                    <img class="upload-preview-img" :src="goods.pic">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label required">市场价</label>
                        </div>
                        <div class="col-9">
                            <div class="input-group short-row">
                                <input type="number" step="0.01" class="form-control short-row"
                                       name="model[market_price]" min="0"
                                       :value="goods.market_price">
                                <span class="input-group-addon">元</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class=" col-form-label required">活动价</label>
                        </div>
                        <div class="col-9">
                            <div class="input-group short-row">
                                <input type="number" step="0.01" class="form-control short-row"
                                       name="model[price]" min="0"
                                       :value="goods.price">
                                <span class="input-group-addon">元</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-3 text-right">
                            <label class="col-form-label required">所在地区</label>
                        </div>
                        <div class="col-9">
                            <input type="hidden" name="model[province]"/>
                            <input type="hidden" name="model[city]"/>
                            <input type="hidden" name="model[district]"/>
                            <div class="input-group">
                                <input class="form-control district-text"
                                       value="-" readonly>
                                <span class="input-group-btn">
                            <a class="btn btn-secondary picker-district" href="javascript:">选择地区</a>
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class=" col-form-label">商品排序</label>
                        </div>
                        <div class="col-9">
                            <input class="form-control short-row" type="text" name="model[sort]"
                                   :value="goods.sort">
                            <div class="text-muted fs-sm">排序按升序排列</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->csrfToken?>" />
                            <input type="hidden" name="model[id]" :value="goods.id" />
                            <button type="button" class="btn btn-primary" @click="save($event)">保存</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).on('click','.batch',function(){
        let that = $(this);
        let data = {};
        data._csrf = _csrf;

        let goods_id = [];
        let goods = [];
        $('.goods-one').each(function(){
            if ( $(this).prop('checked') ){
                goods_id.push($(this).val());
                goods.push(page.list[$(this).attr('data-index')]);
            }
        });

        if (goods_id.length == 0){
            $.myAlert({
                content: "请先勾选商品"
            });
            return;
        }

        if (that.attr('data-type') == 0){
            data.goods = goods;
        }else{
            data.goods_id = goods_id;
        }

        $.confirm({
            content: that.attr('data-content'),
            confirm: function(){
                $.ajax({
                    url: that.attr('data-url'),
                    type: "POST",
                    data: data,
                    success: function(res){
                        if (res.code == 0){
                            layer.msg('操作成功',{icon: 1,time: 1800},function(){
                                window.location.reload();
                            });
                        }else{
                            layer.msg(res.msg,{icon: 5});
                        }
                    },
                    error: function(){
                        layer.msg('网络异常');
                    }
                });
            }
        });

    });

    $(document).on('click','.goods-all',function(){
        let prop = false;
        if ($(this).prop('checked')){
            prop = true;
        }

        $('.goods-one').each(function(){
            $(this).prop('checked',prop);
        });
    });

    $(document).on('click','.goods-one',function(){
        if ( !$(this).prop('checked') ){
            $('.goods-all').prop('checked',false);
        }
    });

    // 选择地区
    $(document).on('click', '.picker-district', function () {
        $('#goodsEdit').modal('hide');
        $.districtPicker({
            success: function (res) {
                $('input[name=province]').val(res.province_name);
                $('input[name=city]').val(res.city_name);
                $('input[name=district]').val(res.district_name);
                $('.district-text').val(res.province_name + "-" + res.city_name + "-" + res.district_name);
                $('#goodsEdit').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
</script>

<script>
    let page = new Vue({
        el: '#page',
        data: {
            list: <?= json_encode($list,JSON_UNESCAPED_UNICODE)?>,
            bglq_list: <?= json_encode($bglq_list,JSON_UNESCAPED_UNICODE)?>
        },
        methods: {
            renderPic: function(pic1,pic2){
                if (pic1 != '' && pic1 != null){
                    return 'background-image: url(' + pic1 + ')';
                }else{
                    return 'background-image: url(' + pic2 + ')';
                }
            },
            add: function(item,index){
                $.confirm({
                    content: '确认添加商品到微信群活动 《 ' + "<?= $model->name?>" + ' 》',
                    confirm: function(){
                        $.ajax({
                            url: "<?= $urlManager->createUrl(['mch/bglq/index/add-goods']) . ($urlManager->enablePrettyUrl ? '?':'&') ?>id=" + "<?= $model->id?>",
                            type: 'POST',
                            data: {
                                _csrf: _csrf,
                                goods: [item]
                            },
                            success: function(res){
                                if (res.code == 0){
                                    layer.msg('添加成功',{icon: 1,time: 1500});
                                    item.status = 1;
                                    Vue.set(page.list,index,item);
                                }else{
                                    layer.msg('添加异常');
                                }

                            },
                            error: function(){
                                layer.msg('请求异常');
                            }
                        });
                    }
                });
            },
            remove: function(id){
                $.confirm({
                    content: '确定要从当前活动移除该商品吗?',
                    confirm: function(){
                        $.ajax({
                            url: "<?= $urlManager->createUrl(['mch/bglq/index/del-goods']) . ($urlManager->enablePrettyUrl ? '?':'&') ?>id=" + "<?= $model->id?>",
                            type: "POST",
                            data: {
                                goods_id: id,
                                _csrf: _csrf
                            },
                            success: function(res){
                                if (res.code == 0){
                                    layer.msg('操作成功',{icon: 1,time: 1800},function(){
                                        window.location.reload();
                                    });
                                }
                            },
                            error: function(){
                                layer.msg('网络异常');
                            }
                        });
                    }
                });
            },
            checkGoods: function(item,index){
                for (let goods of this.bglq_list){
                    if (goods.goods_id == item.id){
                        item.name = goods.goods_name;
                        item.cover_pic = goods.pic;
                        item.original_price = goods.market_price;
                        item.price = goods.price;
                        item.sort = goods.sort;
                        this.list[index] = item;
                    }
                }
            },
            editGoods: function(id){
                for (let goods of this.bglq_list){
                    if (goods.goods_id == id){
                        goodsEdit.goods = goods;
                        break;
                    }
                }
                $('#goodsEdit').modal('show');
            }
        },
        beforeMount: function(){
            for (let i in this.list){
                if (this.list[i].status == 1){
                    this.checkGoods(this.list[i],i);
                }
            }
        }
    });

    let goodsEdit = new Vue({
        el: '#goodsEdit',
        data: {
            goods: {}
        },
        methods: {
            save: function(e){
                let form = $(e.target).closest('form');
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(res){
                        if (res.code == 0){
                            layer.msg('保存成功',{icon: 1,time: 1800},function(){
                                window.location.reload();
                            });
                        }else{
                            layer.msg(res.msg,{icon: 5});
                        }
                    },
                    error: function(){
                        layer.msg('网络异常');
                    }
                });
            }
        }
    });
</script>



