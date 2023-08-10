
<!--ASIDE-->
<aside id="lateral">
    <div id="login" class="block-aside">
        <?php if(!isset($_SESSION['identity'])):?> <!--Si no esta iniciada sesion de usuario-->
        <form method="post" action="<?=base_url?>Usuario/login">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" pattern="[a-zA-Z0-9]+">
            <input type="submit" value="Entrar">
        </form>
        <?php else:?>
            <h2><?= $_SESSION['identity']->nombre.' '.$_SESSION['identity']->apellido ?></h2>
            <a href="<?=base_url?>Usuario/logout"><input type="button" value="Cerrar sesion"></a>
        <ul>
            <li><a href="<?=base_url?>pedido/misPedidos">Mis pedidos</a></li>
            <li><a href="">Mis datos</a></li>
        </ul>

        <?php endif; ?>

        <!--SI EL USUARIO REGISTRADO ES ADMIN-->
        <?php if(isset($_SESSION['admin'])):?>
        <ul>
            <li><a href="<?=base_url?>producto/gestion">Gestionar productos</a></li>
            <li><a href="<?=base_url?>pedido/gestion">Gestionar pedidos</a></li>
            <li><a href="<?=base_url?>categoria/index">Gestionar categorias</a></li>
        </ul>
        <?php endif;?>
            <a href="<?=base_url?>Carrito/index"><img id="carrito" src="<?=base_url?>assets/img/carrito.png" alt="Carrito"></a>
        <?php if(!isset($_SESSION['identity'])):?>
        <a href="<?=base_url?>Usuario/registro">Registrarse</a>
        <?php endif; ?>


    </div>

    <!--ERRORES AL MOMENTO DE REGISTRARSE-->
    <?php if(isset($_SESSION['register']) && $_SESSION['register']=='failed'):?>
    <?= '<strong class="register failed">Error al crear usuario!</strong>' ?>
    <?php elseif(isset($_SESSION['register']) && ($_SESSION['register']=='complete')):?>
        <?= '<strong class="register complete">Usuario creado con exito!</strong>' ?>
    <?php endif;?>

    <!--ERROR AL INICIAR SESION-->
    <?php if(isset($_SESSION['error_login'])):?>
    <?= '<strong class="register failed">'.$_SESSION['error_login'].'</strong>' ?>
    <?php endif; ?>

    <!--Mensaje general-->
    <?php if(isset($_SESSION['mensajeGeneral']) && substr($_SESSION['mensajeGeneral'], 0, 5) == "Error"):?>
        <?= '<strong class="register failed">'.$_SESSION['mensajeGeneral'].'</strong>' ?>
    <?php elseif(isset($_SESSION['mensajeGeneral'])):?>
        <?= '<strong class="register complete">'.$_SESSION['mensajeGeneral'].'</strong>' ?>
    <?php endif;?>

    <?php Utils::deleteSessions();?>

</aside>

<!--PRINCIPAL-->
<div id="principal"> <!--Principal = Central-->
