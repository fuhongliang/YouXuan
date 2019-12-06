<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">


    <title><?= $model->name?></title>
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/mch/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/wxshare/css/react.css" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/wxshare/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/statics/wxshare/iconfont/iconfont.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/vendor/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/vue.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/tether.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/bootstrap.min.js"></script>

</head>
<body class="">

<style>
    .mobile-container{
        background: #f5f5f5;
        font-size: .14rem;
    }
    .title{
        padding: .1rem;
    }
    .cart-head{
        min-height: .35rem;
        background: #fff;
        line-height: .35rem;
        text-align: center;
        font-weight: bold;
    }
    .total-price{
        padding: .1rem;
        background-color: #fff;
    }
    .wx-code{
        margin-top: .2rem;
        position: relative;
        padding: .2rem;
        text-align: center;
    }
    .wx-code-img{
        width: 2.4rem;
    }
    .goods-list-body{
        min-height: 3rem;
    }
    .empty-cart{
        display: inline-block;
        margin-top: 1rem;
        padding: .05rem .07rem;
        border: 1px solid #cacaca;
    }
    .infinite-list-wrapper{
        background-color: #fff;
        font-size: .1rem;
    }
    .goods{
        display: flex;
        border-bottom: 1px solid #cacaca;
        padding: .07rem;
    }
    .goods-name{
        overflow:hidden;
        white-space: nowrap;
        width: 3rem;
    }
</style>

<div id="main">
    <div id="ssr-wrapper">
        <div class="mobile-container jsl-containe">
            <div class="cart-head">
                <span class="icon iconfont" @click="back()" style="position: absolute;left: 0.05rem;top: 0;cursor: pointer;">&#xe618;</span>
                <div>下单页</div>
            </div>
            <template>
                <div class="goods-list-body" v-if="goods_list.length>0">
                    <div class="title">商品信息</div>
                    <div class="infinite-list-wrapper">
                        <div class="goods" v-for="goods in goods_list" :key="goods.id">
                            <div class="goods-pic" style="padding: .05rem;margin-right: .05rem;width: .5rem;">
                                <img class="pic" :src="goods.pic">
                            </div>
                            <div class="info">
                                <div class="goods-name">{{goods.name}}</div>
                                <div class="goods-num">商品数量: {{goods.num}}件</div>
                                <div class="price" style="color: #cf0b2c;font-size: .14rem">¥{{goods.price}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="goods-list-body" v-else style="text-align: center;">
                    <div class="empty-cart">购物车为空</div>
                </div>

                <div class="total-price">
                    <div style="color: #cf0b2c;">总计: ￥ {{total_price}}</div>
                    <div>备注: 请截取当前页面发给销售进行下单</div>
                </div>
                <div class="wx-code">
                    <img :src="wx_code" class="wx-code-img"/>
                </div>
            </template>
        </div>

    </div>
</div>

<script>
    let storage = window.sessionStorage;

    let main = new Vue({
        el: '#main',
        data: {
            goods_list : [],
            total_price: 0,
            wx_code: '<?= $model->code; ?>'
        },
        created: function(){
            let _data = JSON.parse(storage.getItem('cart-list'));
            console.log(_data);
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(array_merge(['wxshare/index/get-goods-list'],$_GET)) ?>',
                type: 'POST',
                data: {
                    _csrf: '<?=Yii::$app->request->csrfToken?>',
                    data: _data
                },
                success: function(res){
                    main.goods_list = res.data;
                    main.total_price = res.total_price;
                }
            });
        },
        methods: {
            back: function(){
                window.location.href = '<?= Yii::$app->urlManager->createUrl(array_merge(['wxshare/index/index'],$_GET)) ?>';
            }
        }
    });

</script>

</body>

</html>
