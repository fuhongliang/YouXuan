<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '活动编辑';
$staticBaseUrl = Yii::$app->request->baseUrl . '/statics';
$this->params['active_nav_group'] = 2;
$returnUrl = Yii::$app->request->referrer;
if (!$returnUrl) {
    $returnUrl = $urlManager->createUrl(['mch/bglq/index/index']);
}
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">活动管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>


<div class="panel mb-3" id="page">
    <div class="panel-body">
        <form class="auto-form" method="post" return="<?= $returnUrl ?>">

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="tab_basic" role="tabpanel">

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class=" col-form-label required">活动类型</label>
                        </div>
                        <div class="col-3">
                            <select class="form-control short-row" name="model[type]">
                                <option value="1">懂家优选</option>
                                <option value="2">华为内购</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class=" col-form-label required">活动名称</label>
                        </div>
                        <div class="col-3">
                            <input class="form-control short-row" type="text" name="model[name]"
                                   value="<?= $model['name']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label required">微信群二维码</label>
                        </div>
                        <div class="col-3">
                            <div class="upload-group short-row">
                                <div class="input-group">
                                    <input class="form-control file-input" name="model[code]"
                                           value="<?= $model['code']; ?>">
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
                                    <img class="upload-preview-img" src="<?= $model['code']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-group row text-center">
                <div class="col-4 text-right">
                    <a class="btn btn-primary auto-form-btn" href="javascript:void(0);">发布</a>
                    <a class="btn btn-secondary" style="margin-left: 10px;" href="javascript:history.back(-1);">返回</a>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    jQuery.datetimepicker.setLocale('zh');
    jQuery('#date_cs').datetimepicker({
        datepicker: true,
        timepicker: true,
        format: 'Y-m-d H:i',
        dayOfWeekStart: 1,
        scrollMonth: false,
        scrollTime: true,
        scrollInput: false,
        onShow: function (ct) {
            this.setOptions({
                maxDate: jQuery('#date_end').val() ? jQuery('#date_end').val() : false
            })
        }
    });
    $(document).on('click', '#show_date', function () {
        $('#date_cs').datetimepicker('show');
    });
</script>

