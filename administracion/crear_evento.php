<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento</title>
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
        .form-container {
            margin-top: 20px;
        }
        .form-container label {
            display: block;
            margin-top: 10px;
        }
        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

    // Procesar el formulario cuando se envíe
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombreEvento = $_POST['nombreEvento'];
        $descripcionEvento = $_POST['descripcionEvento'];
        $fechahoraEvento = $_POST['fechahoraEvento'];
        $categoriaEvento = $_POST['categoriaEvento'];
        $capacidadEvento = $_POST['capacidadEvento'];
        $entradasGeneralEvento = $_POST['entradasGeneralEvento'];
        $entradasVipEvento = $_POST['entradasVipEvento'];


        // Manejo de la imagen
        $directorio = "../img/";  // Directorio donde se guardará la imagen
        $nombreImagen = basename($_FILES["imagenEvento"]["name"]);
        $rutaCompleta = $directorio . $nombreImagen;
        $rutaRelativa = "img/" . $nombreImagen;  // Ruta relativa para la base de datos
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($rutaCompleta, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen
        $check = getimagesize($_FILES["imagenEvento"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }

        // Verificar si ya existe el archivo
        if (file_exists($rutaCompleta)) {
            echo "Lo siento, la imagen ya existe.";
            $uploadOk = 0;
        }

        // Limitar formatos de imagen
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
            $uploadOk = 0;
        }

        // Intentar subir el archivo si todo está bien
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["imagenEvento"]["tmp_name"], $rutaCompleta)) {
                // Insertar el evento en la base de datos
                $sql = "INSERT INTO evento (nombreEvento, descripcionEvento, fechahoraEvento, categoriaEvento, capacidadEvento, imagenEvento, entradasGeneralEvento, entradasVipEvento) 
        VALUES ('$nombreEvento', '$descripcionEvento', '$fechahoraEvento', '$categoriaEvento', $capacidadEvento, '$rutaRelativa', $entradasGeneralEvento, $entradasVipEvento)";

                if ($conn->query($sql) === TRUE) {
                    echo "Nuevo evento creado con éxito";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Lo siento, hubo un error al subir tu imagen.";
            }
        }
    }
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
        <h1>Crear Nuevo Evento</h1>
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="nombreEvento">Nombre del Evento:</label>
                <input type="text" id="nombreEvento" name="nombreEvento" required>

                <label for="descripcionEvento">Descripción del Evento:</label>
                <textarea id="descripcionEvento" name="descripcionEvento" required></textarea>

                <label for="fechahoraEvento">Fecha y Hora del Evento:</label>
                <input type="datetime-local" id="fechahoraEvento" name="fechahoraEvento" required>

                <label for="categoriaEvento">Categoría del Evento:</label>
                <select id="categoriaEvento" name="categoriaEvento" required>
                    <option value="Concierto">Concierto</option>
                    <option value="Conferencia">Conferencia</option>
                    <option value="Taller">Taller</option>
                    <option value="Festival">Festival</option>
                </select>

                <label for="capacidadEvento">Capacidad del Evento:</label>
                <input type="number" id="capacidadEvento" name="capacidadEvento" required>

                <label for="entradasGeneralEvento">Entradas Generales:</label>
<input type="number" id="entradasGeneralEvento" name="entradasGeneralEvento" required>

<label for="entradasVipEvento">Entradas VIP:</label>
<input type="number" id="entradasVipEvento" name="entradasVipEvento" required>

                <label for="imagenEvento">Imagen del Evento:</label>
                <input type="file" id="imagenEvento" name="imagenEvento" accept="image/*" required>

                <button type="submit">Crear Evento</button>
            </form>
        </div>
    </div>

    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>