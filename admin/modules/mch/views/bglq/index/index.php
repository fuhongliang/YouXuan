<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 16:43
 */
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$imgurl = Yii::$app->request->baseUrl;
$this->title = '微信群活动';

$querys = $_GET;
unset($querys['r']);
?>
<style>
    .modal-dialog{
        /* position:fixed;
            top:20%;
            left:45%;
            width:240px;*/
    }
    .modal-content{
        /*width:240px;*/
    }
    .modal-body{
        /*height:200px;*/
    }
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
    .goods-pic:hover{
        cursor: pointer;
    }
</style>


<style>
    .cat-box {
        border: 1px solid rgba(0, 0, 0, .15);
    }

    .cat-box .row {
        margin: 0;
        padding: 0;
    }

    .cat-box .col-6 {
        padding: 0;
    }

    .cat-box .cat-list {
        border-right: 1px solid rgba(0, 0, 0, .15);
        overflow-x: hidden;
        overflow-y: auto;
        height: 10rem;
    }

    .cat-box .cat-item {
        border-bottom: 1px solid rgba(0, 0, 0, .1);
        padding: .5rem 1rem;
        display: block;
        margin: 0;
    }

    .cat-box .cat-item:last-child {
        border-bottom: none;
    }

    .cat-box .cat-item:hover {
        background: rgba(0, 0, 0, .05);
    }

    .cat-box .cat-item.active {
        background: rgb(2, 117, 216);
        color: #fff;
    }

    .cat-box .cat-item input {
        display: none;
    }

    form {
    }

    form .head {
        position: fixed;
        top: 50px;
        right: 1rem;
        left: calc(240px + 1rem);
        z-index: 9;
        padding-top: 1rem;
        background: #f5f7f9;
        padding-bottom: 1rem;
    }

    form .head .head-content {
        background: #fff;
        border: 1px solid #eee;
        height: 40px;
    }

    .head-step {
        height: 100%;
        padding: 0 20px;
    }

    .step-block {
        position: relative;
    }

    form .body {
        padding-top: 45px;
    }

    .step-block > div {
        padding: 20px;
        background: #fff;
        border: 1px solid #eee;
        margin-bottom: 5px;
    }

    .step-block > div:first-child {
        padding: 20px;
        width: 120px;
        margin-right: 5px;
        font-weight: bold;
        text-align: center;
    }

    .step-block .step-location {
        position: absolute;
        top: -122px;
        left: 0;
    }

    .step-block:first-child .step-location {
        top: -140px;
    }

    form .foot {
        text-align: center;
        background: #fff;
        border: 1px solid #eee;
        padding: 1rem;
    }

    .edui-editor,
    #edui1_toolbarbox {
        z-index: 2 !important;
    }

    form .short-row {
        /*width: 380px;*/
        width: 450px;
    }

    .form {
        background: none;
        width: 100%;
        max-width: 100%;
    }

    .attr-group {
        border: 1px solid #eee;
        padding: .5rem .75rem;
        margin-bottom: .5rem;
        border-radius: .15rem;
    }

    .attr-group-delete {
        display: inline-block;
        background: #eee;
        color: #fff;
        width: 1rem;
        height: 1rem;
        text-align: center;
        line-height: 1rem;
        border-radius: 999px;
    }

    .attr-group-delete:hover {
        background: #ff4544;
        color: #fff;
        text-decoration: none;
    }

    .attr-list > div {
        vertical-align: top;
    }

    .attr-item {
        display: inline-block;
        background: #eee;
        margin-right: 1rem;
        margin-top: .5rem;
        overflow: hidden;
    }

    .attr-item .attr-name {
        padding: .15rem .75rem;
        display: inline-block;
    }

    .attr-item .attr-delete {
        padding: .35rem .75rem;
        background: #d4cece;
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
    }

    .attr-item .attr-delete:hover {
        text-decoration: none;
        color: #fff;
        background: #ff4544;
    }

    form .form-group .col-3 {
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 160px;
        -ms-flex: 0 0 160px;
        flex: 0 0 160px;
        max-width: 160px;
        width: 160px;
    }
