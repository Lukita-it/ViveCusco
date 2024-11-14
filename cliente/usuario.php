<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ./login.html");
    exit();
}

include '../conexion.php';

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_SESSION['usuario'];

    $sql = "UPDATE cliente SET nombreCliente = ?, apellidoCliente = ? WHERE correoCliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $apellido, $correo);

    if ($stmt->execute()) {
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f4f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        header {
            background-color: #007bff;
            padding: 20px 40px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #0056b3;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        .buttons a button {
            background-color: #fff;
            color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }

        .buttons a button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            flex-grow: 1;
        }

        .profile-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .container-left, .container-right {
            width: 50%;
            padding: 40px;
        }

        .container-left {
            border-right: 1px solid #e0e0e0;
        }

        .container-left h2, .container-right h2 {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #007bff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #007bff;
        }

        .button-container button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f4f7fa;
            color: #007bff;
            font-weight: bold;
        }

        footer {
            text-align: center;
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        footer a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
            transition: 0.3s;
        }

        footer a:hover {
            color: #0056b3;
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
    <div class="profile-container">
        <div class="container-left">
            <h2>Perfil del Usuario</h2>
            <div class="profile-picture" style="text-align: center;">
                <img src="../img/perfil.jpeg" alt="Foto de Perfil">
            </div>
            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($_SESSION['apellido']); ?>">
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
</div>

<footer>
    <a href="../info.html">Quienes somos?</a>
    <a href="../contacto.html">Contactarse</a>
    <a href="../privacy.html">Política de Privacidad</a>
</footer>

</body>
</html>
