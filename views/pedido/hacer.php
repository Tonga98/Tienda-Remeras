<?php if (isset($_SESSION['identity'])): ?>
    <h2>Hacer pedido</h2>
    <form action="<?=base_url?>pedido/add" method="post">

        <label for="direccion">Direccion:</label>
        <input type="text" name="direccion" id="direccion" required>

        <label for="localidad">Localidad:</label>
        <input type="text" name="localidad" id="localidad" required>

        <label for="provincia">Provincia:</label>
        <input type="text" name="provincia" id="provincia" required>

        <input type="submit" value="Comprar pedido">
    </form>
    <a href="<?= base_url ?>carrito/index">Ver el carrito</a>
<?php else: ?>
    <h2>Error</h2>
    <p>Debe estar logeado para hacer un pedido</p>
<?php endif; ?>