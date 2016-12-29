<?php

namespace App\Services;

class BaseService
{

    const EMPTY_NOTE = 'is not empty!';

    protected static $instances = [];

    // 私有化构造方法
    private final function __construct()
    {
        $this->init();
    }


    /**
     * 子类的初始化方法
     */
    protected function init()
    {
    }

    /**
     * 获取单一实例
     * @return static
     */
    public static function getInstance()
    {
        $cls = get_called_class();
        if (!array_key_exists($cls, static::$instances)) {
            static::$instances[$cls] = new static();
        }
        return static::$instances[$cls];
    }

    protected function _debug($data){

        if(is_array($data)){
            echo json_encode($data);die();
        }
        print_r($data);exit();
    }
}