</style>

<div class="panel mb-3" id="page">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <div class="mb-3 clearfix">
            <div class="float-left">
                <a href="<?= $urlManager->createUrl(['mch/bglq/index/edit'])?>" class="btn btn-primary">
                    <i class="iconfont icon-playlistadd"></i>发布活动
                </a>

                <div class="dropdown float-right ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($_GET['status']==='1') :?>已开启
                        <?php elseif ($_GET['status']==='2') :?>已关闭
                        <?php elseif ($_GET['status']=='') :?>全部状态
                        <?php else : ?>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu" style="min-width:8rem"
                    >
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/index']) ?>">全部活动</a>
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/index','status' => 1]) ?>">已开启</a>
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/index','status' => 2]) ?>">已关闭</a>

                    </div>
                </div>

                <div class="dropdown float-right ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($_GET['type']==='1') :?>懂家优选
                        <?php elseif ($_GET['type']==='2') :?>华为内购
                        <?php elseif ($_GET['type']=='') :?>全部类型
                        <?php else : ?>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu" style="min-width:8rem"
                    >
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/index']) ?>">全部活动</a>
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/index','type' => 1]) ?>">懂家优选</a>
                        <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/bglq/index/index','type' => 2]) ?>">华为内购</a>

                    </div>
                </div>
            </div>
            <div class="float-right">
                <form method="get">

                    <?php $_s = ['keyword','page','per-page'] ?>
                    <?php foreach ($_GET as $_gi => $_gv) :
                        if (in_array($_gi, $_s)) {
                            continue;
                        } ?>
                        <input type="hidden" name="<?= $_gi ?>" value="<?= $_gv ?>">
                    <?php endforeach; ?>

                    <div class="input-group">
                        <input class="form-control" placeholder="活动名" name="keyword"
                               value="<?= isset($_GET['keyword']) ? trim($_GET['keyword']) : null ?>">
                        <span class="input-group-btn">
                    <button class="btn btn-primary">搜索</button>
                </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered bg-white">
            <thead>
            <tr>
                <th style="text-align: center;">
                    <label class="checkbox-label" style="margin-right: 0px;">
                        <input type="checkbox" class="goods-all">
                        <span class="label-icon"></span>
                    </label>
                </th>
                <th><span class="label-text">活动ID</span></th>
                <th>活动类型</th>
                <th>活动名称</th>
                <th>发布时间</th>
                <th>二维码</th>
                <th>商品总数</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <col style="width: 3%">
            <col style="width: 5%">
            <col style="width: 6%">
            <col style="width: 10%">
            <col style="width: 12%">
            <col style="width: 8%">
            <col style="width: 8%">
            <col style="width: 8%">
            <col style="width: 12%">
            <tbody>
            <template>
                <tr v-for="(l,i) in list">
                    <td class="nowrap" style="text-align: center;">
                        <label class="checkbox-label" style="margin-right: 0px;">
                            <input type="checkbox" class="goods-one" :value="l.id">
                            <span class="label-icon"></span>
                        </label>
                    </td>
                    <td data-toggle="tooltip" data-placement="top" :title="l.id">
                        <span class="label-text">{{l.id}}</span>
                    </td>
                    <td>
                        <span v-if="l.type == 1">懂家优选</span>
                        <span v-else>华为内购</span>
                    </td>
                    <td>
                        <div class="ellipsis bglq-name" style="cursor: pointer;" title="点击复制活动链接" :data-url="'<?= Yii::$app->request->hostInfo . $urlManager->createUrl(['wxshare/index/index']) . ($urlManager->enablePrettyUrl?'?':'&') ?>store_id=' + l.store_id + '&id=' + l.id">{{l.name}}</div>
                    </td>

                    <td class="ellipsis">
                        <span class="badge badge-info btn btn-secondary" href="javascript:" style="width: 100%;color: white;">{{formatTime(l.addtime)}}</span>
                    </td>

                    <td class="p-0" style="vertical-align: middle">
                        <div class="goods-pic" :style="'background-image: url(' + l.code + ')'" title="查看二维码"></div>
                    </td>

                    <td class="nowrap">{{l.goods_count}}</td>
                    <td class="nowrap">
                        <div v-if="l.is_open == 1">
                            <span class="badge badge-success">已开启</span>|
                            <a href="javascript:" @click="openDown(l,i)">关闭</a>
                        </div>

                        <div v-else>
                            <span class="badge badge-default">已关闭</span>
                            |
                            <a href="javascript:" @click="openDown(l,i)">开启</a>
                        </div>

                    </td>
                    <td class="nowrap">&nbsp;
                        <a class="btn btn-sm btn-primary" :href="'<?=$urlManager->createUrl(['mch/bglq/index/edit']) . ($urlManager->enablePrettyUrl ? '?':'&') ?>id=' + l.id">修改</a>
                        <a class="btn btn-sm btn-primary" :href="'<?=$urlManager->createUrl(['mch/bglq/index/goods']) . ($urlManager->enablePrettyUrl ? '?':'&') ?>id=' + l.id">商品管理</a>
                        <button class="btn btn-sm btn-danger" @click="del(l.id)">删除</button>
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

