<?php if(!isset($_SESSION['carrito'])):?>
<h2>Carrito vacio!</h2>
<?php else: ?>
<h2>Carrito</h2>
<table>

    <tr>
        <th>IMAGEN</th>
        <th>NOMBRE</th>
        <th>PRECIO</th>
        <th>UNIDADES</th>
        <th>ELIMINAR</th>
    </tr>

    <?php foreach ($_SESSION['carrito'] as $indice => $elemento):?>
        <tr>
            <td><a href="<?=base_url?>producto/ver&id=<?=$elemento['producto_id']?>"><img src="<?=base_url?>uploads/images/<?=$elemento['imagen']?>" alt="ImagenRemera"></a></td>
            <td><?=$elemento['nombre']?></td>
            <td><?=$elemento['precio']?></td>
            <td>
                <?=$elemento['unidades']?>
                <div class="carrito-unidades">
                    <a href="<?=base_url?>carrito/restarProducto&indice=<?=$indice?>"><input type="button" value="-"></a>
                    <a href="<?=base_url?>carrito/sumarProducto&indice=<?=$indice?>" ><input type="button" value="+"></a>
                </div>
            </td>
            <td><a href="<?=base_url?>carrito/deleteOne&id=<?=$elemento['producto_id']?>">Eliminar</a></td>
        </tr>
    <?php endforeach; ?>

</table>
<h3>Total: <?=Utils::carritoStats()?>$</h3>

<a href="<?=base_url?>pedido/hacer"><input type="button" value="Hacer pedido"></a>
<?php endif; ?>