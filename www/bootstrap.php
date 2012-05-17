<?php
$includes = array(
    '/var/zend/1.11.10/library/',
    '/home/rmk.framework/library/'
);

set_include_path(implode(PATH_SEPARATOR, $includes) . get_include_path());

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Rmk');
