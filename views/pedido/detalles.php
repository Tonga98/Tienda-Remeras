<h2>Detalles del pedido</h2>
<?php if (($unPedidoDetalles) && ($productos)): ?>
    <h3>Direccion de envio:</h3>
    <pre>
        Provincia: <?= $unPedidoDetalles->provincia ?>.
        Ciudad: <?= $unPedidoDetalles->localidad ?>.
        Direccion: <?= $unPedidoDetalles->direccion ?>.
    </pre>
    <h3>Datos del pedido:</h3>
    <pre>
        Numero del pedido: #<?= $unPedidoDetalles->id ?>.
        Total a pagar: <?= $unPedidoDetalles->coste ?>$
        Estado: <?= $unPedidoDetalles->estado ?>.
    </pre>

<?php if(isset($_SESSION['admin'])):?>
    <form method="post" action="<?=base_url?>pedido/estado">
        <input type="hidden" value="<?=$unPedidoDetalles->id?>" name="pedido_id">
        <label for="estado"><h3>Cambiar estado del producto:</h3></label>
        <select name="estado" id="estado">
            <option value="Pendiente" <?=$unPedidoDetalles->estado == 'Pendiente' ? 'selected' : ''?> >Pendiente</option>
            <option value="En preparacion" <?=$unPedidoDetalles->estado == 'En preparacion' ? 'selected' : ''?>>En preparacion</option>
            <option value="Preparado para enviar" <?=$unPedidoDetalles->estado == 'Preparado para enviar' ? 'selected' : ''?>>Preparado para enviar</option>
            <option value="Enviado"  <?=$unPedidoDetalles->estado == 'Enviado' ? 'selected' : ''?>>Enviado</option>
        </select>

        <input type="submit" value="Actualizar estado">
    </form>
<?php endif;?>

    <h3>Productos:</h3>
    <table>

        <tr>
            <th>IMAGEN</th>
            <th>NOMBRE</th>
            <th>PRECIO</th>
            <th>UNIDADES</th>
        </tr>

        <?php while ($elemento = $productos->fetch_object()): ?>
            <tr>
                <td><img src="<?= base_url ?>uploads/images/<?= $elemento->imagen ?>" alt="ImagenRemera"></td>
                <td><?= $elemento->nombre ?></td>
                <td><?= $elemento->precio ?></td>
                <td><?= $elemento->unidades ?></td>
            </tr>
        <?php endwhile; ?>

    </table>
<?php else: ?>
    <h3>Error</h3>
<?php endif; ?>
