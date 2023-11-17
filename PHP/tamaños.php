<?php
    include 'conexion.php';
    // Obtener tamaños según el producto (ajusta el nombre del producto)
$producto = $_GET['producto'];

$query = "SELECT tamano FROM tamanos_productos WHERE producto = '$producto'";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    $tamanos = array();

    while ($fila = $resultado->fetch_assoc()) {
        $tamanos[] = $fila['tamano'];
    }

    echo json_encode($tamanos);
} else {
    echo json_encode(array()); // Si no hay tamaños disponibles
}

$conexion->close();

?>