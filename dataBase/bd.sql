 /*Creo base de datos */
 CREATE DATABASE tienda;

 /*Creo tabla Usuario*/
 CREATE TABLE Usuarios(
    id          int(255) auto_increment not null,
    nombre      varchar(255) not null,
    apellido    varchar(255) not null,
    email       varchar(255) not null,
    password    varchar(255) not null,
    rol         varchar(255) not null,
    imagen      varchar(255),
    CONSTRAINT pk_usuarios PRIMARY KEY (id),
    CONSTRAINT uq_email UNIQUE (email)
 )ENGINE = InnoDB;

 /*Creo tabla Pedidos*/
 CREATE TABLE Pedidos(
                          id             int(255) auto_increment not null,
                          usuario_id     int(255) not null,
                          direccion      varchar(255) not null,
                          localidad      varchar(255) not null,
                          coste          float(255,2) not null,
                          fecha          date not null,
                          hora           time not null ,
                          estado         varchar(255) not null ,
                          provincia      varchar(255) not null,
                          CONSTRAINT pk_pedidos PRIMARY KEY (id),
                          CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
 )ENGINE = InnoDB;

 /*Creo tabla Categorias*/
 CREATE TABLE Categorias(
                         id             int(255) auto_increment not null,
                         nombre         varchar(255) not null,
                         CONSTRAINT pk_categorias PRIMARY KEY (id)
 )ENGINE = InnoDB;

 /*Creo tabla Productos*/
 CREATE TABLE Productos(
                         id              int(255) auto_increment not null,
                         nombre          varchar(255) not null,
                         descripcion     MEDIUMTEXT     ,
                         precio          float(255,2) not null,
                         imagen          varchar(255),
                         stock           int(255) not null,
                         oferta          varchar(2),
                         fecha           date not null,
                         categoria_id    int(255) not null ,
                         CONSTRAINT pk_productos PRIMARY KEY (id),
                         CONSTRAINT fk_categorias FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
 )ENGINE = InnoDB;

 /*Creo tabla LineasPedido*/
 CREATE TABLE LineasPedido(
                           id               int(255) auto_increment not null,
                           pedido_id        int(255) not null,
                           producto_id      int(255) not null,
                           unidades         int(255) not null,
                           CONSTRAINT pk_lineasPedido PRIMARY KEY (id),
                           CONSTRAINT fk_pedido FOREIGN KEY (pedido_id) REFERENCES Pedidos(id),
                           CONSTRAINT fk_producto FOREIGN KEY (producto_id) REFERENCES Productos(id)
 )ENGINE = InnoDB;