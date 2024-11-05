<?php
include '../conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Proyecto</title>
</head>
<body>
<?php
$mensaje = htmlentities($_GET['msj']);
$c = htmlentities($_GET['c']);
$p = htmlentities($_GET['p']);
$t = htmlentities($_GET['t']);

switch ($c) {
	case 'admin':
        $carpeta = '../administrador/';
        break;
    case 'ER':
        $carpeta = '../regular/';
        break;
    case 'EE':
        $carpeta = '../egresado/';
        break;
    case 'GE':
        $carpeta = '../gerente/';
        break;
    case 'DO':
        $carpeta = '../docente/inicio/';
        break;
    case 'EG':
        $carpeta = '../egresado/';
        break;
    case 'DOO':
        $carpeta = '../docente/';
        break;
    case 'PRO':
        $carpeta = '../programa/';
        break;
    case 'TA':
        $carpeta = '../taller/';
        break;
    case 'VO':
        $carpeta = '../voluntario/';
        break;
    case 'salir':
        $carpeta = '../';
        break;
    case 'pe':
        $carpeta = '../perfil/';
        break;
    case 'CO':
        $carpeta = '../convenio/';
        break;
    case 'EM':
        $carpeta = '../empresa/';
        break;
    default:
        $carpeta = '../';
        break;
}

switch ($p) {
    case 'home':
        $pagina = 'index.php';
        break;
    case 'admin':
        $pagina = 'logIn.php';
        break;
    case 'salir':
        $pagina = '';
        break;
    case 'perfil':
        $pagina = 'perfil.php';
        break;
    case 'img':
        $pagina = 'imagenes.php';
        break;
    case 'can':
        $pagina = 'cancelados.php';
        break;
    case 'sl':
        $pagina = 'slider.php';
        break;
    case 'ER':
        $pagina = 'inscripcion_alumnos_regulares.php';
        break;
    case 'EE':
        $pagina = 'inscripcion_alumnos_egresados.php';
        break;
    case 'DO':
        $pagina = 'registro_docente.php';
        break;
    case 'PRO':
        $pagina = 'registro_programa.php';
        break;
    case 'TA':
        $pagina = 'registro_taller.php';
        break;
    case 'CO':
        $pagina = 'registro_convenio.php';
        break;
    case 'VOF':
        $pagina = 'inscripcion_alumnos_regulares_voluntariado.php';
        break;
    default:
        $pagina = 'index.php';
        break;
}

$dir = $carpeta . $pagina;

if (isset($_GET['id'])) {
    $id = htmlentities($_GET['id']);
    $dir .= '?id=' . $id;
}

$titulo = ($t == "error") ? "Oppss.." : "Excelente!";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Proyecto</title>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        swal.fire({
            title: '<?php echo $titulo ?>',
            text: "<?php echo $mensaje ?>",
            icon: '<?php echo $t ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        }).then(function () {
            location.href = '<?php echo $dir ?>';
        });

        $(document).click(function() {
            location.href = '<?php echo $dir ?>';
        });

        $(document).keydown(function(e) {
            if (e.which == 27) { 
                location.href = '<?php echo $dir ?>';
            }
        });
    </script>
</body>
</html>