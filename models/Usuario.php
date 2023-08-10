<?php
require_once 'config/Database.php';
class Usuario{

    //Atributos
    private int    $id;
    private String $nombre;
    private String $apellido;
    private String $email;
    private String $password;
    private String $rol;
    private String $foto;

    //Constructor

    public function __construct(string $nombre="", string $apellido="", string $email="", string $password="", string $rol="")
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
    }


    //Getters y Setters/**

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

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public function getFoto(): string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }

    public function guardar(){
        //Conecto a la bd
        $db = Database::conectar();

        //Creo sentencia preparada (prepared statements) para mejorar seguridad
        $sql = "INSERT INTO usuarios(nombre, apellido, email, password, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        //Hash a password
        $password_segura = password_hash($this->password,PASSWORD_BCRYPT, ['cost'=>4]);

        // Enlazo los valores de los parámetros a la sentencia preparada
        $stmt->bind_param('sssss', $this->nombre, $this->apellido, $this->email, $password_segura, $this->rol);

        //Ejecuto la consulta
        $result = $stmt->execute();

        return $result;
    }

    public function login($email, $password){

        //Conecto a la base de datos
        $db = Database::conectar();
        $result = false;

        //Realizo la consulta
        $sql = "SELECT * FROM usuarios WHERE email='$email'";
        $query = $db->query($sql);

        //Si la consulta me devuelve una sola fila
        if($query && $query->num_rows == 1){
            $usuario = $query->fetch_object();

            //Verifico password
            if(password_verify($password,$usuario->password)){
                $result = $usuario;
            }
        }
        return $result;
    }
}