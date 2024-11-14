<?php include './conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Eventos</title>
    <style>
        html, body {
            height: 100%; 
            margin: 0;
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            background-image: url('./img/back-blu.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed; 
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            color: #ffffff;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            backdrop-filter: brightness(0.8); 
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
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        h1 {
            margin-bottom: 40px;
            font-size: 36px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .event-card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        .event-card img {
            width: 100%;
            height: 200px;
            border-radius: 15px;
            object-fit: cover;
            margin-bottom: 20px;
            transition: opacity 0.3s ease;
        }

        .event-card:hover img {
            opacity: 0.8;
        }

        .event-card h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        .event-card p {
            font-size: 16px;
            color: #555;
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
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .buy-btn:hover {
            background-color: #ff4500;
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
    </style>
</head>
<body>

<div class="wrapper">
    <header>
        <div class="logo">
            <span>🎵 Local</span>
        </div>
        <nav>
            <ul>
                <li><a href="./index.php">Principal</a></li>
                <li><a href="./info.html">Info</a></li>
                <li><a href="./contacto.html">Contacto</a></li>
            </ul>
        </nav>
        <div class="buttons">
            <a href="./login/login.html" class="buy-btn">Ingresar</a>
            <a href="./login/registro_usuario.html" class="buy-btn">Registrar</a>
        </div>
    </header>

    <div class="container">
        <h1>Próximos Eventos</h1>
        <div class="event-grid">
        <?php
include 'conexion.php'; // Asegúrate de que la ruta es correcta
$sql = "SELECT idEvento, nombreEvento, descripcionEvento, fechahoraevento,
               entradasGeneralEvento, entradasVipEvento,
               (entradasGeneralEvento + entradasVipEvento) AS entradasDisponiblesEvento,
               imagenEvento 
        FROM evento";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($evento = $result->fetch_assoc()) {
        echo '<div class="event-card">';
        echo '<img src="' . $evento['imagenEvento'] . '" alt="' . $evento['nombreEvento'] . '">';
        echo '<h3>' . $evento['nombreEvento'] . '</h3>';
        echo '<p>Fecha: ' . date('d M Y', strtotime($evento['fechahoraevento'])) . '</p>';
        echo '<p>' . $evento['descripcionEvento'] . '</p>';
        echo '<p>Entradas disponibles: ' . $evento['entradasDisponiblesEvento'] . '</p>'; // Aquí se utiliza la suma calculada
        echo '<a href="./eventos/evento.php?id=' . $evento['idEvento'] . '" class="buy-btn">Comprar Entradas</a>';
        echo '</div>';
    }
} else {
    echo '<p>No hay eventos disponibles.</p>';
}

$conn->close(); // Cierra la conexión
?>


        </div>
    </div>

    <footer>
        <a href="./privacy.html">Política de Privacidad</a> | 
        <a href="./tyc.html">Términos y Condiciones</a>
        <div class="social">
            <a href="https://www.facebook.com/" target="_blank"><img src="./img/facebook.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/" target="_blank"><img src="./img/instagram.png" alt="Instagram"></a>
            <a href="https://www.x.com/" target="_blank"><img src="./img/x.png" alt="Twitter"></a>
        </div>
    </footer>
</div>
</body>
</html>