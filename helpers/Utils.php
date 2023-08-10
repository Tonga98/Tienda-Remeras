<?php
require_once 'config/Database.php';
class Utils{

    public static function deleteSessions():void{
        //Este modulo borra las sessiones creadas
        $_SESSION['register'] = null;
        $_SESSION['error_login'] = null;
        $_SESSION['mensajeGeneral'] = null;

    }

    public static function isAdmin(){
        //Este modulo verifica si la session iniciada es de admin
        $result = false;
        if(!isset($_SESSION['admin'])){
            header('Location:'.base_url);
        }else{
            $result = true;
        }
        return $result;
    }

    public static function carritoStats(){
        //Este modulo retorna el valor total a pagar del carrito
        $valorTotal = 0;

        foreach ($_SESSION['carrito'] as $indice => $elemento){
            $valorTotal += ($elemento['unidades'] * $elemento['precio']);
        }
        return $valorTotal;
    }

}
