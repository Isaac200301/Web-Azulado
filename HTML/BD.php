<?php
include "../PHP/conexion.php";
$elementos = $conectar->query("SELECT precios_por_tamano.id, 
                                productos.nombre AS producto_nombre, 
                                tamanos.nombre AS tamaño_nombre,
                                precios_por_tamano.precio_compra, 
                                precios_por_tamano.precio_venta, 
                                precios_por_tamano.stock
                                FROM precios_por_tamano
                                JOIN productos ON precios_por_tamano.producto_id = productos.id
                                JOIN tamanos ON precios_por_tamano.tamano_id = tamanos.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Elementos</title>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/BD.css">


</head>
<header>
<nav class="navbar-transparente navbar navbar-expand-lg bg-body-tertiary fixed-top ">
  <div class="container-fluid">
    <a class="navbar-brand"><img class="logo" src="../Imagenes/azulado.webp" alt="Logo azulado"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
      <form class="buscar d-flex" id="search-form">
        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" id="search-input">
        <button class="boton-buscar btn btn-outline-success" type="submit">Buscar Producto</button>
    </form>
    </div>
  </div>
</nav>
</header>
<body class="row justify-content-center align-items-center">
    <div class="col-auto">
    <div class="element tittle srow">
    <h1 class="text-black">Lista de Elementos</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar Elemento</button>
    </div>
        <div>
            <table class="table table-white table-striped-columns text-white">
                <thead class="table-header">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Tamaño</th>
                        <th scope="col">Precio Compra</th>
                        <th scope="col">Precio Venta</th>
                        <th scope="col">Stock</th>
                        <th scope="col" colspan=2>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php
                    $productos_anteriores = ''; // Variable para rastrear el nombre del producto anterior
                    $colores_bootstrap = ['table-primary', 'table-secondary', 'table-success', 'table-danger', 'table-warning', 'table-info', 'table-light', 'table-dark'];
                    $color_index = 0;

                    foreach ($elementos as $elemento) {
                        // Verificar si el nombre del producto ha cambiado
                        if ($elemento['producto_nombre'] != $productos_anteriores) {
                            // Cambiar el color de fondo para el nuevo producto
                            $color_actual = $colores_bootstrap[$color_index];
                            $color_index = ($color_index + 1) % count($colores_bootstrap);
                            $productos_anteriores = $elemento['producto_nombre'];
                        }
                    ?>
                        <tr class="<?php echo $color_actual; ?>">
                            <!-- Celdas de la tabla -->
                            <td><?php echo $elemento['id'] ?></td>
                            <td><?php echo $elemento['producto_nombre'] ?></td>
                            <td><?php echo $elemento['tamaño_nombre'] ?></td>
                            <td><?php echo "$" . number_format($elemento['precio_compra'], 0, ',', '.') ?></td>
                            <td><?php echo "$" . number_format($elemento['precio_venta'], 0, ',', '.') ?></td>
                            <td><?php echo $elemento['stock'] ?></td>
                            <td>
                            <a href="#" class="btn btn-outline-primary editar-btn" data-elemento-id="<?php echo $elemento['id']; ?>">Editar</a>
                            </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Resto del código HTML -->
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="PHP\guardar.php" method="POST">
      <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Producto</label>
          <input type="text" class="form-control" name="titulo">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Tamaño</label>
          <input type="text" class="form-control" name="autor">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Precio de compra</label>
          <input type="text" class="form-control" name="descripcion">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Precio de venta</label>
          <input type="text" class="form-control" name="descripcion">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Stock</label>
          <input type="text" class="form-control" name="descripcion">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Libro</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editarModalLabel">UPDATE</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!--- El resto esta en cargar_contenido_modal.php--->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../JS/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
   $(".editar-btn").on('click', function (e) {
      e.preventDefault();
      var elementoId = $(this).data('elemento-id');

      $.ajax({
         url: '../PHP/cargar_contenido_modal.php?id=' + elementoId,
         type: 'GET',
         success: function (data) {
            $("#editarModal .modal-body").html(data);
            $("#editarModal").modal('show');
         }
      });
   });
});

$(document).ready(function() {
  $(window).scroll(function() {
    if ($(this).scrollTop() > 50) { // Cambia 50 por la posición en la que deseas que ocurra el cambio
      $('.navbar').addClass('navbar-transparente');
    } else {
      $('.navbar').removeClass('navbar-transparente');
    }
  });
});

$(document).ready(function() {
    $('#search-form').submit(function(e) {
        e.preventDefault();

        // Obtén el valor de búsqueda
        var searchTerm = $('#search-input').val().toLowerCase();

        // Recorre cada fila de la tabla y muestra/oculta según la búsqueda
        $('.table-body tr').each(function() {
            var rowText = $(this).text().toLowerCase();

            if (rowText.indexOf(searchTerm) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});
</script>
</body>
</html>
