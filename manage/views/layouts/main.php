<?php

/* @var $this \yii\web\View */
/* @var $content string */

use manage\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/normalize.css"/>
    <link rel="stylesheet" href="/css/style.css?v=12"/>
    <script src="/js/plugins/jquery/jquery-2.1.1.min.js"></script>
    <script src="/js/plugins/doT/doT.js"></script>
    <script src="/js/plugins/underscore/underscore-min.js"></script>
    <script src="/js/plugins/layer/layer.js"></script>
    <script src="/js/plugins/laydate/laydate.js"></script>
    <script src="/js/plugins/uploadifive/jquery.uploadifive.js"></script>
    <script>
        if (!window.applicationCache) {//是否支持html5
            $.getScript('/js/plugins/uploadify/jquery.uploadify.min.js');
        }
    </script>
    <script src="/js/common.js?v=12"></script>
    <title></title>
    <style>
        .edui-editor{
            z-index: 10000!important;
        }
        .g-sidebar .__nav-list li.active > a{
            color: #696969;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="g-topbar"><?php if (\Yii::$app->controller->id == 'card') { ?>
        会员卡管理
    <?php } elseif (\Yii::$app->controller->id == 'member') { ?>
        会员管理
    <?php } elseif (\Yii::$app->controller->id == 'ticket') { ?>
        优惠券管理
    <?php } elseif (\Yii::$app->controller->id == 'integral') { ?>
        余额积分管理
    <?php } elseif (\Yii::$app->controller->id == 'order') { ?>
        会员卡订单
    <?php } elseif (\Yii::$app->controller->id == 'payment') { ?>
        微信支付管理
    <?php } elseif (\Yii::$app->controller->id == 'rule') { ?>
        充值规则
    <?php } elseif (\Yii::$app->controller->id == 'swipper') { ?>
        轮播图
    <?php } elseif (\Yii::$app->controller->id == 'package-ticket') { ?>
        套票管理
    <?php } elseif (\Yii::$app->controller->id == 'opera') { ?>
        戏剧管理
    <?php } elseif (\Yii::$app->controller->id == 'threater') { ?>
        剧院管理
    <?php } elseif (\Yii::$app->controller->id == 'ticket-order') { ?>
        购票订单
    <?php } elseif (\Yii::$app->controller->id == 'mine-ticket') { ?>
        戏票列表
    <?php } elseif (\Yii::$app->controller->id == 'cate') { ?>
        积分商城
    <?php } elseif (\Yii::$app->controller->id == 'integral-market') { ?>
        分类
    <?php } elseif (\Yii::$app->controller->id == 'setting') { ?>
        loading图片设置
    <?php } elseif (\Yii::$app->controller->id == 'user') { ?>
        管理员设置
    <?php } elseif (\Yii::$app->controller->id == 'stock') { ?>
        场次库存
    <?php } ?>
