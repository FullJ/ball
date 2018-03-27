<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'wap\controllers',
    'timeZone' => 'Asia/Shanghai',
    'modules' => [
        'v1' => [
            'class' => 'wap\modules\v1\v1',
        ]
    ],
    'components' => [
        'request' => [
            //'csrfParam' => '_csrf-wap',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-wap', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-wap',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                //配置规则,实现RESTful的方式
                'GET,POST /' => 'site/index',
                'GET v1/user' => 'v1/test/get-user', // 获取
                'POST v1/user' => 'v1/test/del-user', // 删除
                'POST v1/login' => 'v1/login/log-on', // 登录


                //获取小程序状态 0：维护；1：正常；2：冻结
                'GET app/status' => 'v1/app/status',

                //登录时查看是否有unionid
                'POST login/exist' => 'v1/unionid/check',
                'POST login/check' => 'v1/applogin/check',

                //会员
                'POST member/get' => 'v1/member/get',
                'POST member/edit' => 'v1/member/edit',
                'POST member/add' => 'v1/member/add',
                'POST member/find' => 'v1/member/find',
                'POST member/info' => 'v1/member/get-user-info',
                //会员类型
                'POST member/type' => 'v1/member/type',

                //余额
                //1、获取余额
                'POST balance/get' => 'v1/balance/get',
                //2、添加余额 例子：{"session": "1jZYu3m88QTfP0TXju7xy1fLZ8JOwOjL","qty": "10"}
                //'POST balance/add' => 'v1/balance/add',
                //3、删除余额
                'POST balance/sub' => 'v1/balance/sub',

                //积分
                //1、获取积分
                'POST integral/get' => 'v1/integral/get',
                //2、添加积分 例子：{"session": "1jZYu3m88QTfP0TXju7xy1fLZ8JOwOjL","qty": "10"}
                'POST integral/add' => 'v1/integral/add',
                //3、删除积分
                //'POST integral/sub' => 'v1/integral/sub',

                //短信
                //1、验证码 POST: 例子{"session":"1jZYu3m88QTfP0TXju7xy1fLZ8JOwOjL","phone":"13788888888"}
                'POST sms/verify/send' => 'v1/sms/verify',
                //2、检测验证码是否正确 POST: 例子{"session":"1jZYu3m88QTfP0TXju7xy1fLZ8JOwOjL","code":"1234"}
                //注意，code为字符串，且必须为4位数字，如果不是api会返回相应错误
                'POST sms/verify/check' => 'v1/sms/check',
                //买卡短信提醒
                'POST sms/buycard' => 'v1/sms/buy-card',
                //充值短信提醒
                'POST sms/recharge' => 'v1/sms/recharge',
                //购票成功短信
                'POST sms/ticket' => 'v1/sms/ticket',


                //推送通知
                'POST message/gift_card' => 'v1/message/gift-card',

                //图片上传
                #'POST,GET file/image' => 'v1/file/image',

                //二维码
                'GET file/qrcode' => 'v1/file/qrcode',


                //会员卡
                //1、取会员卡列表
                'GET card/list' => 'v1/card/list',
                'GET card/image_list' => 'v1/card/image_list',
                'GET card/listone' => 'v1/card/listone',
                'POST card/find' => 'v1/card/find',
                //赠送会员卡
                'POST card/gift' => 'v1/card/gift',
                //购买
                'POST card/buy' => 'v1/card/buy',
                //检查库存是否充足
                'POST card/reserve' => 'v1/card/check-reserve',
                //临时减少库存
                'POST card/reserve/del' => 'v1/card/reserve-del',
                //临时增加库存
                'POST card/reserve/add' => 'v1/card/reserve-add',

                //优惠券
                //获取
                'POST coupon/list' => 'v1/coupon/list',
                //个数
                'POST coupon/count' => 'v1/coupon/count',


                //轮播图
                //1、获取轮播图列表
                'GET swipper/list' => 'v1/swipper/list',

                //授权登录
                //1.获取code
                "GET auth/get-auth" => 'v1/auth/get-auth',
                //2，提交code 换取用户信息openid
                "POST auth/post-auth" => 'v1/auth/post-auth',


                //小程序端用户登录后获取openid
                'POST session/set' => 'v1/session/set',

                //微信支付相关
                "POST pay/set" => 'v1/pay/pay',
                "POST notify/set" => 'v1/notify/notify',

                //充值
                'POST recharge/add' => 'v1/recharge/add',
                //列出所有充值选项
                //返回值示例：
                //{
                //    "status":200,
                //    "count":4,
                //    "msg":[
                //        {"id":"1","denomination":"500"},
                //        {"id":"2","denomination":"2000"},
                //        {"id":"3","denomination":"5000"},
                //        {"id":"4","denomination":"8000"}
                //    ]
                //}
                'GET recharge/list' => 'v1/recharge/list',


                //session非法的处理
                'GET fail/fail' => 'v1/fail/fail',
                'GET fail/invalid' => 'v1/fail/invalid',
                'GET fail/reload' => 'v1/fail/reload',

                //解密手机号
                'POST phone/get' => 'v1/phone/get',


                //充值规则说明
                'GET rule-introduce/rule' => 'v1/rule-introduce/rule',
                //卡详情
                'GET card/get-info' => 'v1/card/get-info',
                //获取座位
                'GET seat/get-seat' => 'v1/seat/get-seat',
                //占座
                'POST seat/buy-seat' => 'v1/seat/buy-seat',
                //取消占座
                'POST seat/unlock-seat' => 'v1/seat/unlock-seat',
                //首页 猜你喜欢 近期好戏 分类
                'GET opera/list' => 'v1/opera/list',
                //戏剧列表
                'GET opera/opera-list' => 'v1/opera/opera-list',
                //某个戏剧详情 ,评论
                'GET opera/get-opera' => 'v1/opera/get-opera',
                //提交用户评论
                'POST opera/comment' => 'v1/opera/comment',
                //选场次
                'GET opera/schedule' => 'v1/opera/schedule',
                //订单确认
                'POST seat/confirm-info' => 'v1/seat/confirm-info',
                //购买
                'POST opera/buy' => 'v1/opera/buy',
                //订单列表 ok
                'POST order/list' => 'v1/order/list',
                //订单详情
                'GET order/detail' => 'v1/order/detail',
                //想看 列表
                'GET opera/like-list' => 'v1/opera/like-list',
                // 想看 按钮
                'POST opera/like' => 'v1/opera/like',
                // 积分兑换 一个信息展示页
                'GET ',
                // 我的戏票
                'GET opera/mine' => 'v1/opera/mine',
                // 我的戏评
                'GET opera/comment-list' => 'v1/opera/comment-list',
                // 保存收件人地址
                'POST member/save-address' => 'v1/member/save-address',
                // 订单回调
                'POST order/ticket-back' => 'v1/order/ticket-back',
                // 订单取消
                'POST order/cancel' => 'v1/order/cancel',
                // 签到得积分
                'POST integral/sign' => 'v1/integral/sign',
                // 取得检票信息
                'POST opera/check' => 'v1/opera/check',
                // 上传检票结果
                'POST opera/upload-checkin' => 'v1/opera/upload-checkin',
                // 检票权限
                'POST opera/check-auth' => 'v1/opera/check-auth',
                // 关闭检票通道，
                'POST opera/check-close' => 'v1/opera/check-close',
                // 积分列表，
                'GET integral/market' => 'v1/integral/market',
                // 积分兑换，
                'POST integral/integral-buy' => 'v1/integral/integral-buy',
                // 兑换记录，
                'GET integral/change-record' => 'v1/integral/change-record',
                // 积分明细，
                'GET integral/integral-record' => 'v1/integral/integral-record',
                // 余额明细，
                'GET recharge/balance-list' => 'v1/recharge/balance-list',
                // 支付前验证订单，
                'POST order/pay-before' => 'v1/order/pay-before',
                'GET member/get-loading' => 'v1/member/get-loading',
            ],
        ],

    ],
    'params' => $params,
];
