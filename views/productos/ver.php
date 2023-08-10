<script src="<?=base_url?>helpers/script.js"></script>
<?php
if (is_object($producto)): ?>

    <div class="product-details">
        <h2><?= $producto->nombre ?></h2>
        <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" alt="Remera">
        <div class="data">
            <h4>Precio: <?= $producto->precio ?></h4>
            <h4>Descripcion:</h4>
            <p><?= $producto->descripcion ?></p>

            <label for="cantidad">Cantidad:</label>
            <select name="cantidad" id="cantidad">
                <?php for ($i=1 ; $i <= $producto->stock ; $i++ ): ?>
                <option value="<?=$i?>"><?=$i?></option>
                <?php endfor;?>
            </select>
            <span>(<?=$producto->stock?> en stock)</span>

            <a href="<?=base_url?>Carrito/comprar&id= <?=$producto->id?>"><input type="button" value="COMPRAR"></a>

            <input type="button" value="AGREGAR AL CARRITO" onclick="agregarAlCarrito(<?=$producto->id?>)">
        </div>
    </div>
<?php else: ?>

    <h2>Producto no encontrado</h2>

<?php endif; ?>

