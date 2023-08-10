<h2>Gestionar categorias</h2>

<table>

    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
    </tr>

    <?php while($categoria = $categorias->fetch_object()):?>
        <tr>
            <td><?=$categoria->id?></td>
            <td><?=$categoria->nombre?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="<?=base_url?>categoria/crear"><input type="button" value="Crear categoria"></a>
