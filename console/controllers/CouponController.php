<?php


namespace console\controllers;


use common\models\CustomerCoupon;
use common\models\MineTicket;
use common\models\Opera;
use yii\console\Controller;

class CouponController extends Controller
{
    /**
     * @name 我的优惠券
     */
    public function actionUsed()
    {
        $transction = \Yii::$app->db->beginTransaction();
        try {
            $ticket=CustomerCoupon::find()
                ->select('coupon.expires,customer_coupon.id')
                ->leftJoin('coupon','coupon.id=customer_coupon.coupon_id')
                ->where(['is_expires'=>0])
                ->asArray()
                ->all();
            foreach ($ticket as $k=>$v){
                if($v['expires']<time()){
                    CustomerCoupon::updateAll(['is_expires'=>1],['id'=>$v['id']]);
                }
            }
            $transction->commit();
        } catch (\Exception $e) {
            $transction->rollBack();
            file_put_contents($this->isDir(\Yii::$app->getRuntimePath() . '/coupon/used/') . 'error-' . date('Y-m-d') . ".log", date('Y-m-d H:i:s') . "\n\r" . "变更等级错误信息：" . $e->getMessage() . "\n\r", FILE_APPEND);
            die;
        }
        echo "coupon used run success" . date('Y-m-d H:i:s') . "\n\r";
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