<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        /* Reset y estilos generales */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Estilos del cuerpo */
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        
        /* Barra lateral */
        .sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .sidebar h2::before {
            content: "🎵";
            margin-right: 10px;
        }

        .sidebar a {
            font-size: 16px;
            color: #333;
            text-decoration: none;
            margin: 10px 0;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        /* Contenedor del contenido principal */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .event-list table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fafafa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Estilos de la tabla */
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e8e8e8;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Botones */
        .button {
            padding: 8px 16px;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <?php
    // Incluir el archivo de conexión
    include '../conexion.php';

    // Actualizar evento en la base de datos
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
        $idEvento = $_POST['idEvento'];
        $nombreEvento = $_POST['nombreEvento'];
        $descripcionEvento = $_POST['descripcionEvento'];
        $fechahoraEvento = $_POST['fechahoraEvento'];
        $categoriaEvento = $_POST['categoriaEvento'];
        $capacidadEvento = $_POST['capacidadEvento'];

        // Actualizar el evento
        $sqlUpdate = "UPDATE evento SET 
                        nombreEvento='$nombreEvento', 
                        descripcionEvento='$descripcionEvento', 
                        fechahoraEvento='$fechahoraEvento', 
                        categoriaEvento='$categoriaEvento', 
                        capacidadEvento=$capacidadEvento 
                      WHERE idEvento=$idEvento";

        if ($conn->query($sqlUpdate) === TRUE) {
            echo "Evento actualizado exitosamente.";
        } else {
            echo "Error al actualizar el evento: " . $conn->error;
        }
    }

    // Consulta para obtener la lista de eventos
    $sql = "SELECT * FROM evento";
    $result = $conn->query($sql);
    ?>

    <!-- Barra lateral -->
    <div class="sidebar">
        <h2>Local</h2>
        <a href="./home.php">Principal</a>
        <a href="./crear_evento.php">Crear Evento</a>
        <a href="./lista_eventos.php">Lista de Eventos</a>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1>Lista de Eventos</h1>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha y Hora</th>
                <th>Categoría</th>
                <th>Capacidad</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<form method='POST'>";
                    echo "<tr>";
                    echo "<input type='hidden' name='idEvento' value='".$row['idEvento']."'>";
                    echo "<td><input type='text' name='nombreEvento' value='".htmlspecialchars($row['nombreEvento'])."'></td>";
                    echo "<td><input type='text' name='descripcionEvento' value='".htmlspecialchars($row['descripcionEvento'])."'></td>";
                    echo "<td><input type='datetime-local' name='fechahoraEvento' value='".$row['fechahoraEvento']."'></td>";
                    echo "<td><input type='text' name='categoriaEvento' value='".htmlspecialchars($row['categoriaEvento'])."'></td>";
                    echo "<td><input type='number' name='capacidadEvento' value='".$row['capacidadEvento']."'></td>";
                    echo "<td><img src='../".$row['imagenEvento']."' alt='Imagen del Evento' width='50'></td>";
                    echo "<td>
                            <button type='submit' name='editar' class='button edit-btn'>Editar</button>
                            <button type='submit' name='eliminar' class='button delete-btn' formaction='./eliminar_evento.php'>Eliminar</button>
                          </td>";
                    echo "</tr>";
                    echo "</form>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay eventos disponibles</td></tr>";
            }
            ?>
        </table>
    </div>

    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>
