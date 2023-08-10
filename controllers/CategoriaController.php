<?php
require_once 'models/Categoria.php';
require_once 'models/Producto.php';
require_once "config/Database.php";
class CategoriaController{

    public function index(){
        $categorias = new Categoria();
        $categorias = $categorias->getCategorias();
        require_once 'views/categorias/index.php';
    }

    public function crear(){
        //Cargo la vista, el formulario
        Utils::isAdmin();
        require_once 'views/categorias/crear.php';
    }

    public function guardar(){
        if (isset($_POST) && Utils::isAdmin()) {

            //Conecto a la db
            $db = Database::conectar();
            $error = false;

            //Recibo los datos del formulario y los valido
            $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : null;

            //Valido nombre
            if(!isset($nombre) || is_numeric($nombre) || preg_match('/[0-9]/',$nombre)){
                $error = true;
            }else {
                //Creo instancia de categoria
                $categoria = new Categoria($nombre);

                //La guardo
                $categoria->guardar();

            }
    }
        header('Location:'.base_url.'categoria/index');
    }

    public function productos()
    {
        if (isset($_GET) && is_numeric($_GET['id'])) {
            //id de categoria
            $id = $_GET['id'];

            //Obtengo todos los productos de una categoria
            $productos = new Producto();
            $productos = $productos->obtenerProductos($id);

            //Obtengo la categoria
            $categoria = new Categoria();
            $categoria = $categoria->getCategorias($id);
            $categoria = $categoria->fetch_object();



            require_once 'views/productos/deCategoria.php';
        }
    }
}