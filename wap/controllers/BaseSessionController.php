<?php

namespace wap\controllers;

use Yii;
use yii\db\Exception;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Controller;
use yii\helpers\Json;

/**
 * Base controller
 */
class BaseSessionController extends Controller
{
    private $openid = null;
    private $unionid = null;
    private $session_key = null;

    /*   public function behaviors()
       {
           $behaviors = parent::behaviors();
           $behaviors['authenticator'] = [
               'class' => CompositeAuth::className(),
               'authMethods' => [
                   HttpBasicAuth::className(),
                   HttpBearerAuth::className(),
                   QueryParamAuth::className(),
               ],
           ];
           return $behaviors;
       }
    */


    public function beforeAction($action)
    {
        if (\Yii::$app->request->isPost) {
            $session = \Yii::$app->request->post('session');
            if (!isset($session)) {
                $this->redirect('https://api.xixiarts.cn/fail/invalid');
            }
            //从redis的session里取出openid
            try {
                $this->openid = \Yii::$app->redis->hget($session, 'openid');
                $this->unionid = \Yii::$app->redis->hget($session, 'unionid');

                $this->session_key = \Yii::$app->redis->hget($session, 'session_key');
                if (isset($this->openid)) {
                    return parent::beforeAction($action);
                }
                $this->redirect('https://api.xixiarts.cn/fail/reload');
            } catch (Exception $e) {
                $this->redirect('https://api.xixiarts.cn/fail/fail');
            }
        } else
            return parent::beforeAction($action);
    }

    public function getOpenid()
    {
        return $this->openid;
    }

    public function getUnionid()
    {
        return $this->unionid;
    }

    public function getSession()
    {
        return $this->session_key;
    }


}
