<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexion.php'; // Archivo que conecta a la base de datos

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $dni = htmlspecialchars($_POST['dni']);
    $correo = htmlspecialchars($_POST['correo']);
    $contrasena = htmlspecialchars($_POST['contrasena']);

    // Encriptar la contraseña antes de guardarla
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar los datos en la tabla "cliente" sin incluir "IdCliente"
    $sql = "INSERT INTO cliente (nombreCliente, apellidoCliente, dniCliente, correoCliente, contrasenaCliente) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssss", $nombre, $apellido, $dni, $correo, $contrasena_encriptada);

    if ($stmt->execute()) {
        // Mostrar un mensaje de éxito y redirigir
        echo "<script>
                alert('Registro exitoso. ¡Bienvenido!');
                window.location.href = '../cliente/usuario.html'; // Cambia esto a la página de inicio de sesión
              </script>";
    } else {
        // Mostrar un mensaje de error
        echo "<script>
                alert('Error en el registro. Inténtalo de nuevo.');
                window.location.href = './registro_usuario.html';
              </script>";
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
}
$conn->close();
?>
