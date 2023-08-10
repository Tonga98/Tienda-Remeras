function agregarAlCarrito(idProducto) {
    var select = document.getElementById("cantidad"); //Obtengo el select
    var cantidad = select.value;  //Obtengo el valor del select
    window.location.href = "http://localhost/master-php/proyecto-php-poo/Carrito/add&id=" + idProducto + "&cantidad=" + cantidad;
}

