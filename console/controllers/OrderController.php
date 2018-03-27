<?php


namespace console\controllers;


use common\models\BuyOperaUser;
use common\models\CustomerCard;
use common\models\CustomerTicket;
use common\models\Opera;
use common\models\SchedulePosition;
use Yii;
use yii\console\Controller;
use yii\helpers\Json;

class OrderController extends Controller
{
    /**
     * @name 超过15分钟取消订单
     */
    public function actionCancel()
    {
        $transction = \Yii::$app->db->beginTransaction();
        try {
            $ticket = CustomerTicket::find()->where(['pay_time' => 0])->andWhere(['!=','used_status','-1'])->asArray()->all();
            foreach ($ticket as $k => $v) {
                //当前时间-创建时间>=15分钟，取消订单
                if ((time() - $v['create_time']) >= 15 * 60) {
                    $schedule_position_id = CustomerTicket::find()->select('schedule_position_ids')->where(['id' => $v['id']])->scalar();
                    $opera = CustomerTicket::find()->select('opera')->where(['id' => $v['id']])->scalar();
                    /*$customer_card_id = CustomerTicket::find()->select('customer_card_id')->where(['id' => $v['id']])->scalar();
                    if ($customer_card_id) {
                        CustomerCard::updateAll(['is_active' => 0], ['id' => $customer_card_id]);
                    }*/
                    $is_need_choose = Opera::findOne($opera)->is_need_choose;
                    if ($is_need_choose) {
                        $schedule_id = CustomerTicket::find()->select('schedule')->where(['id' => $v['id']])->scalar();

                        $arr = Yii::$app->redis->get('use_position' . $schedule_id);
                        $arr=Json::decode($arr);
                        file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/redis/error/') . 'error-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "订单取消旧数据：" . Json::encode($arr). "\n\r", FILE_APPEND);

                        $seat_position_set = SchedulePosition::find()
                            ->select('seat_position_set.seat_position_set_id')
                            ->leftJoin('seat_position_set', 'seat_position_set.seat_position_set_id=schedule_position.seat_position_set_id')
                            ->where(['schedule_position.status' => 0])
                            ->asArray()
                            ->all();
                        $seat_position_set = array_column($seat_position_set, 'seat_position_set_id');
                        if ($arr) {
                            $new_arr = [];
                            foreach ($arr as $ks => $vs) {
                                if (!in_array($vs, $seat_position_set)) {
                                    $new_arr[] = $vs;
                                }
                            }
                            //Yii::$app->cache->delete('use_position' . $schedule_id);
                            Yii::$app->redis->set('use_position' . $schedule_id, Json::encode($new_arr));
                        }
                        $schedule_position_id = explode(',', $schedule_position_id);
                        SchedulePosition::deleteAll(['schedule_position_id' => $schedule_position_id]);

                        //设为需要刷新座位的状态
                        $redis = \Yii::$app->redis;
                        $redis->set('schedule_seat_'.$schedule_id.'_changed','true');

                    } else {
                        BuyOperaUser::deleteAll(['buy_id' => $schedule_position_id]);
                    }
                    CustomerTicket::updateAll(['used_status'=>'-1'],['id' => $v['id']]);
                }

            }
            $transction->commit();
        } catch (\Exception $e) {
            $transction->rollBack();
            file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/level/change/') . 'change-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "变更等级错误信息：" . $e->getMessage() . "\n\r", FILE_APPEND);
            die;
        }
        echo "level change run success" . date('Y-m-d H:i:s') . "\n\r";
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

}