<?php
/**
 * Created by PhpStorm.
 * User: unknown
 * Date: 2017/12/21
 * Time: 16:25
 */

namespace manage\controllers;


use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @name 验证登录
     * BaseController constructor.
     */
    public function init()
    {
         if(!Yii::$app->session->get('username')){
             header('location:'.Yii::$app->urlManager->createUrl('/login/index'));
             exit;
         }
    }

}