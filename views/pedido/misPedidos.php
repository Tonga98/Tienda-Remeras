<?php if (isset($gestion)): ?>
    <h2>Gestion de pedidos</h2>
<?php else: ?>
    <h2>Mis pedidos</h2>
<?php endif; ?>

<?php if ($pedidos != false): ?>

    <table>
        <tr>
            <th>N° Pedido</th>
            <th>Coste</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
        <?php while ($unPedido = $pedidos->fetch_object()): ?>
            <tr>
                <td><a href="<?= base_url ?>pedido/detalles&id=<?= $unPedido->id ?>"><?= $unPedido->id ?></a></td>
                <td><?= $unPedido->coste ?></td>
                <td><?= $unPedido->fecha ?></td>
                <td><?=$unPedido->estado?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>SIN PEDIDOS!</p>
<?php endif; ?>