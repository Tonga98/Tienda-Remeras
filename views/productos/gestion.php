<h2>Gestion de productos</h2>

<table>

    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Accion</th>
    </tr>
<?php while($producto = $productos->fetch_object()): ?>
    <tr>
        <td><?=$producto->id?></td>
        <td><?=$producto->nombre?></td>
        <td><?=$producto->precio?></td>
        <td><?=$producto->stock?></td>
        <td>
            <div class="producto-gestion">
            <a href="<?=base_url?>producto/editar&id=<?=$producto->id?>"><input type="button" value="Editar" class="button"></a>
            <a href="<?=base_url?>producto/eliminar&id=<?=$producto->id?>"><input type="button" value="Eliminar" class="button"></a>
            </div>
        </td>
    </tr>
<?php endwhile; ?>

</table>
<a href="<?=base_url?>producto/crear"><input type="button" value="Crear producto"></a>