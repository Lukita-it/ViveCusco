<?php
// Incluye el archivo de conexión
include './conexion.php';

// Recibe los datos del formulario enviado
$tipoEntrada = isset($_POST['tipoEntrada']) ? $_POST['tipoEntrada'] : '';
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
$idEvento = isset($_POST['idEvento']) ? intval($_POST['idEvento']) : 0;

// Consulta para obtener el precio de la entrada
$sqlPrecio = "SELECT costoEntrada FROM entrada WHERE IdEvento = ? AND tipoEntrada = ?";
$stmtPrecio = $conn->prepare($sqlPrecio);
$stmtPrecio->bind_param("is", $idEvento, $tipoEntrada);
$stmtPrecio->execute();
$resultPrecio = $stmtPrecio->get_result();

if ($resultPrecio->num_rows > 0) {
    $entrada = $resultPrecio->fetch_assoc();
    $precioUnitario = $entrada['costoEntrada'];
} else {
    echo "<p>Tipo de entrada no encontrado o precio no disponible.</p>";
    exit;
}

$total = $cantidad * $precioUnitario;

// Cierra la conexión a la base de datos
$stmtPrecio->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago</title>
    <style>
        html, body {
            height: 100%; 
            margin: 0; 
            display: flex;
            flex-direction: column; 
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            box-sizing: border-box;
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

        .main-container {
            display: flex; 
            justify-content: space-between; 
            max-width: 1200px; 
            margin: 20px auto; 
            flex-grow: 1; 
        }

        .container {
            display: flex; 
            width: 200%; 
            height: calc(100% - 80px); 
            min-height: 500px; 
            padding: 20px; 
        }

        .payment-methods, .ticket-summary {
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .payment-methods {
            width: 500px; 
            margin-right: 10px; 
            min-height: 400px; 
            padding: 70px; 
        }

        .ticket-summary {
            width: 500px; 
            min-height: 400px; 
            padding: 70px; 
        }

        .payment-methods h2, .ticket-summary h2 {
            margin-bottom: 20px;
        }

        .payment-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-button {
            width: auto; 
            height: 60px; 
            border-radius: 5px; 
            border: none; 
            cursor: pointer; 
            background-size: contain; 
            background-position: center; 
            background-repeat: no-repeat; 
        }

        .yape { background-image: url('./img/yape4.jpg');}
        .pagoefectivo { background-image: url('./img/pagoefectivo.jpeg'); }
        .mercadopago { background-image: url('./img/mercadopago.jpg'); }

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
    <div class="wrapper"></div>
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

    <div class="main-container">
        <div class="container">
            <div class="payment-methods">
                <h2>Seleccionar Método de Pago</h2>
                <div class="payment-buttons">
                    <a href="https://www.yape.com.pe/" class="payment-button yape"></a>
                    <a href="https://www.pagoefectivo.la/pe/" class="payment-button pagoefectivo"></a>
                    <a href="https://www.mercadopago.com.pe/home" class="payment-button mercadopago"></a>
                </div>
            </div>

            <div class="ticket-summary">
        <h2>Entradas</h2>
        <ul style="list-style:none; padding-left:0;">
            <li><?php echo "x$cantidad $tipoEntrada"; ?></li>
        </ul>
        <p><strong>Total:</strong> S/<?php echo number_format($total, 2); ?></p>
    </div>
        </div>
    </div>

    <footer>
        <a href="../privacy.html">Política de Privacidad</a> | 
        <a href="../tyc.html">Términos y Condiciones</a>
        <div class="social">
            <a href="https://www.facebook.com/" target="_blank"><img src="./img/facebook.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/" target="_blank"><img src="./img/instagram.jpg" alt="Instagram"></a>
            <a href="https://x.com/" target="_blank"><img src="./img/x.png" alt="X"></a>
        </div>
    </footer>
</body>
</html>
