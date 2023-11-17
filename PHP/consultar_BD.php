<?php
include "PHP/conexion.php";
$elementos = $conectar->query("SELECT precios_por_tamaño.id, 
                                productos.nombre AS producto_nombre, 
                                tamanos.nombre AS tamaño_nombre,
                                precios_por_tamaño.precio_compra, 
                                precios_por_tamaño.precio_venta, 
                                precios_por_tamaño.stock
                                FROM precios_por_tamaño
                                JOIN productos ON precios_por_tamaño.producto_id = productos.id
                                JOIN tamanos ON precios_por_tamaño.tamano_id = tamanos.id");
?>
