<?php
// Incluye el archivo de conexión
include '../conexion.php';

// Obtiene el id del evento desde la URL
$idEvento = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sqlOtrosEventos = "SELECT IdEvento, nombreEvento, imagenEvento FROM evento WHERE IdEvento != ? LIMIT 5";
$stmtOtrosEventos = $conn->prepare($sqlOtrosEventos);
$stmtOtrosEventos->bind_param("i", $idEvento);
$stmtOtrosEventos->execute();
$resultOtrosEventos = $stmtOtrosEventos->get_result();

$otrosEventos = [];
while ($evento = $resultOtrosEventos->fetch_assoc()) {
    $otrosEventos[] = $evento;
}

$stmtOtrosEventos->close();

// Consulta para obtener los detalles del evento, incluyendo entradas generales y VIP
$sql = "SELECT nombreEvento, descripcionEvento, fechahoraevento, imagenEvento,
               entradasGeneralEvento, entradasVipEvento,
               (entradasGeneralEvento + entradasVipEvento) AS entradasDisponiblesEvento 
        FROM evento 
        WHERE IdEvento = ?";
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
$sqlEntradas = "SELECT tipoEntrada, costoEntrada FROM entrada WHERE IdEvento = ?";
$stmtEntradas = $conn->prepare($sqlEntradas);
$stmtEntradas->bind_param("i", $idEvento);
$stmtEntradas->execute();
$resultEntradas = $stmtEntradas->get_result();

$entradas = [];
while ($entrada = $resultEntradas->fetch_assoc()) {
    $entradas[] = $entrada;
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
            background-image: url('./img/FqTK.gif'); 
            background-size: cover;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }
        body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    pointer-events: none; 
    z-index: 1;
}

body > * {
    position: relative;
    z-index: 2;
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
            color: #ffff;
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
            background-color: #008cf7;
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
            background-color: rgb(255, 255, 255);
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
            margin-top: auto;
        }

        footer a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            margin: 0 15px;
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
            width: 35px;
            height: 35px;
            filter: grayscale(100%);
            transition: filter 0.3s;
        }

        .social img:hover {
            filter: none;
        }
        .other-events-section {
    margin-top: 50px;
    text-align: center;
}

.carousel-container {
    position: relative;
    overflow: hidden;
    width: auto;
    max-width: 1200px;
    margin: 0 auto;
}

.carousel {
    display: flex;
    transition: transform 0.3s ease;
}

.carousel-item {
    min-width: auto;
    margin: 10px;
    text-align: center;
}

.carousel-item img {
    width: 200px;
    height: 100px;
    border-radius: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.carousel-item p {
    margin-top: 10px;
    font-size: 14px;
    color: #333;
}

.carousel-prev, .carousel-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    z-index: 2;
}

.carousel-prev {
    left: 10px;
}

.carousel-next {
    right: 10px;
}

    </style>
</head>
<body>

<div class="wrapper">
    <header>
        <div class="logo">
            🎵 ViveCusco
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
        <script>
        // JavaScript para cambiar el máximo de cantidad según el tipo de entrada seleccionado
        function actualizarMaximo() {
            const tipoEntrada = document.getElementById("tipoEntrada").value;
            const cantidadInput = document.getElementById("cantidad");

            // Ajusta el máximo basado en el tipo de entrada
            if (tipoEntrada === "General") {
                cantidadInput.max = <?php echo $evento['entradasGeneralEvento']; ?>;
            } else if (tipoEntrada === "Vip") {
                cantidadInput.max = <?php echo $evento['entradasVipEvento']; ?>;
            }
        }
    </script>
    </header>

    <div class="container">
        <h1><?php echo htmlspecialchars($evento['nombreEvento']); ?></h1>

        <div class="event-details">
            <img src="<?php echo htmlspecialchars($evento['imagenEvento']); ?>" alt="Evento <?php echo htmlspecialchars($evento['nombreEvento']); ?>">
            <div class="event-info">
                <p><strong>Fecha:</strong> <?php echo date('d M Y', strtotime($evento['fechahoraevento'])); ?></p>
                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['descripcionEvento']); ?></p>
                
                <!-- Filas de Entradas General y Entradas Vip -->
                <p><strong>Entradas General:</strong> <?php echo htmlspecialchars($evento['entradasGeneralEvento']); ?> disponibles</p>
                <p><strong>Entradas Vip:</strong> <?php echo htmlspecialchars($evento['entradasVipEvento']); ?> disponibles</p>

                <!-- Mostrar tipos de entrada y sus costos -->
                <p><strong>Precios de Entrada:</strong></p>
                <ul>
                    <?php foreach ($entradas as $entrada): ?>
                        <li><?php echo htmlspecialchars($entrada['tipoEntrada']) . ": S/" . number_format($entrada['costoEntrada'], 2); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="entry-section">
            <form action="../pasarela.php" method="POST">
                <div class="entry-label">Entradas</div>

                <div class="entry-selection">
                    <label for="tipoEntrada">Tipo de Entrada:</label>
                    <select name="tipoEntrada" id="tipoEntrada" onchange="actualizarMaximo()" required>
                        <?php foreach ($entradas as $entrada): ?>
                            <option value="<?php echo htmlspecialchars($entrada['tipoEntrada']); ?>">
                                <?php echo htmlspecialchars($entrada['tipoEntrada']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" min="1" max="<?php echo $evento['entradasGeneralEvento']; ?>" required placeholder="Nro">
                </div>

                <!-- Campo oculto para pasar el ID del evento -->
                <input type="hidden" name="idEvento" value="<?php echo htmlspecialchars($idEvento); ?>">

                <!-- Botón de envío -->
                <button type="submit" class="buy-btn" style="margin-top: 20px;">Comprar</button>
            </form>
        </div>
        <div class="other-events-section">
    <h2>Otros eventos</h2>
    <div class="carousel-container">
        <div class="carousel">
            <?php foreach ($otrosEventos as $evento): ?>
                <div class="carousel-item">
                    <a href="evento.php?id=<?php echo htmlspecialchars($evento['IdEvento']); ?>">
                        <img src="<?php echo htmlspecialchars($evento['imagenEvento']); ?>" alt="Evento <?php echo htmlspecialchars($evento['nombreEvento']); ?>">
                        <p><?php echo htmlspecialchars($evento['nombreEvento']); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-prev">&#10094;</button>
        <button class="carousel-next">&#10095;</button>
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
<script>
    const carousel = document.querySelector('.carousel');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');

    let scrollAmount = 0;

    prevButton.addEventListener('click', () => {
        scrollAmount -= 300; // Ajusta el valor según el ancho de cada item
        carousel.style.transform = `translateX(-${Math.max(scrollAmount, 0)}px)`;
    });

    nextButton.addEventListener('click', () => {
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;
        scrollAmount = Math.min(scrollAmount + 300, maxScroll);
        carousel.style.transform = `translateX(-${scrollAmount}px)`;
    });
</script>

</body>
</html>
