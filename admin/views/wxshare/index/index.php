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

    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/vue.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/tether.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/bootstrap.min.js"></script>

</head>
<body class="">
<style>
    .pin-spinner-2 {
        display: none;
        position: fixed;
        width: .66rem;
        height: .66rem;
        top: 35%;
        margin: 0 auto;
        left: 0;
        right: 0;
        z-index: 999999999;
    }

    .ps-inner-box {
        width: 100%;
        height: 100%;
    }

    .ps-rotate-img {
        width: .25rem;
        height: .25rem;
        margin: auto;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        animation: rotateImg 2.5s linear infinite;
        -webkit-animation: rotateImg 2.5s linear infinite;
        z-index: 9999999999;
        position: absolute;
    }

    .ps-rotate-msg {
        width: 100%;
        font-size: .15rem;
        text-align: center;
        color: #fff;
        position: relative;
        bottom: 0px;
        display: none;
    }

    .ps-background {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0.7;
        background-color: #000;
        border-radius: .09rem;
    }

    .pin-spinner-2 {
        display: block;
        top: 50%;
        margin-top: -.66rem;
        width: .66rem;
        height: .66rem;
    }

    .pin-spinner-2.hasMessageText {
        margin-top: -.82rem;
        width: 1rem;
        height: 1rem;
    }

    .hasMessageText .ps-rotate-img {
        bottom: .43rem;
        top: .18rem;
        width: .36rem;
        height: .36rem;
    }

    .hasMessageText .ps-rotate-msg {
        display: block;
        bottom: .32rem;
    }


    @keyframes rotateImg {
        0% {
            transform: rotateZ(0deg);
        }
        50% {
            transform: rotateZ(180deg);
        }
        100% {
            transform: rotateZ(360deg);
        }
    }

    @-webkit-keyframes rotateImg {
        0% {
            -webkit-transform: rotateZ(0deg);
        }
        50% {
            -webkit-transform: rotateZ(180deg);
        }
        100% {
            -webkit-transform: rotateZ(360deg);
        }
    }

    @media only screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) {
        .pin-spinner-2 {
            margin-top: -.82rem;
        }
    }
</style>

<div id="main">
    <div id="ssr-wrapper">
        <div class="mobile-container" style="position: relative;">
            <div class="goods-list-head">
                <div class="tr">
                    <div class="td pic-col"><span>商品图</span></div>
                    <div class="td goods-title-col"><span>活动商品</span></div>
                    <div class="td max-price-col"><span>市场价</span></div>
                    <div class="td min-price-col"><span>活动价</span></div>
                    <div class="td link-col"><span>购买通道</span></div>
                </div>
            </div>
            <template>
                <div class="goods-list-body" style="padding-bottom: 0;">
                    <div class="infinite-list-wrapper">
                        <div class="tr" v-for="goods in goods_list" @click="goodsDtails(goods.goods_id)">
                            <div class="td pic-col">
                                <img class="pic" data-param="goods.pic" :src="goods.pic">
                            </div>
                            <div class="td goods-title-col">
                                <div class="coupon" v-if="goods.coupon_name != '' && goods.coupon_name != null">{{goods.coupon_name}}</div>
                                <div class="goods-name single">{{goods.goods_name}}</div>
                            </div>
                            <div class="td max-price-col">¥{{goods.market_price}}</div>
                            <div class="td min-price-col">¥{{goods.price}}</div>
                            <div class="td link-col"><a>点击购买</a></div>
                        </div>
                        <div style="width: 100%; height: 1px;"></div>
                        <div class="infinite-gotop-container go-top-hide" style="cursor:pointer;">
                            <span class="go-top-text">顶部</span>
                        </div>
                    </div>
                    <div class="downloader-container" style="display: none;">
                        <div class="loader-spinner"></div>
                        <div class="loader-text">正在加载</div>
                    </div>
                </div>
                <!-- <div class="jsl-bottom-bar">
                    <div class="mlp-push-toptab">
                        <div class="mlp-push-toptab-fixed">
                            <div class="toptab-content">
                                <div id="mlp-top-tab-0" class="mlp-push-toptab-item active-tab-item">
                                    <i class="mlp-top-tab-item-1"></i><span>热门</span>
                                </div>
                                <div id="mlp-top-tab-1" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-2"></i><span>手机</span>
                                </div>
                                <div id="mlp-top-tab-2" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-3"></i><span>美妆</span>
                                </div>
                                <div id="mlp-top-tab-3" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-4"></i><span>数码</span>
                                </div>
                                <div id="mlp-top-tab-4" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-5"></i><span>小家电</span>
                                </div>
                                <div id="mlp-top-tab-5" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-6"></i><span>家居</span>
                                </div>
                                <div id="mlp-top-tab-6" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-7"></i><span>鞋子服饰</span>
                                </div>
                                <div id="mlp-top-tab-7" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-8"></i><span>电脑</span>
                                </div>
                                <div id="mlp-top-tab-8" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-9"></i><span>食品</span>
                                </div>
                                <div id="mlp-top-tab-9" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-10"></i><span>大家电</span>
                                </div>
                                <div id="mlp-top-tab-10" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-11"></i><span>乐高</span>
                                </div>
                                <div id="mlp-top-tab-11" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-12"></i><span>饰品箱包</span>
                                </div>
                                <div id="mlp-top-tab-12" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-13"></i><span>母婴</span>
                                </div>
                                <div id="mlp-top-tab-13" class="mlp-push-toptab-item ">
                                    <i class="mlp-top-tab-item-14"></i><span>汽配摩托</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="watermark-container" style="background-image: url('<?=Yii::$app->request->baseUrl; ?>/statics/wxshare/images/sy.png');"></div>
                <div class="jsl-qrcode-block qrcode-icon" :class="qrcode_cls"
                     style="background-image: url('<?= Yii::$app->request->baseUrl?>/statics/wxshare/images/01.png');cursor:pointer;">
                    <img class="jsl-qrcode-block-qrcode" src="<?= $model->code?>">
                </div>

            </template>
        </div>

    </div>

    <template>
        <div class="popup-in-modal" id="popup" style="z-index: 10000;display: none;">
            <div class="jsl-qrcode-popup" :class="popup_cls">
                <div class="jsl-qrcode-popup-inner">
                    <a class="jsl-qrcode-popup-close" style="cursor:pointer;"></a>
                    <div class="jsl-qrcode-block jsl-qrcode-popup-inner-qr-block" style="background-image: url('<?= Yii::$app->request->baseUrl?>/statics/wxshare/images/01.png');">
                        <img class="jsl-qrcode-block-qrcode" src="<?= $model->code?>">
                    </div>
                    <img class="jsl-qrcode-popup-big-qrcode" src="<?= $model->code?>">
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    let main = new Vue({
        el: '#main',
        data: {
            goods_list : <?= json_encode($goods_list,JSON_UNESCAPED_UNICODE) ?>,
            popup_cls: 'show',
            qrcode_cls: 'hide',

        },
        methods: {
            goodsDtails: function(id){
                window.location.href = 'https://h5.ifhu.cn/#/goods/' + id;
            },
        }
    });
