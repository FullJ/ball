<?php


namespace console\controllers;


use common\models\MineTicket;
use common\models\Opera;
use yii\console\Controller;

class MineTicketController extends Controller
{
    /**
     * @name 我的戏票，超过演出时间就变成已看
     */
    public function actionUsed()
    {
        $transction = \Yii::$app->db->beginTransaction();
        try {
            $ticket=MineTicket::find()->where(['used'=>0])->asArray()->all();
            foreach ($ticket as $k=>$v){
                $duration=Opera::findOne($v['opera'])->duration;
                if($v['start_time']+$duration*60>time()){
                    MineTicket::updateAll(['used'=>1],['mine_ticket_id'=>$v['mine_ticket_id']]);
                }
            }
            $transction->commit();
        } catch (\Exception $e) {
            $transction->rollBack();
            file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/mine-ticket/used/') . 'error-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "变更等级错误信息：" . $e->getMessage() . "\n\r", FILE_APPEND);
            die;
        }
        echo "mine-ticket change run success" . date('Y-m-d H:i:s') . "\n\r";
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