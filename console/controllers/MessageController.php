<?php


namespace console\controllers;





use common\models\CustomerTicket;
use manage\services\SmsService;

class MessageController extends Controller
{
    /**
     * @name 消息 一天之前  1小时跑一次
     */
    public function actionDaySend()
    {
        $transction = \Yii::$app->db->beginTransaction();
        try {
            $old=time()-25*60*60;
            $now=time()-24*60*60;
            $data=CustomerTicket::find()->where(['<','start_time',$old])->andWhere(['>=','start_time',$now])->asArray()->all();
            foreach ($data as $v){
                SmsService::service()->opera_begin($v['schedule']);
            }
            $transction->commit();
        } catch (\Exception $e) {
            $transction->rollBack();
            file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/message/') . 'message-day-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "变更等级错误信息：" . $e->getMessage() . "\n\r", FILE_APPEND);
            die;
        }
        echo "integral flush change run success" . date('Y-m-d H:i:s') . "\n\r";
        die;

    }

    public function isDir($dir)
    {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new \Exception('路径创建失败');
            }
        }
        return $dir;
    }

    /**
     * @name 消息 2小时之前  1分钟跑一次
     */
    public function actionHourSend()
    {
        $transction = \Yii::$app->db->beginTransaction();
        try {
            $time=time()-2*60*60;
            $data=CustomerTicket::find()->where(['start_time'=>$time])->asArray()->all();
            foreach ($data as $v){
                SmsService::service()->opera_begin($v['schedule']);
            }
            $transction->commit();
        } catch (\Exception $e) {
            $transction->rollBack();
            file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/message/') . 'message-hour-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "变更等级错误信息：" . $e->getMessage() . "\n\r", FILE_APPEND);
            die;
        }
        echo "integral flush change run success" . date('Y-m-d H:i:s') . "\n\r";
        die;

    }

}