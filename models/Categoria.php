<?php
require_once 'config/Database.php';
class Categoria{

    //Atributos
    private int $id;
    private String $nombre;


    //Constructor
    public function __construct($nombre=''){
        $this->nombre = $nombre;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getCategorias($id=""){
        //Este modulo retorna la categoria con el id recibido
        //Si no recibe un id, entonces retorna todas las categorias

        //Conecto a la bd
        $db = Database::conectar();

        if($id == ""){
            $sql = "SELECT * FROM categorias";
        }else{
            $sql = "SELECT * FROM categorias WHERE id=$id";
        }
        return $db->query($sql);
    }

    public function guardar(){
        //Conecto a la bd
        $db = Database::conectar();

        //Creo sentencia preparada (prepared statements) para mejorar seguridad
        $sql = "INSERT INTO categorias(nombre) VALUES (?)";
        $stmt = $db->prepare($sql);

        // Enlazo los valores de los parámetros a la sentencia preparada
        $stmt->bind_param('s', $this->nombre);

        //Ejecuto la consulta
        $result = $stmt->execute();

        return $result;
    }


}
