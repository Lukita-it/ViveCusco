<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ./login.html");
    exit();
}

include '../conexion.php'; // archivo de conexión a la base de datos

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_SESSION['usuario']; // Mantener el correo del usuario en sesión

    // Actualizar los datos en la base de datos
    $sql = "UPDATE cliente SET nombreCliente = ?, apellidoCliente = ? WHERE correoCliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $apellido, $correo);

    if ($stmt->execute()) {
        // Actualizar los datos en la sesión
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        echo "<script>alert('Datos actualizados exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <style>
        html, body {
            height: 100%; 
            margin: 0; 
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            box-sizing: border-box;
            display: flex; 
            flex-direction: column;
        }

        header {    
            background-color: #000000; 
            padding: 20px 40px;
            display: flex;
            align-items: center;
            border-bottom: 3px solid #000000; 
            color: #fff;
        }

        h1 {
            margin: 0;
            flex-grow: 1; 
            font-size: 28px; 
            text-align: left;
        }
        .buttons {
            display: flex;
            gap: 15px; 
        }

        .main-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px; 
            margin: 20px auto;
            padding: 30px; 
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }

        .container-left, .container-right {
            width: 48%;
        }

        .container-left h2, .container-right h2 {
            color: #000000;
            margin-bottom: 20px;
        }

        .profile-picture {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .form-group {
            margin-bottom: 15px; 
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }

        .form-row div {
            flex: 1; 
            margin-right: 10px; 
        }

        .form-row div:last-child {
            margin-right: 0; 
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; 
            padding: 10px; 
            border-radius: 4px; 
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #000000; 
            outline: none;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 15px; 
            background-color: #0ac3f7;
            color: white;
            border: none; 
            border-radius: 4px;
            cursor: pointer;
            width: 100%; 
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #ff4500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f4f8;
            color: #333;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            margin-top: auto;
        }

        footer a {
            margin-right: 20px;
            text-decoration: none;
            color: #000000;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ff6347;
        }
    </style>
</head>
<body>

<header>
    <h1>Cuenta</h1>
    <div class="buttons">
        <a href="../index.php"><button>Principal</button></a>
    </div>
</header>

<div class="main-container">
<div class="container-left">
    <h2>Perfil del Usuario</h2>
    <div class="profile-picture">
        <img src="../img/perfil.jpeg" alt="Foto de Perfil">
    </div>
    <form method="POST">
        <div class="form-group form-row">
            <div>
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>">
            </div>
            <div>
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($_SESSION['apellido']); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" readonly>
        </div>
        <div class="button-container">
            <button type="submit">Guardar Cambios</button>
        </div>
    </form>
</div>


    <div class="container-right">
        <h2>Entradas</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Evento</th>
                    <th>Fecha y Hora</th>
                    <th>Tipo de Entrada</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Concierto Rock</td>
                    <td>25/10/2024 - 20:00</td>
                    <td>VIP</td>
                </tr>
                <tr>
                    <td>Noche Electrónica</td>
                    <td>01/11/2024 - 19:30</td>
                    <td>General</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <a href="../info.html">Quienes somos?</a>
    <a href="../contacto.html">Contactarse</a>
    <a href="../privacy.html">Política de Privacidad</a>
</footer>

</body>
</html>