<script src="<?= Yii::$app->request->baseUrl ?>/statics/wxshare/js/xe-clipboard.min.js"></script>
<script>
    let page = new Vue({
        el: "#page",
        data: {
            list: <?= json_encode($list,JSON_UNESCAPED_UNICODE); ?>,
        },
        methods: {
            formatTime: function(time){
                let d = new Date(time * 1000);
                return d.getFullYear() + '年' + (d.getMonth() + 1) + '月' + d.getDate() + '日 ' + d.getHours() + '时' + d.getMinutes() + '分';
            },
            isExpired: function(time){
                let current = new Date().getTime();
                if (time <= Math.floor(current/1000)){
                    return true;
                }
                return false;
            },
            openDown: function(item,index){
                if (item.is_open == 0 && item.goods_count < 10){
                    layer.msg('当前商品数小于10个,该活动无法开启',{icon: 2});
                    return false;
                }
                let text = item.is_open == 1 ? '确定关闭吗?':'要开启该活动吗?';
                let is_open = item.is_open == 1 ? 0:1;

                $.confirm({
                    content: text,
                    confirm: function(){
                        $.ajax({
                            url: "<?= $urlManager->createUrl(['mch/bglq/index/open-and-down']) . ($urlManager->enablePrettyUrl ? '?':'&') ?>id=" + item.id,
                            type: "POST",
                            data: {
                                _csrf: _csrf,
                                is_open: is_open
                            },
                            success: function(res){

                                if (res.code == 0){
                                    item.is_open = is_open;
                                    Vue.set(page.list,index,item);
                                    layer.msg('操作成功',{icon: 1,time: 1500});

                                }else{
                                    layer.msg(res.msg);
                                }
                            },
                            error: function(){
                                layer.msg('网络异常');
                            }
                        });
                    }
                });
            },
            del: function(id){
                $.confirm({
                    content: '确定要删除活动吗?',
                    confirm: function(){
                        $.ajax({
                            url: "<?= $urlManager->createUrl(['mch/bglq/index/del']) ?>",
                            type: "POST",
                            data: {
                                _csrf: _csrf,
                                id: id
                            },
                            success: function(res){
                                if (res.code == 0){
                                    layer.msg('删除成功',{icon: 1,time: 1500},function(){
                                       window.location.reload();
                                    });
                                }
                            }
                        });
                    }
                });
            }
        }
    });

</script>

<script>
    $(document).on('click','.bglq-name',function(){
        let url = $(this).attr('data-url');
        if (XEClipboard.copy(url)) {
            layer.msg('链接已复制' + url,{icon: 1,time: 1000});
        } else {
            layer.msg('复制失败,浏览器不兼容',{icon: 2,time: 1000});
        }
    });
</script>

