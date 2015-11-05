<?php

/**
 * 基础类
 * @author dx <358654744@qq.com>
 * @date 2015-11-05
 * @version 1.0
 */
class Imbase {
    //参数值
    private $data;
    //响应值
    public $reponse;
    //错误码
    public $error_code;
    //错误消息
    public $error_msg;
    //参数
    protected $params;
    
    /**
     * 执行请求
     * @param string $url
     * @param array $data
     * @return void
     */
    public function exec($url, $data = array()) {
        //格式化参数
        if (!empty($data)) {
            $this->formatData($this->params, $data);
        }

        $request = new ImRequest();
        $this->reponse = $request->exec($url, $this->data);
        //清空参数和值
        $this->emptyData();

        return $this->reponse;
    }
    
    /**
     * 根据accid执行请求
     * @param type $url
     * @param type $accid
     * @return boolean
     */
    public function execByPk($url, $accid = null, $data = null) {
        //格式化参数
        if (!empty($data)) {
            $this->formatData($this->params, $data);
        }
        if (!empty($accid)) {
            $this->data['accid'] = $accid;
        }
        
        //校验参数
        if ($this->checkParam()) {
            $request = new ImRequest();
            $this->reponse = $request->exec($url, $this->data);
            //清空参数和值
            $this->emptyData();
            
            return $this->reponse;
        } else {
            return false;
        }
        
    }

    /**
     * 校验参数
     */
    protected function checkParam() {
        if (!isset($this->data['accid']) || empty($this->data['accid'])) {
            throw new Exception('accid不能为空');
            $this->error_code = 1;
            $this->error_msg = 'accid不能为空';
            return false;
        } else {
            return true;
        }
        return true;
    }

    /**
     * 格式化参数
     * @param array $params
     * @param array $data
     */
    protected function formatData($params, $data) {
        if (!empty($params) && !empty($data)) {
            foreach ($params as $name) {
                if (isset($data[$name])) {
                    $this->data[$name] = $data[$name];
                }
            }
        }
        return $this->data;
    }

    /**
     * 读取不可访问属性的值
     * @param void $name
     * @return void
     */
    public function __get($name) {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * 赋值不可访问属性
     * @param void $name
     * @param void $value
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * 清空参数和值
     */
    protected function emptyData() {
        $this->data = null;
        $this->params = null;
    }

}