</div>
<div class="g-sidebar min">
    <span class="_toggle js-toggle-sidebar"><span class="iconfont icon-qiehuan"></span></span>

    <div class="_top">
        <div class="__avatar">
            <img src="/images/1.jpeg">
        </div>
        <div class="__user js-edit-admin">
            <span><?php echo Yii::$app->session->get('username') ?></span>
            <ul class="_dropdown-menu" style="display: none;">
                <li><a class="js-change-pwd" href="javascript:;">修改密码</a></li>
                <li><a class="js-main-exit" href="javascript:;">退出</a></li>
            </ul>
        </div>
    </div>
    <div class="g-scroll-list">
        <ul class="_nav-list js-sider-toggle">
            <li <?php if (in_array(\Yii::$app->controller->id, ['rule', 'cate','user','setting', 'setting-user', 'swipper'])) { ?> class="active" <?php } ?>>
                <a href="#">
                    <span class="iconfont icon-xtsz"></span>系统设置
                </a>
                <ul class="__nav-list" <?php if (in_array(\Yii::$app->controller->id, ['rule', 'cate', 'swipper'])) { ?> style="display: block;" <?php } ?>>
                    <li <?php if (\Yii::$app->controller->id == 'rule'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['rule/index']) ?>">
                            <span class="iconfont icon-jifen"></span>充值规则
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'setting'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['setting/index']) ?>">
                            <span class="iconfont icon-jifen"></span>loading图片设置
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'user'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['user/setting-user']) ?>">
                            <span class="iconfont icon-jifen"></span>管理员设置
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'cate'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['cate/index']) ?>">
                            <span class="iconfont icon-fenleiguanli"></span>分类管理
                        </a>
                    </li>
                    
                    
                    <li <?php if (\Yii::$app->controller->id == 'swipper'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['swipper/index']) ?>">
                            <span class="iconfont icon-lunboguanli"></span>轮播图
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li <?php if (in_array(\Yii::$app->controller->id, ['member', 'integral', 'card'])) { ?> class="active" <?php } ?>>
                <a href="#">
                    <span class="iconfont icon-neirong"></span>会员管理
                </a>
                <ul class="__nav-list" <?php if (in_array(\Yii::$app->controller->id, ['member', 'integral', 'card'])) { ?> style="display: block;" <?php } ?>>
                    <li <?php if (\Yii::$app->controller->id == 'member'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['member/index']) ?>">
                            <span class="iconfont icon-huiyuan"></span>会员管理
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'integral'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['integral/index']) ?>">
                            <span class="iconfont icon-lipin"></span>余额积分管理
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'card'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['card/index']) ?>">
                            <span class="iconfont icon-huangguan"></span>会员卡管理
                        </a>
                    </li>
                </ul>
            </li>
            <li <?php if (in_array(\Yii::$app->controller->id, ['ticket', 'integral-market', 'package-ticket'])) { ?> class="active" <?php } ?>>
                <a href="#">
                    <span class="iconfont icon-neirong"></span>优惠管理
                </a>
                <ul class="__nav-list"
                    <?php if (in_array(\Yii::$app->controller->id, ['ticket', 'integral-market', 'package-ticket'])) { ?> style="display: block;" <?php } ?>
                >
                    <li <?php if (\Yii::$app->controller->id == 'ticket'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['ticket/index']) ?>">
                            <span class="iconfont icon-youhuiquan1"></span>优惠券列表
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'integral-market'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['integral-market/index']) ?>">
                            <span class="iconfont icon-youhuiquan1"></span>积分商城
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'package-ticket'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['package-ticket/package-list']) ?>">
                            <span class="iconfont icon-taopiao"></span>套票
                        </a>
                    </li>
                </ul>
            </li>
            <li <?php if (in_array(\Yii::$app->controller->id, ['opera', 'threater'])) { ?> class="active" <?php } ?>>
                <a href="#">
                    <span class="iconfont icon-neirong"></span>剧场管理
                </a>
                <ul class="__nav-list"
                    <?php if (in_array(\Yii::$app->controller->id, ['opera', 'threater'])) { ?> style="display: block;" <?php } ?>
                >
                    <li <?php if (\Yii::$app->controller->id == 'opera'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['opera/list']) ?>">
                            <span class="iconfont icon-xujuguanli"></span>戏剧管理
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'threater'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['threater/list']) ?>">
                            <span class="iconfont icon-juchangguanli"></span>剧院管理
                        </a>
                    </li>
                </ul>
            </li>
            <li <?php if (in_array(\Yii::$app->controller->id,['order', 'payment', 'ticket-order','stock', 'mine-ticket','recharge'])) { ?> class="active" <?php } ?>>
                <a href="#">
                    <span class="iconfont icon-dingdan"></span>订单管理
                </a>
                <ul class="__nav-list"
                    <?php if (in_array(\Yii::$app->controller->id, ['order', 'payment', 'ticket-order','stock', 'mine-ticket','recharge'])) { ?> style="display: block;" <?php } ?>>
                    <li <?php if (\Yii::$app->controller->id == 'order'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['order/index']) ?>">
                            <span class="iconfont icon-qia"></span>会员卡订单
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'ticket-order'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['ticket-order/index']) ?>">
                            <span class="iconfont icon-qia"></span>购票订单
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'mine-ticket'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['mine-ticket/index']) ?>">
                            <span class="iconfont icon-qia"></span>戏票列表
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'stock'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['stock/index']) ?>">
                            <span class="iconfont icon-qia"></span>场次库存
                        </a>
                    </li>
                    <li <?php if (\Yii::$app->controller->id == 'payment'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['payment/index']) ?>">
                            <span class="iconfont icon-zhifu"></span>微信支付记录
                        </a>
                    </li>

                    <li <?php if (\Yii::$app->controller->id == 'recharge'){ ?>class="active"<?php } ?>>
                        <a href="<?php echo \yii\helpers\Url::to(['recharge/index']) ?>">
                            <span class="iconfont icon-zhifu"></span>充值记录
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</div>
<div class="g-content"><?= $content ?></div>
<?php $this->endBody() ?>
</body>
<!--修改密码-->
<script type="text/j-template" id="main_edit_pwd_tpl">
    <div class="l-p-20 g-form g-no-border">
        <form class="_content" id="main_edit_pwd">
            <div class="__liner">
                <label>
                    原密码：
                </label>

                <div>
                    <input class="small" placeholder="请输入原密码" type="password" name="oldPwd" value="">
                </div>
            </div>
            <div class="__liner">
                <label>
                    新密码：
                </label>

                <div>
                    <input class="small" placeholder="请输入新密码" type="password" name="newPwd" value="">
                </div>
            </div>
            <div class="__liner">
                <label>
                    确认密码：
                </label>

                <div>
                    <input class="small repwd" placeholder="请输入确认密码" type="password" value="">
                </div>
            </div>
        </form>
    </div>
</script>
</html>
<?php $this->endPage() ?>
