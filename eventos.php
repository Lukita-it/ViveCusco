<?php
// eventos.php

include 'conexion.php'; // Incluye tu archivo de conexión

// Consulta para obtener eventos
$sql = "SELECT idEvento,nombreEvento, descripcionEvento, fechahoraevento,capacidadEvento,entradasDisponiblesEvento, imagenEvento FROM evento";
$result = $conn->query($sql);

// Crear un array para almacenar los eventos
$eventos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }
} else {
    // Si no hay eventos, puedes manejarlo aquí
    echo "No hay eventos disponibles.";
}

$conn->close();
?>
