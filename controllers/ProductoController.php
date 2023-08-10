<?php
require_once 'models/producto.php';
require_once 'models/categoria.php';
require_once "config/Database.php";

class ProductoController
{

    public function index()
    {

        //Este modulo muestra en inicio 6 productos destacados

        $productos = new Producto();
        $productos = $productos->obtenerRandom();

        require_once 'views/productos/destacados.php';
    }

    public function ver()
    {
        //Este modulo muestra el detalle de un producto

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $productoID = $_GET['id'];

            $producto = new Producto();
            $producto->setId($productoID);

            //Si encuentra el producto con ese id lo retorna, si no lo encuentra entonces $producto=false
            $producto = $producto->obtenerUnProducto();

            //Cargo la vista
            require_once 'views/productos/ver.php';

        }
    }

    public function gestion()
    {
        //Este modulo muestra una tabla con todos los productos
        //Entro solo si es admin
        Utils::isAdmin();

        //Conecto a la base de datos
        $bd = Database::conectar();

        //Obtengo productos
        $productos = new Producto();
        $productos = $productos->obtenerProductos();

        //Cargo vista
        require_once 'views/productos/gestion.php';
    }

    public function crear()
    {
        //Este modulo muestra el formulario para guardar un producto
        //Entro solo si es admin
        Utils::isAdmin();

        //Obtengo las categorias para mostrarlas en un select
        $categorias = new Categoria();
        $categorias = $categorias->getCategorias();

        //Cargo vista del formulario
        require_once 'views/productos/crear.php';
    }

    public function guardar()
    {
        //Este modulo guarda un producto
        //Cargo bd
        $bd = Database::conectar();

        //Si recibo parametro por get estoy editando un producto
        $editing = isset($_GET['id']);

        if (isset($_POST)) {
            $error = false;

            //Valido datos recibidos por post
            $nombre = !empty($_POST['nombre']) ? $bd->real_escape_string($_POST['nombre']) : null;
            $descripcion = !empty($_POST['descripcion']) ? $bd->real_escape_string($_POST['descripcion']) : null;
            $precio = !empty($_POST['precio']) ? (float)$_POST['precio'] : null;
            $stock = !empty($_POST['stock']) ? (int)$_POST['stock'] : null;
            $oferta = !empty($_POST['oferta']) ? $bd->real_escape_string($_POST['oferta']) : null;
            $imagen = "";

            //Si estoy editando obtengo el producto
            if ($editing) {
                $producto = new Producto();
                $producto->setId($_GET['id']);
                $producto = $producto->obtenerUnProducto();
                $imagen = $producto->imagen;
            }


            //Valido nombre
            if (!isset($nombre) || is_numeric($nombre)) {
                $error = true;
            }

            //valido descripcion
            if (!isset($descripcion) || is_numeric($descripcion)) {
                $error = true;
            }

            //valido precio
            if (!isset($precio) || !is_numeric($precio)) {
                $error = true;
            }

            //Valido stock
            if (!isset($stock) || !is_numeric($stock)) {
                $error = true;
            }

            //valido oferta
            if (!isset($oferta) || is_numeric($oferta)) {
                $error = true;
            }

            if (!empty($_FILES['imagen'])) {
                //Guardar imagen
                $file = $_FILES['imagen'];
                $fileName = $file['name'];
                $mimetype = $file['type'];

                if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {
                    if (!is_dir('uploads/images')) {
                        mkdir('uploads/images', 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], 'uploads/images/' . $fileName);
                    $imagen = $fileName;
                }
            }

            //si no tuve errores creo un usuario nuevo con los datos recibidos
            if (!$error) {
                $producto = new Producto($nombre, $descripcion, $precio, $stock, '', $imagen, $_POST['categoria']);

                //Si estoy editando lo actualizo sino lo guardo,
                if ($editing) {
                    $producto->setId($_GET['id']);
                    $error = !$producto->editar();
                } else {
                    $error = !$producto->guardar();
                }
            }
            //Si tuve un error
            if ($error) {
                $_SESSION['mensajeGeneral'] = 'Error al guardar el producto!';
                header('Location:' . base_url . 'Producto/crear');
            } else {
                $_SESSION['mensajeGeneral'] = 'Producto guardado con exito!';
                header('Location:' . base_url . 'Producto/gestion');
            }
        }
    }

    public function editar()
    {
        //Este modulo muestra el formulario para editar un producto
        //Entro solo si es admin
        Utils::isAdmin();

        //Si recibo el id por get entro
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {

            //Recibo id del producto a editar
            $productoId = $_GET['id'];

            $editar = true;

            //Obtengo las categorias para mostrarlas en un select
            $categorias = new Categoria();
            $categorias = $categorias->getCategorias();

            //Obtengo el producto recibido por el id para mostrarlo en el formulario
            $producto = new Producto();
            $producto->setId($productoId);
            $producto = $producto->obtenerUnProducto();

            //Cargo misma vista que al crear
            require_once 'views/productos/crear.php';
        } else {
            header('Location:' . base_url . 'producto/gestion');
        }
    }

    public function eliminar()
    {
        //Este modulo elimina un producto, del cual recibe si id por get

        //Elimino solo si es admin
        Utils::isAdmin();

        $exito = false;

        //Valido id y elimino el producto
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $producto = new Producto();
            $producto->setId($_GET['id']);
            $exito = $producto->eliminar();
        }
        //Si no tuve error creo sesion para mostrar mensaje
        if ($exito) {
            $_SESSION['mensajeGeneral'] = "Producto eliminado con exito!";
        } else {
            $_SESSION['mensajeGeneral'] = "Error al eliminar producto";
        }
        header('Location:' . base_url . "producto/gestion");
    }
}