<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Estadísticas de Entradas</title>
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

        .sidebar {
            width: 250px;
            background-color: #4a90e2;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .sidebar a {
            font-size: 16px;
            color: white;
            text-decoration: none;
            margin: 10px 0;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #357ABD;
        }

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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4a90e2;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .chart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .chart {
            width: 200px; /* Ajusté el tamaño para mejor visualización */
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .chart h3 {
            text-align: center;
            font-size: 18px;
            color: #333;
        }

        .button {
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #357ABD;
        }

        #contentToDownload {
            position: relative;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body>
    <?php
    include '../conexion.php';

    $sql = "SELECT idEvento, nombreEvento, capacidadEvento, entradasGeneralEvento, entradasVipEvento FROM evento";
    $result = $conn->query($sql);
    ?>

    <div class="sidebar">
        <h2>Local</h2> <!-- Título de la barra lateral -->
        <a href="./home.php">Principal</a>
        <a href="./crear_evento.php">Crear Evento</a>
        <a href="./lista_eventos.php">Lista de Eventos</a>
    </div>

    <div class="main-content" id="contentToDownload">
        <h1>Estadísticas de Entradas por Evento</h1>

        <table>
            <tr>
                <th>Nombre del Evento</th>
                <th>Capacidad Total</th>
                <th>Entradas Generales Vendidas</th>
                <th>Entradas VIP Vendidas</th>
                <th>Total Vendido</th>
                <th>Entradas Restantes</th>
            </tr>
            <?php
            $eventos_data = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $total_vendido = $row['entradasGeneralEvento'] + $row['entradasVipEvento'];
                    $entradas_restantes = $row['capacidadEvento'] - $total_vendido;
                    $eventos_data[] = [
                        'nombre' => $row['nombreEvento'],
                        'vendidas' => $total_vendido,
                        'restantes' => $entradas_restantes
                    ];

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombreEvento']) . "</td>";
                    echo "<td>" . $row['capacidadEvento'] . "</td>";
                    echo "<td>" . $row['entradasGeneralEvento'] . "</td>";
                    echo "<td>" . $row['entradasVipEvento'] . "</td>";
                    echo "<td>" . $total_vendido . "</td>";
                    echo "<td>" . $entradas_restantes . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay eventos disponibles</td></tr>";
            }
            ?>
        </table>

        <div class="chart-container">
            <?php foreach ($eventos_data as $index => $evento): ?>
                <div class="chart">
                    <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>
                    <canvas id="chart-<?php echo $index; ?>" width="200" height="200"></canvas>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="button" onclick="downloadPDF()">Descargar PDF</button>
    </div>

    <?php $conn->close(); ?>

    <script>
        <?php foreach ($eventos_data as $index => $evento): ?>
            const ctx<?php echo $index; ?> = document.getElementById('chart-<?php echo $index; ?>').getContext('2d');
            new Chart(ctx<?php echo $index; ?>, {
                type: 'doughnut',
                data: {
                    labels: ['Vendidas', 'Restantes'],
                    datasets: [{
                        data: [<?php echo $evento['vendidas']; ?>, <?php echo $evento['restantes']; ?>],
                        backgroundColor: ['#4CAF50', '#FF6B6B'],
                        borderColor: ['#4CAF50', '#FF6B6B'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, position: 'bottom' },
                        title: { display: true, text: 'Entradas Vendidas vs Restantes' }
                    },
                    cutout: '70%'
                }
            });
        <?php endforeach; ?>

        function downloadPDF() {
            const button = document.querySelector('.button');
            button.style.display = 'none';

            const element = document.getElementById('contentToDownload');
            const options = {
                margin: 10,
                filename: 'Estadisticas_Eventos.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 1.5, useCORS: true, logging: false, letterRendering: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(options).from(element).save().then(function() {
                button.style.display = 'block';
            });
        }
    </script>
</body>
</html>