</script>

<script>
    let current_page = 1;
    let total_page = parseInt("<?= $pagination->pageCount?>");
    let has_data = true;
    console.log(total_page);
    $(window).scroll(function(){
        let scrollTop = $(this).scrollTop();        // 滚动高度
        let scrollHeight = $(document).height(); // 内容高度
        let windowHeight = $(this).height();    // 文档可视高度
        if ( scrollTop > windowHeight ){
            $('.infinite-gotop-container').addClass('go-top-show');
            $('.infinite-gotop-container').removeClass('go-top-hide');
        }else{
            $('.infinite-gotop-container').addClass('go-top-hide');
            $('.infinite-gotop-container').removeClass('go-top-show');
        }

        if (has_data){
            if(scrollTop + windowHeight == scrollHeight){
                console.log(has_data);
                $('.downloader-container').show();
                current_page++;
                let params = <?= json_encode($_GET,JSON_UNESCAPED_UNICODE); ?>;
                params.page = current_page;
                delete params.r;
                $.ajax({
                    url: "<?= Yii::$app->urlManager->createUrl(['wxshare/index/index'])?>",
                    type: "GET",
                    data: params,
                    success: function(res){
                        if (res.code == 0){
                            if (res.data.length == 0 || current_page > total_page){
                                has_data = false;
                            }else{
                                for (let data of res.data){
                                    main.goods_list.push(data);
                                }
                                // $('.watermark-container').
                            }
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
    setTimeout("$('.popup-in-modal').show();",5000);

    $(document).on('click','.jsl-qrcode-popup-close',function(event){
        main.popup_cls = 'hide';
        main.qrcode_cls = 'show';
        $('.popup-in-modal').hide(500);
        // $('.jsl-qrcode-popup').removeClass('show');
        // $('.jsl-qrcode-popup').addClass('hide');
        // $('.qrcode-icon').removeClass('hide');
        // $('.qrcode-icon').addClass('show');
        event.stopPropagation();
    });

    $(document).on('click','.qrcode-icon',function(){

        if (main.popup_cls === 'hide'){
            $('.popup-in-modal').show();
            main.popup_cls = 'show';
            main.qrcode_cls = 'hide';

        }
    });

    $(document).on('click','.go-top-show',function(){
        $(window).scrollTop(0);
    });
</script>
</body>

</html>
