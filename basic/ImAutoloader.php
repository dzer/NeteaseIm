<?php

/**
 * 自动注册类.
 * 
 * @author dx <358654744@qq.com>
 * @date 2015-11-04
 *
 * @version 1.0
 */
ImAutoloader::register();

class ImAutoloader
{
    /**
     * 注册自动加载方法.
     * 
     * @return bool
     */
    public static function register() {
        if (function_exists('__autoload')) {
            spl_autoload_register('__autoload');
        }
        //获取所有已注册的__autoload()函数并注销
        $functions = spl_autoload_functions();
        foreach ($functions as $function) {
            spl_autoload_unregister($function);
        }
        //加入我们的自动加载方法，并重新注册到__autoload栈中
        $functions = array_merge(array(array('ImAutoloader', 'load')), $functions);
        foreach ($functions as $function) {
            $x = spl_autoload_register($function);
        }
        return $x;
    }

    /**
     * 自动加载类.
     *
     * @param string $className 类名
     */
    public static function load($className)
    {
        if ((class_exists($className, false)) || (strpos($className, 'Im') !== 0)) {
            return false;
        }
        $classFilePath = IM_ROOT.'/lib/'.$className.'.php';
        if (file_exists($classFilePath) === false) {
            $classFilePath = IM_ROOT.'/basic/'.$className.'.php';
        }
        if ((file_exists($classFilePath) === false) || (is_readable($classFilePath) === false)) {
            return false;
        }

        require $classFilePath;
    }
}
