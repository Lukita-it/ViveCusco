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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #eef2f3;
        }

        /* Barra lateral */
        .sidebar {
            width: 250px;
            background-color: #1466c3;
            padding: 45px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: black;
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
            color: white;
            text-decoration: none;
            margin: 10px 0;
            transition: background 0.3s;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #357ABD;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .main-content h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .main-content p {
            font-size: 16px;
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
            background-color: #b2dafa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .box h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #4a90e2;
        }

        .event-list table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .event-list table th, .event-list table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .event-list table th {
            background-color: #f1f1f1;
        }

        .button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .button:hover {
            background-color: #357ABD;
        }

        /* Estilo para gráfico de pastel (simulado con SVG) */
        .pie-chart {
            width: 120px; /* Ajusta el ancho según tus necesidades */
            height: auto;  /* Mantiene la proporción */
            display: block;
            margin: 20px auto;
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
        <h2>ViveCusco</h2>
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
                            echo "<tr><td>" . htmlspecialchars($row['nombreEvento']) . "</td></tr>";
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
            
            <!-- Cuadro de estadísticas de ventas -->
            <div class="box sales-chart">
                <h3>Ventas de Entradas</h3>
                <img src="../img/grafico.png" alt="Gráfico Circular de Ventas" class="pie-chart">
                <a href="estadisticas.php">
                <button class="button">Ver Estadísticas</button></a>
            </div>
        </div>
    </div>

    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>
