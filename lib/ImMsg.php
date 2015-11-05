<?php

/**
 * 消息类
 * 包括发送消息，发送系统通知
 * 
 * @author dx <358654744@qq.com>
 * @date 2015-11-05
 * @version 1.0
 */
class ImMsg extends Imbase {

    private $url = array(
        //发送消息
        'sendMsg' => 'https://api.netease.im/nimserver/msg/sendMsg.action',
        //发送系统通知
        'sendAttachMsg' => 'https://api.netease.im/nimserver/msg/sendAttachMsg.action',
        //文件上传
        'upload' => 'https://api.netease.im/nimserver/msg/upload.action',
        //文件上传（multipart方式）
        'fileUpload' => 'https://api.netease.im/nimserver/msg/fileUpload.action'
    );

    /**
     * 发送普通消息
     * 参数说明： from 发送者accid、ope 0=点对点个人消息/1=群消息、
     * to ope==0表示accid ope==1 表示tid、
     * type 0=表示文本消息/1=表示图片/2=表示语音/3=表示视频/4=表示地理位置信息/6=表示文件/100=自定义消息类型
     * body 消息内容
     * option 发消息时特殊指定的行为选项
     * pushcontent 推送内容
     * @param array $data
     * @return string 
     */
    public function sendMsg($data = null) {
        $this->params = array('from', 'ope', 'to', 'type', 'body', 'option', 'pushcontent');
        return $this->exec($this->url['sendMsg'], $data);
    }

    /**
     * 发送自定义系统通知
     * 请求参数说明：
     * from 发送者accid
     * msgtype  0：点对点自定义通知，1：群消息自定义通知
     * to   msgtype==0是表示accid，msgtype==1表示tid
     * attach   自定义通知内容，第三方组装的字符串，建议是JSON串
     * pushcontentios 推送内容，如果此属性为空串，自定义通知将不会有推送（pushcontent + payload不能超过200字节）
     * payload  ios 推送对应的payload
     * sound 如果有指定推送，此属性指定为客户端本地的声音文件名
     * save 1表示只发在线，2表示会存离线，
     * @param array $data
     * @retrun string
     */
    public function sendAttachMsg($data = null) {
        $this->params = array('from', 'msgtype', 'to', 'attach', 'pushcontent', 'payload', 'sound', 'save');
        return $this->exec($this->url['sendAttachMsg'], $data);
    }

    /**
     * 文件上传
     * 请求参数说明：
     * content  字节流base64串(Base64.encode(bytes)) ，最大15M的字节流
     * type 上传文件类型
     * 
     * @param array $data
     * @return string
     */
    public function upload($data = null) {
        $this->params = array('content', 'type');
        return $this->exec($this->url['upload'], $data);
    }
    
    /**
     * 文件上传（multipart方式）
     * 请求参数说明：
     * content  最大15M的字节流
     * type 上传文件类型
     * 
     * @param array $data
     * @return string
     */
    public function fileUpload($data = null) {
        $this->params = array('content', 'type');
        return $this->exec($this->url['fileUpload'], $data);
    }

}
