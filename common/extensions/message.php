<?php
namespace common\extensions;

use Yii;
use yii\helpers\Json;

class message
{
    private $cache = null;
    private $appid = 'wx05758470fcd4b91f';
    private $secret = 'e4abe79400604b94f4321953226a5033';
    private $cacheKey = '';

    public function __construct()
    {
        $this->cache = Yii::$app->cache;
        $this->cacheKey = 'wechat_message_token_' . $this->appid;
    }

    /**
     * @name 获取token
     * @author fjl
     * @return int|mixed
     */
    public function getToken()
    {
        if (Yii::$app->cache->get($this->cacheKey)) {
            $wechat_message_token = Yii::$app->cache->get($this->cacheKey);
            return $wechat_message_token;
        } else {
            $json = $this->vget('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->secret);

            $result = (array)json_decode($json);
            if ($result && isset($result['access_token'])) {
                $wechat_message_token = $result['access_token'];
                Yii::$app->cache->set($this->cacheKey, $wechat_message_token,6000);
                return $wechat_message_token;
            } else {
                throw new \Exception(Json::encode($result));
                // return $result;
            }
        }
        /* Yii::$app->cache->set($this->cacheKey, $wechat_message_token);
         $wechat_message_token = Yii::$app->cache->get($this->cacheKey);
     } else {
         $wechat_message_token = null;
     }

 }*/

    }


    /**
     * @name 发送消息
     * @author fjl
     * @param $xjson
     * @return mixed
     */
    public
    function sendMsg($xjson)
    {
        restart:
        $url = "https://api.weixin.qq.com/cgi-Vbin/message/custom/send?access_token=" . $this->getToken();
        $json = $this->vpost($url, $xjson);
        $result = json_decode($json);
        if($result['errcode']==40001){
            Yii::$app->cache->delete($this->cacheKey);
            goto restart;
        }
        return $result;
    }

    /**
     * @name 微信消息模板消息发送
     * @author fjl
     * @param $openid
     * @param $template_id
     * @param $page
     * @param $data
     * @param string $topcolor
     * @return mixed
     */
    public
    function templateSend($openid, $template_id, $page,$prepay_id, $data, $topcolor = '#FF0000')
    {
        restart:
        $postData = [];
        $postData['touser'] = $openid;
        $postData['template_id'] = $template_id;
        $postData['page'] = $page;
        $postData['form_id'] =
        $postData['topcolor'] = $topcolor;
        $postData['data'] = $data;
        $urls = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $this->getToken();
        $json = $this->vpost($urls, json_encode($postData));
        $result = json_decode($json, true);
        if($result['errcode']==40001){
            Yii::$app->cache->delete($this->cacheKey);
            goto restart;
        }
        //var_dump($result);die;
        /*echo Json::encode(['data' => $result]);
        exit;*/
        return $result;
    }

    /**
     * @name post
     * @author fjl
     * @param $url
     * @param $data
     * @return mixed|string
     */
    public
    function vpost($url, $data)
    { // 模拟提交数据函数
        $curl = curl_init(); // 启动CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的�?�?
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中�?查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        // curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            return 'Errno' . curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话

        return $tmpInfo; // 返回数据
    }

    /**
     * @name Get
     * @author fjl
     * @param $url
     * @return bool|mixed
     */
    public
    function vget($url)
    {
        $curl = curl_init(); // 启动CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            return 'Errno' . curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
}
