<?php

/**
 * 自动注册类
 * 
 * @author dx <358654744@qq.com>
 * @date 2015-11-04
 * @version 1.0
 */
ImAutoloader::register();

class ImAutoloader {

    /**
     * 注册自动加载方法
     * 
     * @return bool
     */
	public static function register() {
		if (function_exists('__autoload')) {
			//激活__autoload
			spl_autoload_register('__autoload');
		}
		//避免冲突，显示注册到__autoload栈中
		return spl_autoload_register(array('ImAutoloader', 'load'));
	}

    /**
     * 自动加载类
     *
     * @param string  $className  类名
     */
    public static function load($className) {
        if ((class_exists($className, false)) || (strpos($className, 'Im') !== 0)) {
            return false;
        }
        $classFilePath = IM_ROOT . '/lib/' . $className . '.php';
        if (file_exists($classFilePath) === false) {
            $classFilePath = IM_ROOT . '/basic/' . $className . '.php';
        }
        if ((file_exists($classFilePath) === false) || (is_readable($classFilePath) === false)) {
            return false;
        }

        require($classFilePath);
    }

}
