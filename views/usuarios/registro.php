<h2>Registro de usuarios</h2>
<form action="<?=base_url?>Usuario/guardar" method="post">

    <label for="nombre">Nombre: </label>
    <input type="text" name="nombre" id="nombre" pattern="[a-zA-Z]+" required>

    <label for="apellido">Apellido: </label>
    <input type="text" name="apellido" id="apellido" pattern="[a-zA-Z]+" required>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email" required>

    <label for="password">Contraseña:</label>
    <input type=password name="password" id="password" required>

    <input type="submit" value="Registrarse">
</form>

