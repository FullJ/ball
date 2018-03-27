<?php
namespace manage\modules\test\controllers;

use Yii;
use yii\web\Controller;

/**
 * Test controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        /*Yii::$app->redis->set('a', 1);
        $redis = Yii::$app->redis->get('a');
        print_r($redis);*/
        $data = ['data' => 'aaa'];
        return $this->render('index', $data);
    }
}
