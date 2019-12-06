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
    .mobile-container{font-size: .08rem}
    .mobile-container .goods-list-head {background-color: #cf0b2c;}
    .mobile-container .tr .td.product-area{width: 1.0rem}
    .mobile-container .tr .td.pic-col{width:.8rem}
    .mobile-container .tr .td.goods-title-col{width:1.4rem}
    .mobile-container .tr .td.max-price-col{width:1.0rem}
    .mobile-container .tr .td.min-price-col{width:1.0rem}
    .mobile-container .tr .td.link-col{width:1.0rem}
    .mobile-container .goods-list-body .infinite-list-wrapper .tr .td.goods-title-col .goods-name{padding:0 .04rem;max-width: 100%;}
    .mobile-container .goods-list-body .infinite-list-wrapper .tr .td.goods-title-col .goods-name.single{max-height: .36rem;}
    .mobile-container .goods-list-body .infinite-list-wrapper .tr .td.goods-title-col{padding: 0;}
    .mobile-container .goods-list-body .infinite-list-wrapper .tr:nth-child(2n){background-color: #fafafa;}
    .infinite-container{
        font-size: 0.12rem;
        -webkit-transition: bottom .8s ease,opacity .6s ease;
        transition: bottom .8s ease,opacity .6s ease;
        display: block;
        position: fixed;
        height: .42rem;
        /*padding: .1rem;*/
        /*line-height: .22rem;*/
        overflow: hidden;
        right: .18rem;
        bottom: .14rem;
        z-index: 999;
    }
    .text-cf0b2c{
        color: #cf0b2c;
    }
    .infinite-container.cart-list{
        background-color: #ffffff;
        border-radius: .25rem;
        box-shadow: 1px 2px 6px #cacaca;
        display: flex;
    }
    .mobile-container .goods-list-body .infinite-list-wrapper .tr .td a {color:#cf0b2c;text-decoration: none;padding: .05rem;cursor: pointer;}
    .cart{
        padding: 0 .16rem;
        color: #cacaca;
        display: inline-block;
        position: relative;
    }
    .cart .count{
        background-color: #fff;
        border-radius: 50%;
        padding: 1px;
        position: absolute;
        width: .12rem;
        height: .12rem;
        top: .09rem;
        right: .12rem;
    }
    .cart .count .num{
        width: calc(.12rem - 2px);
        height: calc(.12rem - 2px);
        font-size: .08rem;
        line-height: .1rem;
        background-color: #cf0b2c;
        border-radius: 50%;
        color: #fff;
        text-align: center;
    }
    .cart .comma{
        position: absolute;
        background-color: #cf0b2c;
        color: #fff;
        padding: 0 .01rem;
        letter-spacing: -.008rem;
        line-height: .05rem;
        height: .05rem;
        top: .08rem;
        right: .08rem;
        border-radius: 1rem;
    }
    .text{
        line-height: .42rem;
        width: 1.6rem;
        padding-left: .1rem;
    }
    .order{
        line-height: .42rem;
        padding: 0 .2rem;
        background-color: #cacaca;
        color: #ffffff;
    }
    .order.order-confirm{
        cursor:pointer;
        background-color: #cf0b2c;
    }
    .line{
        margin: .05rem;
        width: .01rem;
        height: .32rem;
        background-color: #f2f2f2;
    }

</style>

<div id="main">
    <div id="ssr-wrapper">
        <div class="mobile-container" style="position: relative;">
            <div class="goods-list-head">
                <div class="tr">
                    <div class="td product-area">
                        <span>产地{{goods_list.length}}</span>
                    </div>
                    <div class="td pic-col">
                        <span>商品图</span>
                    </div>
                    <div class="td goods-title-col">
                        <span>商品名</span>
                    </div>
                    <div class="td max-price-col">
                        <span>市场价</span>
                    </div>
                    <div class="td min-price-col">
                        <span>华为员工价</span>
                    </div>
                    <div class="td link-col">
                        <span>购买通道</span>
                    </div>
                </div>
            </div>
            <template>
                <div class="goods-list-body" style="padding-bottom: 0;">
                    <div class="infinite-list-wrapper">
                        <div class="tr" v-for="(goods,index) in goods_list">
                            <div class="td product-area">
                                <span>{{goods.province || '广东'}}/{{goods.city || '深圳'}}</span>
                            </div>
                            <div class="td pic-col">
                                <img class="pic" data-param="goods.pic" :src="goods.pic">
                            </div>
                            <div class="td goods-title-col">
                                <div class="goods-name single">{{goods.goods_name}}</div>
                            </div>
                            <div class="td max-price-col">¥{{goods.market_price}}</div>
                            <div class="td min-price-col">¥{{goods.price}}</div>
                            <div class="td link-col icon iconfont ">
                                <div v-if="goods.buy_num > 0" class="input-group" style="justify-content: center;align-items: center;">
                                    <a style="color: #cacaca;" @click="sub(goods,index)">&#xe623;</a>
                                    <div style="font-size: .14px;color: #000;">{{goods.buy_num}}</div>
                                    <a @click="add(goods,index)">&#xe635;</a>
                                </div>
                                <a v-else @click="buy(goods,index)">&#xe635;</a>
                            </div>
                        </div>
                        <div style="width: 100%; height: 1px;"></div>
                        <div class="infinite-container cart-list">
                            <div class="cart">
                                <div class="icon iconfont" :class="{'text-cf0b2c':total_count > 0}" style="font-size: .26rem;margin-top: .05rem;">&#xe622;</div>
                                <div class="count" v-if="total_count > 0">
                                    <div class="num">{{total_count > 9 ?9:total_count}}</div>
                                </div>
                                <div class="comma" v-if="total_count > 9">···</div>
                            </div>
                            <div class="line"></div>
                            <div class="text">
                                <span v-if="total_count > 0">合计：<span style="color: #cf0b2c;">￥ {{total_price}}</span></span>
                                <span v-else>快去激活购物车吧~</span>
                            </div>
                            <div class="order" :class="{'order-confirm': cartList.length>0}">去下单</div>
                        </div>
                    </div>
                    <div class="downloader-container" style="display: none;">
                        <div class="loader-spinner"></div>
                        <div class="loader-text">正在加载</div>
                    </div>
                </div>
            </template>
        </div>

    </div>
</div>


<script>
    function checkArray(arr,item){
        for (let a of arr){
            if (a.id == item.id){
                return true;
            }
        }
        return false;
    }

    function modifyArray(arr1,arr2){
        for (let i in arr1){
            for (let a2 of arr2){
                if (arr1[i]['id'] == a2.id){
                    arr1[i]['buy_num'] = a2.num;
                }
            }
        }
        return arr1;
    }

</script>
<script>
    let storage = window.sessionStorage;
    let list = <?= json_encode($goods_list,JSON_UNESCAPED_UNICODE) ?: []?>;
    let main = new Vue({
        el: '#main',
        data: {
            goods_list : [],
            cartList: [],
            total_price: 0,
            total_count: 0,
        },
        created: function(){
            let cart = storage.getItem('cart-list');
            let count = storage.getItem('cart-count');
            if (cart != null && count != null){
                this.cartList = JSON.parse(cart);
                this.total_count = JSON.parse(count).total_count;
                this.total_price = JSON.parse(count).total_price;
            }
            for (let i in list){
                for (let cart of this.cartList){
                    if (list[i]['id'] == cart.id){
                        list[i]['buy_num'] = cart.num;
                    }
                }
            }

            this.goods_list = list;
        },
        computed: {
            render_goods_list: function(){
                if (this.cartList.length < 1){
                    return this.goods_list;
                }
                for (let cart of this.cartList){
                    for (let i in this.goods_list){

                    }
                }
            }
        },
        methods: {
            buy: function(item,i){
                item.buy_num = 1;
                this.total_price = (Number(this.total_price) + Number(item.price)).toFixed(2);
                this.total_count += 1;
                if (!checkArray(main.cartList,item)){
                    let new_item = {
                        id: item.id,
                        num: 1,
                    }
                    main.cartList.push(new_item);
                    storage.setItem('cart-list',JSON.stringify(main.cartList));
                    storage.setItem('cart-count',JSON.stringify({total_price: main.total_price,total_count: main.total_count}));
                }

                Vue.set(main.goods_list,i,item);
            },
            add: function(item,i){
                item.buy_num++;
                this.total_price = (Number(this.total_price) + Number(item.price)).toFixed(2);
                this.total_count += 1;
                for (let i in main.cartList){
                    if (main.cartList[i].id == item.id){
                        main.cartList[i].num = item.buy_num;
                    }
                }

                storage.setItem('cart-list',JSON.stringify(main.cartList));
                storage.setItem('cart-count',JSON.stringify({total_price: main.total_price,total_count: main.total_count}));
                Vue.set(main.goods_list,i,item);
            },
            sub: function(item,i){
                if (item.buy_num < 1){
                    return;
                }
                this.total_price = (Number(this.total_price) - Number(item.price)).toFixed(2);
                this.total_count -= 1;
                item.buy_num--;
                for (let i in main.cartList){
                    if (main.cartList[i].id == item.id){
                        if (item.buy_num <= 0){
                            main.cartList.slice(i,1);
                        }else{
                            main.cartList[i].num = item.buy_num;
                        }

                    }
                }

                storage.setItem('cart-list',JSON.stringify(main.cartList));
                storage.setItem('cart-count',JSON.stringify({total_price: main.total_price,total_count: main.total_count}));
                Vue.set(main.goods_list,i,item);
            },
        }
    });

</script>

<script>

    // 去下单页
    $(document).on('click','.order-confirm',function(){

        window.location.href = '<?= Yii::$app->urlManager->createUrl(array_merge(['wxshare/index/cart'],$_GET)) ?>';
    });

    let current_page = 1;
    let total_page = parseInt("<?= $pagination->pageCount ?>");
    let has_data = true;

    $(window).scroll(function(){
        let scrollTop = $(this).scrollTop();        // 滚动高度
        let scrollHeight = $(document).height(); // 内容高度
        let windowHeight = $(this).height();    // 文档可视高度

        if ( (current_page <= total_page) && has_data){

            if(scrollTop + windowHeight >= (scrollHeight - 10)){

                $('.downloader-container').show();
                current_page++;
                let params = <?= json_encode($_GET,JSON_UNESCAPED_UNICODE) ?: []; ?>;
                params.page = current_page;
                delete params.r;
                has_data = false;
                $.ajax({
                    url: "<?= Yii::$app->urlManager->createUrl(['wxshare/index/index'])?>",
                    type: "GET",
                    data: params,
                    success: function(res){
                        if (res.code == 0){
                            if (res.data.length > 0){
                                for (let data of res.data){
                                    for (let cart of main.cartList){
                                        if (data.id == cart.id){
                                            data.buy_num = cart.num;
                                        }
                                    }
                                    console.log(data);
                                    main.goods_list.push(data);
                                }
                            }
                            has_data = true;
                            $('.downloader-container').hide();
                        }
                    },
                    error: function(){

                    }
                });
                // alert("已经到最底部了！");
            }
        }

    });

</script>
</body>

</html>
