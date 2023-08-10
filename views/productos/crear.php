<?php if(isset($editar)):?>
    <h2> Editar producto</h2>
    <?php $action = base_url."producto/guardar&id=".$productoId?>
<?php else: ?>
    <h2> Crear producto</h2>
    <?php $action = base_url."producto/guardar"?>
<?php endif; ?>


<form action="<?=$action?>" method="post" enctype="multipart/form-data">

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre"  pattern="[a-zA-z ]+" value="<?=isset($producto) && is_object($producto) ? $producto->nombre : ''?>">

    <label for="descripcion">Descripcion:</label>
    <textarea type="text" name="descripcion" id="descripcion"><?=isset($producto) && is_object($producto) ? $producto->descripcion : ''?></textarea>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" pattern="[0-9]+(\.[0-9]{1,2})?"  step="0.01" value="<?=isset($producto) && is_object($producto) ? $producto->precio : ''?>">

    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock"  pattern="[0-9]+" value="<?=isset($producto) && is_object($producto) ? $producto->stock : ''?>">

    <label for="oferta">Oferta:</label>
    <input type="text" name="oferta" id="oferta" value="<?=isset($producto) && is_object($producto) ? $producto->oferta : ''?>">

    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria">
        <?php while($categoria = $categorias->fetch_object()): ?>
            <option value="<?=$categoria->id?>" <?=isset($producto) && is_object($producto) && $categoria->id == $producto->categoria_id ? 'selected' : ''?>><?= $categoria->nombre ?></option>
        <?php endwhile; ?>
    </select>

    <label for="imagen">Imagen:</label>
    <?php if(isset($producto) && is_object($producto) && !empty($producto->imagen)): ?>
    <img src="<?=base_url?>uploads/images/<?=$producto->imagen ?>" alt="Remera modelo" class="thumb"/>
    <?php endif; ?>
    <input type="file" name="imagen" id="imagen">

    <?php if(isset($editar)):?>
        <input type="submit" value="Editar producto">
    <?php else: ?>
        <input type="submit" value="Crear producto">
    <?php endif; ?>

</form>