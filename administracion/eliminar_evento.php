<?php
// Incluir el archivo de conexión
include '../conexion.php';

// Verificar si se envió el idEvento a través del método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idEvento'])) {
    $idEvento = $_POST['idEvento'];

    // Consulta SQL para eliminar el evento
    $sqlDelete = "DELETE FROM evento WHERE idEvento = $idEvento";

    if ($conn->query($sqlDelete) === TRUE) {
        // Redirigir a la lista de eventos después de eliminar
        header("Location: lista_eventos.php?mensaje=Evento eliminado correctamente");
        exit;
    } else {
        echo "Error al eliminar el evento: " . $conn->error;
    }
} else {
    echo "ID del evento no especificado.";
}

// Cerrar la conexión
$conn->close();
?>
