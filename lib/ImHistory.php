<?php

/**
 * 历史记录类
 * 包括单聊、群聊历史记录.
 * 
 * @author dx <358654744@qq.com>
 * @date 2015-11-05
 *
 * @version 1.0
 */
class ImHistory extends Imbase
{
    private $url = array(
        //单聊云端历史消息查询
        'querySessionMsg' => 'https://api.netease.im/nimserver/history/querySessionMsg.action',
        //群聊云端历史消息查询
        'queryTeamMsg' => 'https://api.netease.im/nimserver/history/queryTeamMsg.action',
    );

    /**
     * 单聊云端历史消息查询
     * 请求参数说明：
     * from     发送者accid
     * to       接收者accid
     * begintime    开始时间(微妙)
     * endtime  截止时间(微妙)
     * limit    本次查询的消息条数上限(最多100条),
     * reverse  1按时间正序排列，2按时间降序排列。
     * 
     * @param array $data
     *
     * @return string
     */
    public function querySessionMsg($data = array())
    {
        $this->params = array(
            'from', 'to', 'begintime',
            'endtime', 'limit', 'reverse',
        );

        return $this->exec($this->url['querySessionMsg'], $data);
    }

    /**
     * 群聊云端历史消息查询
     * 请求参数说明：
     * tid     群id
     * accid       查询用户对应的accid.
     * begintime    开始时间(微妙)
     * endtime  截止时间(微妙)
     * limit    本次查询的消息条数上限(最多100条),
     * reverse  1按时间正序排列，2按时间降序排列。
     * 
     * @param array $data
     *
     * @return string
     */
    public function queryTeamMsg($data = array())
    {
        $this->params = array(
            'tid', 'accid', 'begintime',
            'endtime', 'limit', 'reverse',
        );

        return $this->exec($this->url['queryTeamMsg'], $data);
    }
}
