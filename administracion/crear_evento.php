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
            background-color: #e3f2fd; /* Fondo en celeste pastel */
        }
        
        /* Barra lateral */
        .sidebar {
            width: 250px;
            background-color: #1976D2; /* Fondo azul similar a la imagen */
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #90caf9;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #0d47a1;
            display: flex;
            align-items: center;
        }

        .sidebar h2::before {
            content: "🎵";
            margin-right: 10px;
        }

        .sidebar a {
            font-size: 16px;
            color: #ffffff; /* Cambiado a blanco para mejor contraste */
            text-decoration: none;
            margin: 10px 0;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #1565c0; /* Azul más oscuro al pasar el ratón */
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .main-content h1 {
            font-size: 28px;
            color: #1565c0;
            margin-bottom: 15px;
        }

        .form-container {
            margin-top: 20px;
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            display: block;
            margin-top: 10px;
            color: #1565c0;
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #90caf9;
            border-radius: 4px;
            background-color: #ffffff;
            color: #333;
        }

        .form-container button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #64b5f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #42a5f5;
        }

        /* Estilo para tabla de lista de eventos */
        .event-list table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background-color: #e1f5fe;
        }

        .event-list table th, .event-list table td {
            padding: 8px;
            border-bottom: 1px solid #90caf9;
            color: #333;
        }
    </style>
</head>
<body>
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
</body>
</html>
