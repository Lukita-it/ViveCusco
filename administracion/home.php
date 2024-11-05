<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
        }
        
        /* Barra lateral */
        .sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
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

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #fff;
        }

        .main-content h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .main-content p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            gap: 20px;
        }

        /* Cuadro de lista de eventos y estadísticas */
        .box {
            flex: 1;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }

        .box h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .event-list, .sales-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .event-list table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .event-list table th, .event-list table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #ddd;
            border: 1px solid #aaa;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #ccc;
        }

        /* Estilo para gráfico de pastel (simulado con SVG) */
        .pie-chart {
            width: 100px;
            height: 100px;
        }

        .pie-chart circle {
            fill: none;
            stroke-width: 32;
        }

        .pie-chart .event1 { stroke: #a9a9a9; }
        .pie-chart .event2 { stroke: #d3d3d3; }
        .pie-chart .event3 { stroke: #696969; }
    </style>
</head>
<body>
    <?php
    // Incluir el archivo de conexión
    include '../conexion.php';

    // Consulta para obtener la lista de eventos
    $sql = "SELECT nombreEvento FROM evento"; // Ajusta según tu tabla y columnas
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
        <h1>Panel de Administración</h1>
        <p>Gestión de la página del local.</p>
        
        <div class="container">
            <!-- Cuadro de lista de eventos -->
            <div class="box event-list">
                <h3>Lista de Eventos</h3>
                <table>
                    <tr>
                        <th>Nombre</th>
                    </tr>
                    <?php
                    // Verificar si hay resultados y mostrarlos
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . htmlspecialchars($row['nombreEvento']);
                        }
                    } else {
                        echo "<tr><td colspan='2'>No hay eventos disponibles</td></tr>";
                    }
                    ?>
                </table>
                <a href="lista_eventos.php">
    <button class="button">Ver Eventos</button>
</a>
            </div>
            
            <!-- Cuadro de estadísticas de ventas (puedes adaptar esto según los datos disponibles en tu base) -->
            <div class="box sales-chart">
                <h3>Ventas de Entradas</h3>
                <svg class="pie-chart" viewBox="0 0 32 32">
                    <circle class="event1" r="16" cx="16" cy="16" stroke-dasharray="25 75"></circle>
                    <circle class="event2" r="16" cx="16" cy="16" stroke-dasharray="15 85"></circle>
                    <circle class="event3" r="16" cx="16" cy="16" stroke-dasharray="10 90"></circle>
                </svg>
                <button class="button">Ver Estadísticas</button>
            </div>
        </div>
    </div>

    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>