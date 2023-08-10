<?php
require_once 'models/Producto.php';

class CarritoController
{

    public function index()
    {
        //Este modulo muestra una lista con los elementos del carrito

        //Cargo la vista
        require_once "views/carrito/index.php";
    }

    public function add()
    {
        //Este modulo carga el producto del id recibido al carrito
        //$_GET['id']: Se refiere al id del producto que hay que agregar al carrito

        //Declaracion de variables
        $producto = "";
        $cantidad = 0;

        //Si recibo id por get, obtengo el producto asociado
        if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['cantidad']) && is_numeric($_GET['cantidad'])) {
            $productoId = $_GET['id'];
            $cantidad = $_GET['cantidad'];

            //Obtengo el producto a agregar
            $producto = new Producto();
            $producto->setId($productoId);
            $producto = $producto->obtenerUnProducto();

        } else if (!is_object($producto)) {
            header('Location:' . base_url);
        }

        //Si ya tengo productos en el carrito, recorro el carrito, si tengo dos productos iguales solo sumo una unidad mas
        $productoEnCarrito = false;
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['producto_id'] == $productoId) {
                    $_SESSION['carrito'][$indice]['unidades'] += $cantidad;
                    $productoEnCarrito = true;
                }
            }
        }

        //Agrego un producto nuevo al carrito
        if(!$productoEnCarrito) {
            $_SESSION['carrito'][] = array(
                "producto_id" => $producto->id,
                "imagen" => $producto->imagen,
                "nombre" => $producto->nombre,
                "precio" => $producto->precio,
                "unidades" => $cantidad,
                "producto" => $producto
            );
        }
        header('Location:' . base_url . "carrito/index");
    }

    public function deleteAll()
    {
        $_SESSION['carrito'] = null;
    }

    public function deleteOne(){
        //Este modulo elimina un producto del carrito mediante el id recibido
        //Cargo la db
        $db = Database::conectar();

        //Declaracion de variables
        $exito = false;
        $indice = 0;
        $productoID = isset($_GET['id']) ? $db->real_escape_string($_GET['id']) : null;
        $carrito = $_SESSION['carrito'];

        //Recorro el array hasta encontrar y eliminar el producto
        while (!empty($productoID) && !$exito && $indice<count($carrito)){
            if($carrito[$indice]['producto_id'] == $productoID){
               unset($carrito[$indice]);

                //Reindexo el array para evitar índices vacíos
                $carrito = array_values($carrito);
                $exito = true;
            }
            $indice++;
        }

        //Si el eliminar un producto no tengo mas productos en el carrito, cierro session carrito
        if(count($carrito) == 0){
            $_SESSION['carrito'] = null;
        }else{
            $_SESSION['carrito'] = $carrito;
        }


        header('Location:'.base_url.'carrito/index');
    }

    public function sumarProducto(){
        //Este modulo suma un producto al carrito del indice recibido

        //Conecto a la bd
        $db = Database::conectar();


        //Recibo el indice del producto
        $indice = isset($_GET['indice']) ? $db->real_escape_string($_GET['indice']) : null;
        $carrito = $_SESSION['carrito'];

        //Sumo una unidad del producto en la posicion indice recibida
        if($indice!=null){
            $carrito[$indice]['unidades'] += 1;
        }

        $_SESSION['carrito'] = $carrito;

        header('Location:'.base_url.'carrito/index');
    }

    public function restarProducto(){
        //Este modulo resta un producto al carrito del id recibido

        //Conecto a la bd
        $db = Database::conectar();

        //Recibo el indice del producto
        $indice = isset($_GET['indice']) ? $db->real_escape_string($_GET['indice']) : null;
        $carrito = $_SESSION['carrito'];


        //Elimino una unidad del carrito en la posicion indice recibida
                $carrito[$indice]['unidades'] -= 1;

                //Si tengo 0 unidades elimino el producto del carrito
                if($carrito[$indice]['unidades'] == 0){
                    unset($carrito[$indice]);
                }

        //Si el eliminar un producto no tengo mas productos en el carrito, cierro session carrito
        if(count($carrito) == 0){
            $_SESSION['carrito'] = null;
        }else{
            //Reindexo el array para evitar índices vacíos
            $carrito = array_values($carrito);
            $_SESSION['carrito'] = $carrito;
        }

        header('Location:'.base_url.'carrito/index');
    }
}