<?php
session_start();
include '../conexion.php'; // archivo de conexión a la base de datos

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos para obtener el hash de la contraseña
    $sql = "SELECT nombreCliente, apellidoCliente, correoCliente, contrasenaCliente FROM cliente WHERE correoCliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasenaCliente'])) {
            // Iniciar sesión y redirigir al usuario
            $_SESSION['usuario'] = $usuario['correoCliente'];
            $_SESSION['nombre'] = $usuario['nombreCliente'];
            $_SESSION['apellido'] = $usuario['apellidoCliente'];
            header("Location: ../cliente/usuario.php");
            exit();
        } else {
            // Mostrar una alerta en caso de credenciales incorrectas
            echo "<script>
                    alert('Correo o contraseña incorrectos.');
                    window.location.href = './login.html'; // Redirige de nuevo al formulario de login
                  </script>";
        }
    } else {
        // Mostrar una alerta en caso de credenciales incorrectas
        echo "<script>
                alert('Correo o contraseña incorrectos.');
                window.location.href = './login.html'; // Redirige de nuevo al formulario de login
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
