<?php

class Autoloader{
  /**
   * Register our autoloader
   *
   * @return void
   */
  static function register() {
    spl_autoload_register(array(__CLASS__, 'autoload'));
  }

  /**
   * Gets the right file to load the class
   * @param $class string the name of the class we want to load
   */
  static function autoload($className) {
    $fileName = '';

    $className = ltrim(preg_replace("/^Project\\\\/", "", $className), '\\');

    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $fileName;

    if (file_exists($fileName)) {
        require $fileName;
    }
  }

}
