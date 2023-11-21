<?php
   // cargar_contenido_modal.php
   include "conexion.php";

   $id = $_GET['id'];
   $query = "SELECT precios_por_tamano.id, 
                    productos.nombre AS producto_nombre, 
                    tamanos.nombre AS tamaño_nombre,
                    precios_por_tamano.precio_compra, 
                    precios_por_tamano.precio_venta, 
                    precios_por_tamano.stock
              FROM precios_por_tamano
              JOIN productos ON precios_por_tamano.producto_id = productos.id
              JOIN tamanos ON precios_por_tamano.tamano_id = tamanos.id
              WHERE precios_por_tamano.id = :id";
   $statement = $conectar->prepare($query);
   $statement->bindParam(':id', $id, PDO::PARAM_INT);
   $statement->execute();

   $record = $statement->fetch(PDO::FETCH_ASSOC);

   if ($record) {
?>
    <form action="../PHP/editar.php" method="POST">
    <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Producto</th>
                <th scope="col">Tamaño</th>
                <th scope="col">Precio Compra</th>
                <th scope="col">Precio Venta</th>
                <th scope="col">Stock</th>
                </tr>
            </thead>
            <tbody class="table-primary">
            <td>
            <div class="mb-3">
            <label for="id" class="form-label"></label>
            <input type="text" class="form-control" name="id" value="<?php echo $record['id']; ?>" readonly>
            </td>
            <td>
                <div class="mb-3">
                <label for="producto" class="form-label"></label>
                <input type="text" class="form-control" id="producto" name="producto" value="<?php echo $record['producto_nombre']; ?>" readonly>
                </div>
            </td>
         <td>
         <div class="mb-3">
            <label for="tamaño" class="form-label"></label>
            <input type="text" class="form-control" id="tamaño" name="tamaño" value="<?php echo $record['tamaño_nombre']; ?>" readonly>
         </div>
         </td>
         <td>
         <div class="mb-3">
            <label for="precio_compra" class="form-label"></label>
            <input type="text" class="form-control" id="precio_compra" name="precio_compra" value="<?php echo $record['precio_compra']; ?>">
         </div>
         </td>
         <td>
         <div class="mb-3">
            <label for="precio_venta" class="form-label"></label>
            <input type="text" class="form-control" id="precio_venta" name="precio_venta" value="<?php echo $record['precio_venta']; ?>">
         </div>
         </td>
         <td>
         <div class="mb-3">
            <label for="stock" class="form-label"></label>
            <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $record['stock']; ?>">
         </div>
         </td>
         </table>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
         </div>
      </form>
<?php
   }
?>

