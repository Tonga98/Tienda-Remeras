<?php
require_once 'config/Database.php';

class Producto
{

    //Atributos
    private int $id;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private string $imagen;
    private int $stock;
    private string $oferta;
    private string $fecha;
    private int $categoria_id;

    //Constructor
    public function __construct($nombre = "", $descripcion = "", $precio = 0, $stock = 0, $fecha = "", $imagen = "", $categoria_id = 0)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
        $this->categoria_id = $categoria_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    public function getOferta(): string
    {
        return $this->oferta;
    }

    public function setOferta(string $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getCategoriaId()
    {
        return $this->categoria_id;
    }

    public function setCategoriaId($categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }

    public function obtenerProductos($categoria_id = "")
    {
        //Este modulo obtiene todos los productos de una categoria
        //$categoria_id se refiere al id de la categoria de al cual se retornan los productos
        //Si $categoria_id es vacio entonces retorna todos los productos

        //Conecto a la base de datos
        $bd = Database::conectar();

        if ($categoria_id == "") {
            $sql = "SELECT * FROM productos";

        } else {
            $sql = "SELECT * FROM productos WHERE categoria_id=$categoria_id";
        }
        return $bd->query($sql);
    }

    public function obtenerUnProducto()
    {
        //Este modulo retorna un producto mediante su id
        //Conecto a la base de datos
        $bd = Database::conectar();

        //Realizo consulta
        $sql = "SELECT * FROM productos WHERE id=$this->id";
        $producto = $bd->query($sql);

        //Cierro conexion y libero recursos
        $bd->close();

        //Si encontro un producto retorna el objeto, sino retorna false
        if (is_object($producto) || $producto) {
            $producto = $producto->fetch_object();
        }

        return $producto;
    }

    public function obtenerRandom()
    {
        //Este modulo retorna 6 productos random para colocar en destacados

        //Conecto a la base de datos
        $db = Database::conectar();

        //Realizo consulta
        $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 6";
        $productos = $db->query($sql);

        //Cierro la conexion y libero recursos
        $db->close();

        return $productos;
    }

    public function guardar()
    {
        //Este modulo guarda un producto nuevo
        //Cargo la base de datos
        $db = Database::conectar();

        //Creo sentencia preparada para mayor seguridad
        $sql = "INSERT INTO productos(id,nombre, descripcion, precio, imagen, stock, oferta, fecha, categoria_id) VALUES (null,?, ?, ?, ?, ?, null,CURDATE(), ?)";
        $stmt = $db->prepare($sql);

        // Enlazo los valores de los parámetros a la sentencia preparada
        $stmt->bind_param('ssdsii', $this->nombre, $this->descripcion, $this->precio, $this->imagen, $this->stock, $this->categoria_id);

        //Ejecuto la consulta
        $result = $stmt->execute();

        // Cerrar la conexión y liberar recursos
        $stmt->close();
        $db->close();

        return $result;
    }

    public function editar()
    {
        // Este módulo edita un producto
        // Cargo la base de datos
        $db = Database::conectar();

        // Preparar la sentencia SQL con marcadores de posición
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, stock = ?, categoria_id = ? WHERE id = ?";
        $stmt = $db->prepare($sql);

        // Enlazar los valores de los parámetros a la sentencia preparada
        $stmt->bind_param("ssdsiii", $this->nombre, $this->descripcion, $this->precio, $this->imagen, $this->stock, $this->categoria_id, $this->id);

        // Ejecutar la sentencia preparada
        $result = $stmt->execute();

        // Cerrar la conexión y liberar recursos
        $stmt->close();
        $db->close();

        return $result;
    }

    public function eliminar()
    {
        //Este modulo elimina un producto
        //Cargo base de datos
        $db = Database::conectar();

        //Consulta para eliminar
        $sql = "DELETE FROM productos WHERE id = $this->id";

        return $db->query($sql);
    }

}