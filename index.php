<?php
session_start();
require_once 'helpers/Utils.php';
require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'views/layout/header.php';
require_once 'views/layout/sidebar.php';

//Compruebo si recibo el controlador del usuario y si existe y si existe el metodo llamado con action
if(isset($_GET['controller']) && class_exists($_GET['controller'].'Controller') && isset($_GET['action']) && method_exists($_GET['controller'].'Controller', $_GET['action'])){

    //Recibo nombre de la clase y la creo
    $nombreControlador = $_GET['controller'].'Controller';
    $controlador = new $nombreControlador();

    //Llamo al metodo recibido por el get de la clase $controlador
    $action = $_GET['action'];
    $controlador->$action();

}else if(!isset($_GET['controller']) && !isset($_GET['action'])){
    $nombreControlador = default_controller;
    $controlador = new $nombreControlador();
    $nombreMetodo = action_default;
    $controlador->$nombreMetodo();
}else{
    $error = new ErrorController();
    $error->index();
}
require_once 'views/layout/footer.php';

