<?php
// Incluye el archivo de conexión
include '../conexion.php';

// Obtiene el id del evento desde la URL
$idEvento = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta para obtener los detalles del evento
$sql = "SELECT nombreEvento, descripcionEvento, fechahoraevento, imagenEvento, capacidadEvento FROM evento WHERE IdEvento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idEvento);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $evento = $result->fetch_assoc();
} else {
    echo "<p>Evento no encontrado.</p>";
    exit;
}

$stmt->close();

// Consulta para obtener los tipos de entrada y su costo del evento
// Consulta para obtener los tipos de entrada y su costo del evento
$sqlEntradas = "SELECT tipoEntrada, costoEntrada FROM entrada WHERE IdEvento = ?";
$stmtEntradas = $conn->prepare($sqlEntradas);
$stmtEntradas->bind_param("i", $idEvento);
$stmtEntradas->execute();
$resultEntradas = $stmtEntradas->get_result();

$entradas = [];
while ($entrada = $resultEntradas->fetch_assoc()) {
    $entradas[] = $entrada; // Almacena las entradas en un array
}

// Cierra la conexión a la base de datos
$stmtEntradas->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <style>
        html, body {
            height: 100%; 
            margin: 0; 
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: rgb(255, 255, 255);
            padding: 10px 40px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            color: #333;
        }

        nav {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
        }

        nav ul li a:hover {
            background-color: #1e90ff;
            color: #fff;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .buttons a {
            padding: 8px 20px;
            border: 1px solid #333;
            background-color: transparent;
            color: #333;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .buttons a:hover {
            background-color: #1e90ff;
            color: #ffffff;
        }

        .container {
            flex: 1;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        h1 {
            margin-bottom: 40px;
            font-size: 36px;
            color: #333;
        }

        h2 {
            text-align: left;
            font-size: 28px;
            color: #000000;
        }

        .event-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            gap: 20px;
        }

        .event-details img {
            width: 350px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .event-info {
            flex-grow: 1;
            text-align: left;
            font-size: 18px;
        }

        .event-info p {
            margin-bottom: 15px;
        }

        .buy-btn {
            display: inline-block;
            background-color: #f40707;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .buy-btn:hover {
            background-color: #ff4500;
        }

        .entry-section {
            margin-top: 30px;
            text-align: center;
        }

        .entry-label {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .entry-selection {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        select, input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        select:focus, input[type="number"]:focus {
            outline: none;
            border-color: #ff6347;
        }

        footer {
            background-color: #333;
            padding: 20px;
            color: #fff;
            border-top: 3px solid #ef2a07;
            text-align: center;
        }

        footer a {
            text-decoration: none;
            color: #ff6347;
            font-size: 14px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .social {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .social img {
            width: 40px;
            height: 40px;
            filter: grayscale(100%);
            transition: filter 0.3s ease;
        }

        .social img:hover {
            filter: grayscale(0%);
        }
    </style>
</head>
<body>

<div class="wrapper">
    <header>
        <div class="logo">
            🎵 Local
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Principal</a></li>
                <li><a href="../info.html">Info</a></li>
                <li><a href="../contacto.html">Contacto</a></li>
            </ul>
        </nav>
        <div class="buttons">
            <a href="../login/login.html" class="buy-btn">Ingresar</a>
            <a href="../login/registro_usuario.html" class="buy-btn">Registrar</a>
        </div>
    </header>

    <div class="container">
        <h1>Detalles del Evento</h1>

        <h2><?php echo htmlspecialchars($evento['nombreEvento']); ?></h2>

        <div class="event-details">
    <img src="<?php echo htmlspecialchars($evento['imagenEvento']); ?>" alt="Evento <?php echo htmlspecialchars($evento['nombreEvento']); ?>">
    <div class="event-info">
        <p><strong>Fecha:</strong> <?php echo date('d M Y', strtotime($evento['fechahoraevento'])); ?></p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['descripcionEvento']); ?></p>
        <p><strong>Capacidad:</strong> <?php echo htmlspecialchars($evento['capacidadEvento']); ?> entradas</p>

        <!-- Mostrar tipos de entrada y sus costos -->
        <p><strong>Tipos de Entrada:</strong></p>
        <ul>
            <?php foreach ($entradas as $entrada): ?>
                <li><?php echo htmlspecialchars($entrada['tipoEntrada']) . ": S/" . number_format($entrada['costoEntrada'], 2); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>



        <div class="entry-section">

        <div class="entry-section">
    <form action="../pasarela.php" method="POST">
        <div class="entry-label">Entradas</div>

        <div class="entry-selection">
            <label for="tipoEntrada">Tipo de Entrada:</label>
            <select name="tipoEntrada" id="tipoEntrada" required>
                <?php foreach ($entradas as $entrada): ?>
                    <option value="<?php echo htmlspecialchars($entrada['tipoEntrada']); ?>">
                        <?php echo htmlspecialchars($entrada['tipoEntrada']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" min="1" max="<?php echo $evento['capacidadEvento']; ?>" required placeholder="Nro">
        </div>

        <!-- Campo oculto para pasar el ID del evento -->
        <input type="hidden" name="idEvento" value="<?php echo htmlspecialchars($idEvento); ?>">

        <!-- Botón de envío -->
        <button type="submit" class="buy-btn" style="margin-top: 20px;">Comprar</button>
    </form>
</div>
        </div>
    </div>


    <footer>
        <a href="../privacy.html">Política de Privacidad</a> | 
        <a href="../tyc.html">Términos y Condiciones</a>
        <div class="social">
            <a href="https://www.facebook.com/" target="_blank"><img src="../img/facebook.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/" target="_blank"><img src="../img/instagram.png" alt="Instagram"></a>
            <a href="https://x.com/" target="_blank"><img src="../img/x.png" alt="X"></a>
        </div>
    </footer>
</div>

</body>
</html>
