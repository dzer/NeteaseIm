<?php

/**
 * 基础请求类.
 * 
 * @author dx <358654744@qq.com>
 * @date 2015-11-04
 *
 * @version 1.0
 */
class ImRequest
{
    //appkey
    private $appKey;
    //秘钥
    private $appSecret;
    //随机数
    private $nonce;
    //cURL允许执行的最长秒数
    private $readTimeout;
    //在发起连接前等待的时间
    private $connectTimeout;

    public function __construct($appKey = '', $appSecret = '')
    {
        if (empty($appKey) || empty($appSecret)) {
            $this->appKey = IMConfig::APPKEY;
            $this->appSecret = IMConfig::APPSECRET;
        }
        if (empty($this->appKey) || empty($this->appSecret)) {
            throw new Exception('APPkey或appSecret不能为空');
            exit();
        }
        $this->nonce = $this->randString();
    }

    /**
     * 执行请求方法.
     *
     * @param string $url
     * @param array  $postFields
     */
    public function exec($url, $postFields = null)
    {
        //当前时间戳
        $curTime = time();
        $headerFields = array(
            'Appkey: '.$this->appKey,
            'Nonce: '.$this->nonce,
            'CurTime: '.$curTime,
            'CheckSum: '.$this->checkSum($curTime),
        );

        return $this->curl($url, $headerFields, $postFields);
    }

    /**
     * 计算checkSum校验值
     * 
     * @param int $curTime
     *
     * @return string
     */
    private function checkSum($curTime)
    {
        return sha1($this->appSecret.$this->nonce.$curTime);
    }

    /**
     * 生成随机字符串.
     * 
     * @param int $length 随机字符串长度
     *
     * @return string
     */
    private function randString($length = 20)
    {
        $string = '1234567890qwertyuiopasdfghjklzxcvbnm~!#$%^&*()_+';

        return substr(str_shuffle($string), 0, $length);
    }

    /**
     * 请求方法
     * 支持http和https请求
     *
     * @param string $url          请求地址
     * @param array  $headerFields 请求头参数
     * @param array  $postFields   请求体参数
     *
     * @throws Exception
     */
    private function curl($url, $headerFields = null, $postFields = null)
    {
        $ch = curl_init();
        //请求url地址
        curl_setopt($ch, CURLOPT_URL, $url);
        //HTTP状态码
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //设置cURL允许执行的最长秒数
        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }
        //尝试连接等待时间
        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'top-sdk-php');
        //https 请求(当请求https的数据时，会要求证书，这时候，加上下面这两个参数，规避ssl的证书检查)
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = '';
            $postMultipart = false;
            foreach ($postFields as $k => $v) {
                if ('@' != substr($v, 0, 1)) {
                    //判断是不是文件上传
                    $postBodyString .= "$k=".urlencode($v).'&';
                } else {
                    //文件上传用multipart/form-data，否则用www-form-urlencoded
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headerFields);
            } else {
                $contentType = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
                array_push($headerFields, $contentType);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headerFields);
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }
        $reponse = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($reponse, $httpStatusCode);
            }
        }
        //记录日志
        if (IM_DEBUG) {
            $log = "header: \r\n".print_r($headerFields, true)."\r\n"
                 ."body: \r\n".print_r($postFields, true)."\r\n"
                 ."response: \r\n".print_r($reponse, true)."\r\n";
            ImLog::write($log);
        }
        curl_close($ch);

        return $reponse;
    }
}
