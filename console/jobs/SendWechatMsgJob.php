<?php
namespace console\jobs;


use manage\services\CardService;
use yii\base\BaseObject;

class SendWechatMsgJob extends BaseObject implements \yii\queue\JobInterface
{
    public $url;
    public $file;

    public function execute($queue)
    {
        $param=[];
        CardService::service()->index($param);
        /*echo 2;
        file_put_contents($this->file, file_get_contents($this->url));*/
    }



}