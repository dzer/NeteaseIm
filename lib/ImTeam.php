<?php

class ImTeam extends Imbase {

    private $url = array(
        //创建高级群
        'create' => 'https://api.netease.im/nimserver/team/create.action',
        //拉人入群
        'add' => 'https://api.netease.im/nimserver/team/add.action',
        //踢人出群
        'kick' => 'https://api.netease.im/nimserver/team/kick.action',
        //解散群
        'remove' => 'https://api.netease.im/nimserver/team/remove.action',
        //编辑群资料
        'update' => 'https://api.netease.im/nimserver/team/update.action',
        //群信息与成员列表查询
        'query' => 'https://api.netease.im/nimserver/team/query.action',
        //移交群主
        'changeOwner' => 'https://api.netease.im/nimserver/team/changeOwner.action',
        //任命管理员
        'addManager' => 'https://api.netease.im/nimserver/team/addManager.action',
        //移除管理员
        'removeManager' => 'https://api.netease.im/nimserver/team/removeManager.action',
        //获取某用户所加入的群信息
        'joinTeams' => 'https://api.netease.im/nimserver/team/joinTeams.action',
        
        
    );  
            

    /**
     * 创建高级群
     * 
     * 请求参数说明：
     * tname    群名称
     * owner    群主用户账号
     * members  JsonArray对应的accid
     * announcement 群公告
     * intro    群描述
     * msg  邀请发送的文字
     * magree   管理后台建群时，0不需要被邀请人同意加入群，1需要被邀请人同意才可以加入群。
     * joinmode 群建好后，sdk操作时，0不用验证，1需要验证,2不允许任何人加入。
     * custom   自定义高级群扩展属性
     * 
     * @param array $data
     * @retrun string 
     */
    public function create($data = null) {
        $this->params = array(
            'tname', 'owner', 'members', 'announcement', 'intro',
            'msg', 'magree', 'joinmode', 'custom'
        );
        return $this->exec($this->url['create'], $data);
    }

    /**
     * 拉人入群(可以批量邀请)
     * 
     * 请求参数说明：
     * tid  群id
     * owner    群主用户帐号
     * members  (JsonArray对应的accid
     * magree   管理后台建群时，0不需要被邀请人同意加入群，1需要被邀请人同意才可以加入群。
     * msg      邀请发送的文字
     * 
     * @param array $data
     * @return string 
     */
    public function add($data = null) {
        $this->params = array('tid', 'owner', 'members', 'magree', 'msg');
        return $this->exec($this->url['add'], $data);
    }

    /**
     * 踢人出群
     * 
     * 请求参数说明：
     * tid  群id
     * owner    群主账号
     * member   被移除人得accid
     * 
     * @param array $data
     * @return string
     */
    public function kick($data = null) {
        $this->params = array('tid', 'owner', 'member');
        return $this->exec($this->url['kick'], $data);
    }

    /**
     * 解散群
     * 
     * 请求参数说明：
     * tid  群id
     * owner    群主账号
     * 
     * @param array $data
     * @return string
     */
    public function remove($data = null) {
        $this->params = array('tid', 'owner');
        return $this->exec($this->url['remove'], $data);
    }

    /**
     * 编辑群资料
     * 
     * 请求参数说明：
     * tid  群id
     * tname    群名称
     * owner    群主用户帐号
     * announcement 群公告
     * intro    群描述
     * joinmode 群建好后，sdk操作时，0不用验证，1需要验证,2不允许任何人加入。
     * custom   自定义高级群扩展属性
     * @param array $data
     * @return string
     */
    public function update($data = null) {
        $this->params = array(
            'tid', 'tname', 'owner', 'announcement',
            'intro', 'joinmode', 'custom'
        );
        return $this->exec($this->url['update'], $data);
    }

    /**
     * 群信息与成员列表查询
     * 
     * 请求参数说明：
     * tids     群tid列表，如[\"3083\",\"3084"]
     * ope    1表示带上群成员列表，0表示不带群成员列表，只返回群信
     * 
     * @param array $data
     * @return string
     */
    public function query($data = null) {
        $this->params = array('tids', 'ope');
        return $this->exec($this->url['query'], $data);
    }

    /**
     * 移交群主
     * 
     * 请求参数说明：
     * tid      群di
     * owner    群主用户帐号
     * newowner 新群主帐号
     * leave    1:群主解除群主后离开群，2：群主解除群主后成为普通成员。
     * 
     * @param array $data
     * @return string
     */
    public function changeOwner($data = null) {
        $this->params = array('tid', 'owner', 'newowner', 'leave');
        return $this->exec($this->url['changeOwner'], $data);
    }

    /**
     * 任命管理员
     * 可以批量，但是最多不超过10个人
     * 请求参数说明：
     * tid      群di
     * owner    群主用户帐号
     * members JsonArray对应的accid
     * 
     * @param array $data
     * @return string
     */
    public function addManager($data = null) {
        $this->params = array('tid', 'owner', 'members');
        return $this->exec($this->url['addManager'], $data);
    }
    
    /**
     * 移除管理员
     * 可以批量，但是最多不超过10个人
     * 
     * 请求参数说明：
     * tid      群di
     * owner    群主用户帐号
     * members JsonArray对应的accid
     * 
     * @param array $data
     * @return string
     */
    public function removeManager($data = null) {
        $this->params = array('tid', 'owner', 'members');
        return $this->exec($this->url['removeManager'], $data);
    }
    
    /**
     * 获取某用户所加入的高级群信息
     * 
     * 请求参数说明：
     * accid    要查询用户的accid
     * 
     * @param array $data
     * @return string
     */
    public function joinTeams($accid = null) {
        return $this->execByPk($this->url['joinTeams'], $accid);
    }
    
    /**
     * 修改账号在群内的昵称
     * 
     * 请求参数说明：
     * tid      群id
     * owner    群主id
     * accid    要修改群昵称对应群成员的accid
     * nick     accid对应的群昵称
     * 
     * @param array $data
     * @return string
     */
    public function updateTeamNick($data = null) {
        $this->params = array('tid', 'owner', 'accid', 'nick');
        return $this->exec($this->url['updateTeamNick'], $data);
    }

}
