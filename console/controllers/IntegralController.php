<?php


namespace console\controllers;



use common\models\WeappMember;
use yii\console\Controller;

class IntegralController extends Controller
{
    /**
     * @name 所有会员的积分清零，一个月跑一次
     */
    public function actionFlush()
    {
        $transction = \Yii::$app->db->beginTransaction();
        try {
            $data=WeappMember::find()->asArray()->all();
            foreach ($data as $k=>$v){

            }

            $transction->commit();
        } catch (\Exception $e) {
            $transction->rollBack();
            file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/integral/') . 'integral-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "变更等级错误信息：" . $e->getMessage() . "\n\r", FILE_APPEND);
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

}