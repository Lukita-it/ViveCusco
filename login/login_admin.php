<?php
session_start();
include '../conexion.php'; // archivo de conexión a la base de datos

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT * FROM administrador WHERE correoAdministrador = ? AND contrasenaAdministrador = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        // Iniciar sesión y redirigir al usuario
        $_SESSION['usuario'] = $correo;
        header("Location: ../administracion/home.php");
    } else {
        echo "<script>
                alert('Correo o contraseña incorrectos.');
                window.location.href = './login.html'; // Redirige de nuevo al formulario de login
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
