<?php if ($_SESSION['pedido'] == 'complete'): ?>
    <h2>Pedido confirmado</h2>
    <p>Tu pedido se ha guardado con exito, una vez que realices el pago sera procesado y enviado</p>
    <br>
    <h3>Datos del pedido:</h3>
    <pre>
        <strong>Numero de pedido: #<?=$unPedido->id?> </strong>
        <strong>Direccion: <?=$unPedido->direccion?></strong>
        <strong>Total a pagar: <?= $unPedido->coste ?>$</strong>
        <strong>Productos:</strong>
        </pre>
    <table>

        <tr>
            <th>IMAGEN</th>
            <th>NOMBRE</th>
            <th>PRECIO</th>
            <th>UNIDADES</th>
        </tr>

        <?php foreach ($_SESSION['carrito'] as $indice => $elemento): ?>
            <tr>
                <td><img src="<?= base_url ?>uploads/images/<?= $elemento['imagen'] ?>" alt="ImagenRemera"></td>
                <td><?= $elemento['nombre'] ?></td>
                <td><?= $elemento['precio'] ?></td>
                <td><?= $elemento['unidades'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php else: ?>
    <h2>Error al procesar el envio</h2>
<?php endif; ?>