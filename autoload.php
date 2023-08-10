<?php

function app_autoloader($className){
    require_once 'controllers/'.$className.'.php';
}

spl_autoload_register('app_autoloader');