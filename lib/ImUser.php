<?php

/**
 * 用户操作类
 * 包括创建id，更新用户信息，获取用户信息，删除用户，更新token，拉黑，解除黑名单，好友关系
 * 
 * @author dx <358654744@qq.com>
 * @date 2015-11-05
 * @version 1.0
 */
class ImUser extends Imbase {

    //请求url
    private $url = array(
        //创建云信id
        'create' => 'https://api.netease.im/nimserver/user/create.action',
        //获取用户信息
        'getinfos' => 'https://api.netease.im/nimserver/user/getUinfos.action',
        //更新用户基本信息
        'update' => 'https://api.netease.im/nimserver/user/update.action',
        //更新用户详细信息
        'updateInfo' => 'https://api.netease.im/nimserver/user/updateUinfo.action',
        //更新用户token
        'refreshToken' => 'https://api.netease.im/nimserver/user/refreshToken.action',
        //封禁云信id
        'block' => 'https://api.netease.im/nimserver/user/block.action',
        //解禁云信id
        'unblock' => 'https://api.netease.im/nimserver/user/unblock.action',
        //添加好友
        'addFriend' => 'https://api.netease.im/nimserver/friend/add.action',
        //更新好友信息(加备注)
        'updateFriendInfo' => 'https://api.netease.im/nimserver/friend/update.action',
        //删除好友关系
        'deleteFriend' => 'https://api.netease.im/nimserver/friend/delete.action',
        //获取好友列表
        'getFriend' => 'https://api.netease.im/nimserver/friend/get.action',
        //设置黑名单/静音
        'setSpecialRelation' => 'https://api.netease.im/nimserver/user/setSpecialRelation.action',
    );

    /**
     * 创建云信ID
     * 参数说明 name昵称，props属性（json），icon头像url，token
     * @param type $data
     * @return string
     */
    public function create($data = null) {
        //参数
        $this->params = array('accid', 'name', 'props', 'icon', 'token');
        return $this->exec($this->url['create'], $data);
    }

    /**
     * 更新云信基本信息
     * 参数说明 name昵称，props属性（json），token
     * @param array $data
     * @return string
     */
    public function update($data = null) {
        $this->params = array('accid', 'name', 'props', 'token');
        return $this->exec($this->url['update'], $data);
    }

    /**
     * 更新用户详细信息
     * @param array $data
     * @return string
     */
    public function updateInfo($data = null) {
        $this->params = array('accid', 'name', 'icon', 'sign', 'email', 'birth', 'mobile', 'gender', 'ex');
        return $this->exec($this->url['updateInfo'], $data);
    }

    /**
     * 更新用户token并生成新token
     * @param string $accid
     * @return string
     */
    public function refreshToken($accid = null) {
        return $this->execByPk($this->url['refreshToken'], $accid);
    }

    /**
     * 获取用户信息
     * 可以批量获取，多人时以数组形式传入array(accid1,accid2)
     * @param void $ids
     * @return string 
     */
    public function getinfos($ids = null) {
        //参数
        $this->params = array('accids');
        $data = array();
        if (!empty($ids)) {
            $data['accids'] = is_array($ids) ? json_encode($ids) : json_encode(array($ids));
        } elseif (isset($this->data['accids'])) {
            $data['accids'] = is_array($this->data['accids']) ? json_encode($this->data['accids']) : json_encode(array($this->data['accids']));
        }
        return $this->exec($this->url['getinfos'], $data);
    }

    /**
     * 封禁云信id
     * @param string $accid
     * @return string
     */
    public function block($accid = null) {
        return $this->execByPk($this->url['block'], $accid);
    }

    /**
     * 接禁云信id
     * @param string $accid
     * @return string
     */
    public function unblock($accid = null) {
        return $this->execByPk($this->url['unblock'], $accid);
    }

    /**
     * 添加好友
     * 参数说明：accid加好友发起者id,
     *          faccid加好友接受者id,
     *          type  1直接加好友，2请求加好友，3同意加好友，4拒绝加好友
     *          msg 加好友请求消息
     * @param type $data
     * @return type
     */
    public function addFriend($data = null) {
        $this->params = array('accid', 'faccid', 'type', 'msg');
        return $this->exec($this->url['addFriend'], $data);
    }

    /**
     * 更新好友备注
     * 参数说明：accid发起者id,
     *          faccid要修改好友id,
     *          alias  好友备注名
     * @param type $data
     * @return type
     */
    public function updateFriendInfo($data = null) {
        $this->params = array('accid', 'faccid', 'alias');
        return $this->exec($this->url['updateFriendInfo'], $data);
    }

    /**
     * 删除好友关系
     * 参数说明：accid发起者id,
     *          faccid要删除的好友id
     * @param type $data
     * @return type
     */
    public function deleteFriend($data = null) {
        $this->params = array('accid', 'faccid');
        return $this->exec($this->url['deleteFriend'], $data);
    }

    /**
     * 查询某时间点起到现在有更新的双向好友
     * 参数说明：accid 发起者id,
     *          createtime 查询时间戳
     * @param type $data
     * @return type
     */
    public function getFriend($data = null) {
        $this->params = array('accid', 'createtime');
        return $this->exec($this->url['getFriend'], $data);
    }

    /**
     * 来黑/取消拉黑 设置静音/取消静音
     * 参数说明：accid 用户id,
     *          targetAcc 被加黑或加静音的帐号
     *          relationType 1黑名单操作 2静音操作
     *          value 0取消黑名单或取消静音 1加入黑名单或静音
     * @param type $data
     * @return type
     */
    public function setSpecialRelation($data = null) {
        $this->params = array('accid', 'targetAcc', 'relationType', 'value');
        return $this->exec($this->url['setSpecialRelation'], $data);
    }

}
