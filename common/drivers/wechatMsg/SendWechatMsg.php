<?php

namespace common\drivers\wechatMsg;

use common\extensions\message;
use common\models\Customer;
use common\models\WechatTemplateType;
use Yii;

class SendWechatMsg
{
    public static $appId = 'wx05758470fcd4b91f';//后期需要填写
    public static $appSecret = 'e4abe79400604b94f4321953226a5033';//后期需要填写


    /**
     * @name 发送微信模板消息
     * @author fjl
     * @param $templateType
     * @param $info
     * @param $customerId
     * @return bool
     */
    public static function init($templateType, $info, $customerId)
    {
        /*充值余额变动提醒	   money_change
          购买卡成功提醒      buy_card
          购买剧票成功提醒	   buy_ticket
          开演3日前提醒/开演前2小时提醒	   time_tips
         */
        switch ($templateType) {
            case "money_change":
                return self::money_change($info, $customerId);
                break;
            case "buy_card":
                return self::buy_card($info, $customerId);
                break;
            case "buy_ticket":
                return self::buy_ticket($info, $customerId);
                break;
            case "time_tips":
                return self::time_tips($info, $customerId);
                break;
            default:
                return false;
                break;
        }
    }


    /**
     * @name 新订单通知 ，总部
     * @author fjl
     * @param $param
     * @param $customerId
     * @return bool
     */
    public static function money_change($param, $customerId)
    {
        $info = [
            'first' => "您好，您已充值成功。",
            'recharge_amount' => $param['recharge_amount'],
            'account_amount' => $param['account_amount'],
            'remark' => "详情请点击下方登录西戏小程序查看，http://tasd;fljads 感谢您对西戏的支持。"
        ];

        /*
        充值金额：
        账户余额：
        详情请点击下方登录西戏小程序查看，
        http://tasd;fljads
        感谢您对西戏的支持。*/
        $templateType = 'money_change';
        $data['first'] = array('value' => $info['first']);
        $data['keyword1'] = array('value' => $info['recharge_amount'], 'color' => '#173177');
        $data['keyword2'] = array('value' => $info['account_amount'], 'color' => '#173177');
        $data['remark'] = array('value' => $info['remark']);
        return self::runSend($customerId, $templateType, $data, $url = "");

    }


    /**
     * @name 变更通知
     * @author fjl
     * @param $info
     * @param $customerId
     * @return bool
     */
    public static function buy_card($info, $customerId)
    {
        $info = [
            'first' => '恭喜您购买成功',
            'card_name' => $info['card_name'],
            'money' => $info['money'],
            'remark' => '尽情享受会员卡带给您的权益吧！'
        ];

        /*恭喜您购买成功。
        商品名称：2018西戏巡演卡
        消费金额：888元
        购买时间：2017年12月15日
        尽情享受会员卡带给您的权益吧！
        */
        $templateType = 'buy_card';
        $data['first'] = array('value' => $info['first']);
        $data['keyword1'] = array('value' => $info['card_name'], 'color' => '#173177');
        $data['keyword2'] = array('value' => $info['money'], 'color' => '#173177');
        $data['keyword3'] = array('value' => date('Y年m月d日 H:i:s', time()), 'color' => '#173177');
        $data['remark'] = array('value' => $info['remark']);
        return self::runSend($customerId, $templateType, $data, $url = "");

    }


    /**
     * @name 充值通知 ，总部
     * @author fjl
     * @param $param
     * @param $customerId
     * @return bool
     */
    public static function buy_ticket($param, $customerId)
    {
        $info = [
            'first' => '恭喜你购买成功',
            'ticket_name' =>$param['ticket_name'],
            'start_time' =>$param['start_time'],
            'address' => $param['address'],
            'money' => $param['money']
        ];

        /*恭喜你购买成功。
        商品名称：*））（&
        开演时间：2018年3月19日 19：30
        剧场地址：&*……*……
        消费金额：XX元
        购买时间：2017年12月15日
        请在开演前10分钟入场。*/
        $templateType = 'buy_ticket';
        $data['first'] = array('value' => $info['first']);
        $data['keyword1'] = array('value' => $info['ticket_name'], 'color' => '#173177');
        $data['keyword3'] = array('value' => $info['start_time'], 'color' => '#173177');
        $data['keyword2'] = array('value' => $info['address'], 'color' => '#173177');
        $data['keyword2'] = array('value' => $info['money'], 'color' => '#173177');
        $data['keyword3'] = array('value' => date('Y年m月d日 H:i:s', time()), 'color' => '#173177');
        $data['remark'] = array('value' => $info['remark']);
        return self::runSend($customerId, $templateType, $data, $url = "");
    }

    /**
     * @name 新订单通知 ，总部
     * @author fjl
     * @param $param
     * @param $customerId
     * @return bool
     */
    public static function time_tips($param, $customerId)
    {
        $info = [
            'type' => $param['type'],//3/2 hour
        ];
        /*
        开演3日前提醒：
        您购买的XXXX剧将于2018年3月19日 19：30
        于XXX剧场准时开演。
        西戏卡所购剧票若无法到场观看者请于开演两日
        前进入西戏小程序进行退票操作。未退票且开演
        未入场者将扣除所赠500积分。

        开演前2小时提醒：
        您购买的XXXX剧将于2018年3月19日 19：30
        于XXX剧场准时开演，请及时入场观看。*/
        $templateType = 'time_tips';
        if ($info['type'] == 2) {
            $data['first'] = array('value' => '您购买的XXXX剧将于2018年3月19日 19：30于XXX剧场准时开演，请及时入场观看。');
        } else {
            $data['first'] = array('value' => '您购买的XXXX剧将于2018年3月19日 19：30 于XXX剧场准时开演。西戏卡所购剧票若无法到场观看者请于开演两日前进入西戏小程序进行退票操作。未退票且开演未入场者将扣除所赠500积分。');
        }
        return self::runSend($customerId, $templateType, $data, $url = "");

    }

    /**
     * @name 执行发送
     * @author fjl
     * @param $customerId
     * @param $templateType
     * @param $data
     * @param $url
     * @return mixed|string
     */
    private static function runSend($customerId, $templateType, $data, $url)
    {
        $templateId = WechatTemplateType::find()->select("template_id")->where(['mtype' => $templateType])->scalar();
        $customer = Customer::find()->select("open_id,true_name")->where(['id' => $customerId])->asArray()->one();
        if (!$templateId) {
            return "模板id未找到";
        }
        #给买家发送消息通知
        if ($customer && $customer['open_id']) {
            $messageObj = new message(self::$appId, self::$appSecret);
            return $messageObj->templateSend($customer['open_id'], $templateId, $url, $data);
        }

    }
}