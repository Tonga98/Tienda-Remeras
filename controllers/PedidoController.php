<?php
require_once 'models/pedido.php';
class PedidoController{

    public function hacer(){
        //Este metodo carga la vista del formulario para crear un pedido

        //Cargo vista
        require_once 'views/pedido/hacer.php';
    }

    public function add(){
        //Este metodo guarda un pedido en la bd

        //Cargo la db
        $db = Database::conectar();
        $exito = false;


        if(isset($_POST) && isset($_SESSION['identity'])){
            //si recibo datos por post
            $direccion = isset($_POST['direccion']) ? $db->real_escape_string($_POST['direccion']) : null;
            $localidad = isset($_POST['localidad']) ? $db->real_escape_string($_POST['localidad']) : null;
            $provincia = isset($_POST['provincia']) ? $db->real_escape_string($_POST['provincia']) : null;

            //verifico tener los datos
            if(!empty($provincia) && !empty($direccion) && !empty($localidad)){
                //Obtengo el id del usuario
                $usuarioId = $_SESSION['identity']->id;

                //Obtengo coste total del pedido
                $costeTotal = Utils::carritoStats();

                //Creo un pedido
                $pedido = new Pedido($usuarioId, $direccion, $localidad, $costeTotal, $provincia);

                //Guardar un pedido
                $exito = $pedido->save();
            }

            if(!$exito){
                $_SESSION['pedido'] = "failed";
            }else{
                $_SESSION['pedido'] = 'complete';

            }
            header('Location:'.base_url.'pedido/confirmado');
        }
    }

    public function confirmado()
    {
        //Este modulo carga una vista luego de confirmar un pedido

        if (isset($_SESSION['identity'])) {

        //Obtengo el id del usuario
        $usuarioID = $_SESSION['identity']->id;

        //Creo un pedido para obtener el id y la direccion
        $unPedido = new Pedido();
        $unPedido->setUsuarioId($usuarioID);
        $unPedido = $unPedido->obtenerUnPedidoPorUsuario();

        require_once 'views/pedido/confirmado.php';
    }else{
            header('Location:'.base_url);
        }
    }

    public function misPedidos(){
        //Este modulo muestra los pedidos de un usuario

        if($_SESSION['identity']) {
            //Obtengo el id del usuario
            $usuarioID = $_SESSION['identity']->id;

            //Obtengo los pedidos del usuario
            $pedidos = new Pedido();
            $pedidos->setUsuarioId($usuarioID);
            $pedidos = $pedidos->obtenerTotalDeUsuario();
        }
            require_once 'views/pedido/misPedidos.php';

    }

    public function detalles(){
        //Este modulo muestra los detalles de un pedido especifico
        //Cargo la bd
        $bd = Database::conectar();

        //Obtengo el id del producto
        $pedidoID = isset($_GET['id']) ? $bd->real_escape_string($_GET['id']) : null;

        if(isset($pedidoID)){
            //Creo un pedido y obtengo los detalles
            $unPedido = new Pedido();
            $unPedido->setId($pedidoID);
            $unPedidoDetalles = $unPedido->obtenerDetalles();

            //Obtengo los productos del pedido
            $productos = $unPedido->obtenerProductos();
        }
        require_once 'views/pedido/detalles.php';
    }

    public function gestion(){
        //Este metodo muestra un listado con todos los pedidos

        //Si es admin
        Utils::isAdmin();
        $gestion = true;

        //Obtengo todos los pedidos
        $pedidos = new Pedido();
        $pedidos = $pedidos->obtenerTodos();

        require_once 'views/pedido/misPedidos.php';
    }

    public function estado(){
        //Este modulo modifica el estado de un pedido
        //Cargo la bd
        $db = Database::conectar();

        //Solo si es admin
        Utils::isAdmin();

        //Recibo valor del select
        $estado = isset($_POST['estado']) ? $db->real_escape_string($_POST['estado']) : null;
        $pedido_id = $_POST['pedido_id'];

        //Creo un pedido para actualizar su estado
        $pedido = new Pedido();
        $pedido->setId($pedido_id);
        $pedido->setEstado($estado);
        $result = $pedido->modificarEstado();

        if($result){
            $_SESSION['mensajeGeneral'] = "Estado actualizado con exito!";
        }else{
            $_SESSION['mensajeGeneral'] = "Error al actualizar estado!";
        }

        //Cierro db y libero recursos
        $db->close();

        header('Location:'.base_url.'pedido/gestion');
    }
}
