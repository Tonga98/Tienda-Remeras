<?php

class Pedido{


    //Atributos
    private int $id = 0;
    private int $usuario_id = 0;
    private String $direccion = "";
    private String $localidad = "";
    private float $coste = 0;
    private String $fecha = "";
    private String $hora = "";
    private String $estado = "";
    private String $provincia = "";

    //Constructor
    public function __construct($usuario_id=0, $direccion="", $localidad="", $coste=0, $provincia=""){

        $this->usuario_id = $usuario_id;
        $this->direccion = $direccion;
        $this->localidad = $localidad;
        $this->coste = $coste;
        $this->provincia = $provincia;

    }

    //Metodos get y set
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function setLocalidad($localidad): void
    {
        $this->localidad = $localidad;
    }

    public function getCoste()
    {
        return $this->coste;
    }

    public function setCoste($coste): void
    {
        $this->coste = $coste;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getHora(): string
    {
        return $this->hora;
    }

    public function setHora(string $hora): void
    {
        $this->hora = $hora;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia): void
    {
        $this->provincia = $provincia;
    }

    //Metodos de tipo
    public function save(){
        //Este modulo guarda el pedido en la bd
        //Cargo la bd
        $db = Database::conectar();

        //Creo sentencia preparada para mayor seguridad
        $sql = "INSERT INTO pedidos (usuario_id, direccion, localidad, coste, fecha, hora, estado, provincia) VALUES (?, ?, ?, ?, CURDATE(), CURTIME(), 'confirmado', ?)";
        $stmt = $db->prepare($sql);

        //Enlazo los valores de los parametros a la sentencia preparada
        $stmt->bind_param('issds', $this->usuario_id, $this->direccion, $this->localidad, $this->coste, $this->provincia);

        //Ejecuto la consulta
        $result = $stmt->execute();

        //Guardo la linea
        if($result) {
            $result = $this->save_linea($db); //Le paso la db porque si la abro en el modulo se me va el ultimo insert_id
        }

        //Cerrar la conexión y liberar recursos
        $stmt->close();
        $db->close();

        return $result;
    }

    public function save_linea($db){
        //Este modulo guarda un registro relacionando cada producto con su pedido

        //Obtengo el id del ultimo pedido
        $pedido_id = $db->insert_id;
        $result = false;

        //Recorro el carrito y guardo todos los productos con su pedido
        foreach ($_SESSION['carrito'] as $indice => $elemento){
            $producto_id = $_SESSION['carrito'][$indice]['producto_id'];
            $unidades = $_SESSION['carrito'][$indice]['unidades'];
            $sql = "INSERT INTO lineas_pedido VALUES (null, {$pedido_id}, {$producto_id}, {$unidades})";
            $result = $db->query($sql);

            if(!$result){
                break;
            }
        }
        return $result;
    }

    public function obtenerUnPedidoPorUsuario()
    {
        //Este modulo retorna un pedido mediante el id del usuario
        //Conecto a la base de datos
        $bd = Database::conectar();

        //Realizo consulta
        $sql = "SELECT p.id, p.direccion, p.coste FROM pedidos p ".
                 "WHERE p.usuario_id={$this->usuario_id} ".
        "ORDER BY p.id DESC LIMIT 1";
        $pedido = $bd->query($sql);

        //Cierro conexion y libero recursos
        $bd->close();

        //Si encontro un producto retorna el objeto, sino retorna false
        if (is_object($pedido) || $pedido) {
            $pedido = $pedido->fetch_object();
        }

        return $pedido;
    }

    public function obtenerTotalDeUsuario(){
        //Este metodo retorna todos los pedidos de un usuario
        //Conecto a la db
        $db = Database::conectar();

        $sql = "SELECT p.id, p.coste, p.fecha, p.estado FROM pedidos p".
            " WHERE usuario_id={$this->usuario_id}";
        $pedidos = $db->query($sql);

        return $pedidos;
    }

    public function obtenerDetalles()
    {
        //Este modulo retorna un pedido mediante el id del pedido
        //Conecto a la base de datos
        $bd = Database::conectar();

        //Realizo consulta
        $sql = "SELECT p.id, p.direccion, p.localidad, p.provincia, p.coste, p.estado FROM pedidos p ".
            "WHERE p.id={$this->id} ";
        $pedido = $bd->query($sql);

        //Cierro conexion y libero recursos
        $bd->close();

        //Si encontro un producto retorna el objeto, sino retorna false
        if (is_object($pedido) || $pedido) {
            $pedido = $pedido->fetch_object();
        }

        return $pedido;
    }

    public function obtenerProductos(){
        //Este modulo retorna todos los productos de un pedido por su id
        //Cargo la bd
        $bd = Database::conectar();

        //Realizo la consulta
        $sql = "SELECT pr.imagen, pr.nombre, pr.precio, lp.unidades FROM productos pr ".
            "INNER JOIN lineas_pedido lp on pr.id = lp.producto_id ".
            "WHERE lp.pedido_id = {$this->id}";
        $productos = $bd->query($sql);

        //Cierro conexion y libero recursos
        $bd->close();

     return $productos;
    }

    public function obtenerTodos(){
        //Este metodo retorna todos los pedidos
        //Conecto a la db
        $db = Database::conectar();

        $sql = "SELECT p.id, p.coste, p.fecha,p.estado FROM pedidos p";
        $pedidos = $db->query($sql);

        return $pedidos;
    }

    public function modificarEstado(){
        //Este modulo modifica el estado de un pedido

        //Cargo la bd
        $db = Database::conectar();

        //Realizo consulta
        $sql = "UPDATE pedidos SET estado='{$this->estado}' WHERE id={$this->id}";
        $result = $db->query($sql);

        //Cierro bd y libero recursos
        $db->close();

        return $result;
    }
    }
