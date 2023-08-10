<h2>Remeras destacadas</h2>

<?php while($producto = $productos->fetch_object()):?>
<article>
    <a href="<?=base_url?>producto/ver&id=<?=$producto->id?>"><img src="<?=base_url?>uploads/images/<?=$producto->imagen?>" alt="Remera"></a>
    <h4><?=$producto->nombre?></h4>
    <p>Precio: <?=$producto->precio?>$</p>
</article>
<?php endwhile; ?>





