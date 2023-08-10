<?php require_once 'models/Categoria.php'?>
<!DOCTYPE HTML>

<html lang="es">
<head>
    <title>Tienda</title>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="<?=base_url?>assets/css/style.css">
</head>

<body>
<div id="container">
    <!--CABECERA-->
    <header id="header">
        <div id="logo">
            <img src="<?=base_url?>assets/img/camiseta.png" alt="Remera logo" title="Remera">
            <h1><a href="<?=base_url?>">TIENDA DE REMERAS</a></h1>
        </div>
    </header>

    <!--MENU-->
    <nav id="menu">
        <ul>

            <li><a href="<?=base_url?>producto/index">Inicio</a></li>

            <!--OBTENGO LAS CATEGORIAS-->
            <?php
            $categorias = new Categoria("");
            $categorias = $categorias->getCategorias("");
            ?>

            <?php while($unaCategoria = $categorias->fetch_object()): ?>

            <!--ACA AGREGO EL GET DEL ID CON & PORQUE CON EL HTACCCES EL CONTROLADOR Y ACTION SE PASAN POR GET TAMBIEN-->

            <li><a href="<?=base_url?>categoria/productos&id=<?=$unaCategoria->id?>"><?=$unaCategoria->nombre?></a></li>
            <?php endwhile;?>
            <li><a href="index.php">Sobre mi</a></li>
        </ul>
    </nav>

    <div id="content">