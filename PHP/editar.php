<?php
// guardar_cambios.php
include "../PHP/conexion.php";

$id = $_POST['id'];
$precio_compra = $_POST['precio_compra'];
$precio_venta = $_POST['precio_venta'];
$stock = $_POST['stock'];

$query = "UPDATE precios_por_tamano SET precio_compra = $precio_compra, precio_venta = $precio_venta, stock = $stock WHERE id = $id";
$result = $conectar->query($query);

if ($result) {
   echo "Cambios guardados correctamente.";
} else {
   echo "Error al guardar los cambios: " . $conectar->error;
}
header("Location:../HTML/BD.php");
?>

