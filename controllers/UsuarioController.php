<?php
require_once 'config/parameters.php';
require_once 'models/Usuario.php';

class UsuarioController
{

    public function registro()
    {
        //Este modulo muestra por pantalla el formulario de registro
        require_once 'views/usuarios/registro.php';
    }

    public function guardar(){
        //Este modulo recibe los datos del usuario por post y los guarda en la bd

        //Declaracion de variables
        $bd = Database::conectar();
        $error = false;

        if (isset($_POST)) {

            //Valido los datos recibidos por post
            $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($bd,$_POST['nombre']) : null;
            $apellido = isset($_POST['apellido']) ? mysqli_real_escape_string($bd,$_POST['apellido']) : null;
            $email = isset($_POST['email']) ? mysqli_real_escape_string($bd,$_POST['email']) : null;
            $password = isset($_POST['password']) ? mysqli_real_escape_string($bd,$_POST['password']) : null;

            //Valido nombre
            if(!isset($nombre) || is_numeric($nombre) || preg_match('/[0-9]/',$nombre)){
                $error = true;
            }

            //valido apellido
            if(!isset($apellido) || is_numeric($apellido) || preg_match('/[0-9]/',$apellido)){
                $error = true;
            }

            //valido email
            if(!isset($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
                $error = true;
            }

            //valido password
            if(!isset($password)){
                $error = true;
            }

            //si no tuve errores creo un usuario nuevo con los datos recibidos
            if(!$error) {
                $usuario = new Usuario($nombre, $apellido, $email, $password, 'user');

                //Trato de guardarlo
                if ($usuario->guardar()) {
                    //Si se pudo guardar en la bbdd
                    $_SESSION['register'] = "complete";
                    header('Location:' . base_url);
                }else{
                    $error = true;
                }
            }
        }
        //Si tuve un error
        if ($error) {
        $_SESSION['register'] = 'failed';
        header('Location:' . base_url . 'Usuario/registro');
    }
    }

    public function login(){
        if(isset($_POST)){
            //Conecto a la base de datos
            $bd = Database::conectar();

            //Valido datos recibidos por post
            $email = isset($_POST['email']) ? mysqli_real_escape_string($bd, $_POST['email']) : null;
            $password = isset($_POST['password']) ? mysqli_real_escape_string($bd, $_POST['password']) : null;

            //valido email y password
            if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && isset($password)) {
                $usuario = new Usuario();
                $identity = $usuario->login($email, $password); //$usuario->login retorna el usuario completo
                if($identity && is_object($identity)){
                    $_SESSION['identity'] = $identity;
                    if($identity->rol == 'admin'){
                        $_SESSION['admin'] = true;
                    }
                }else{
                    $_SESSION['error_login'] = "Email o contraseña incorrectos";
                }
            }


        }
        header('Location:'.base_url);

    }

    public function logout(){
        if(isset($_SESSION['identity'])){
            $_SESSION['identity'] = null;
        }
        if(isset($_SESSION['admin'])){
            $_SESSION['admin'] = null;
        }
        if(isset($_SESSION['carrito'])){
            $_SESSION['carrito'] = null;
        }
        header('Location:'.base_url);
    }
}
