<?php
// SE DEBE INCLUIR EL ARCHIVO DE CONEXION A LA BASE DE DATOS
require_once("database/connection.php");
session_start();
// VARIABLES QUE CONTIENE LA CLASE CON LOS PARAMETROS DE CONEXION A LA BASE DE DATOS
$database = new Database();
// VARIABLE QUE CONTIENE LA CONEXION A LA BASE DE DATOS SIFER-APP
$connection = $database->conectar();



$user_report = $connection->prepare("SELECT * FROM usuario WHERE tipo_usuario = 1");
$user_report->execute();
$usuario = $user_report->fetch(PDO::FETCH_ASSOC);

$clientes_report = $connection->prepare("SELECT * FROM usuario WHERE tipo_usuario = 2");
$clientes_report->execute();
$clientes = $clientes_report->fetch(PDO::FETCH_ASSOC);



?>
<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {


    
    date_default_timezone_set('America/Bogota');

    // DECLARACION DE LOS VALORES DE LAS VARIABLES DEPENDIENDO DEL TIPO DE CAMPO QUE TENGA EN EL FORMULARIO
    $document_user = $_POST['usuario'];
    $document_enfermero = $_POST['enfermero'];
    $vacuna=$_POST['vacuna'];


    $ahora = new DateTime();

    $fecha_fin = clone $ahora;
    $fecha_fin->add(new DateInterval('P1Y'));

    // Convertir los objetos DateTime en cadenas con el formato adecuado
    $fecha = $ahora->format('Y-m-d H:i:s');
    $fechaFin = $fecha_fin->format('Y-m-d H:i:s');



    // CONSULTA SQL PARA VERIFICAR SI EL USUARIO YA EXISTE EN LA BASE DE DATOS
    $db_validation = $connection->prepare("SELECT * FROM detalle_vacuna WHERE documento = '$document_enfermero' AND documento_user ='$document_enfermero' AND estado = 1");
    $db_validation->execute();
    $register_validation = $db_validation->fetchAll();

    // CONDICIONALES DEPENDIENDO EL RESULTADO DE LA CONSULTA
    if ($register_validation) {
        // SI SE CUMPLE LA CONSULTA ES PORQUE EL USUARIO YA EXISTE
        echo '<script> alert ("// Estimado Usuario la vacuna ya fue registrada al usuario. //");</script>';
        echo '<script> window.location= "usuario.php"</script>';
    } else if ($document_user == "" || $document_enfermero == ""  || $fecha == "" || $fechaFin == "" || $vacuna == "") {
        // CONDICIONAL DEPENDIENDO SI EXISTEN ALGUN CAMPO VACIO EN EL FORMULARIO DE LA INTERFAZ
        echo '<script> alert ("Estimado Usuario, Existen Datos Vacios En El Formulario");</script>';
        echo '<script> window.location= "usuario.php"</script>';
    } else {
        $register_user = $connection->prepare("INSERT INTO detalle_vacuna(documento,documento_user,vacuna,fecha_vacuna,fecha_fin,estado) VALUES('$document_enfermero','$document_user','$vacuna','$fecha','$fechaFin',1)");
        if ($register_user->execute()) {
            echo '<script>alert ("Registro Exitoso de Vacuna.");</script>';
            echo '<script>window.location="lista_vacunas.php"</script>';
        }
    }
}
?>
<!-- ESTRUCTURA DEL FORMULARIO DE REGISTRO HTML -->

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="main.css">

    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css" />
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../controller/css/custom.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>REGISTRAR VACUNA || CONTROL DE VACUNAS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/CSS/bootstrap.min.css">
    <!----css3---->
    <link rel="stylesheet" href="public/CSS/custom.css">
    <!--google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../controller/image/favicon.png" type="image/x-icon">
    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <!--font awesome con CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>


<body onload="limitarFechas()">

    <div class="wrapper">

        <?php
        require_once('menu.php');
        ?>

        <div class="xp-breadcrumbbar text-center">
            <h2 class="page-title"><span>REGISTRO DE VACUNA</span></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Datos</a></li>
                <li class="breadcrumb-item active" aria-curent="page">Vacuna</li>
            </ol>
        </div>
    </div>
    </div>


    <div class="container-fluid mt-4">
        <div class="col-xs-12 ml-2">
            <!-- FORM CONTAINER -->
            <form method="POST" name="formreg" action="" autocomplete="off">

                <div class="form-group">
                    <!-- Container: Vacuna -->
                    <label for="name" class="formulario__label">Vacuna</label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" oninput="maxlengthNumber(this);" onkeypress="return(multipletext(event));" maxlength="15" name="vacuna" required id="vacuna" placeholder="Ingrese nombre de la vacuna">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Debe ingresar solo letras, y debe indicar su primer nombre</p>
                </div>

                <!-- CONTAINER MARCAS DE MOTOS -->
                <div class="form-group">
                    <div class="top">
                        <label for="tipousuario" class="formulario__label">Enfermero</label>
                        <!-- Botón para mostrar la ventana emergente (Modal) -->
                    </div>
                    <div class="formulario__grupo__input">
                        <select id="control" name="enfermero" class="formulario__input">
                            <option disabled selected value="">Seleccionar Enfermero</option>
                            <?php
                            do {
                            ?>
                                <option value="<?php echo ($usuario['document']) ?>"><?php echo ($usuario['nombre_completo']) ?></option>

                            <?php
                            } while ($usuario = $user_report->fetch(PDO::FETCH_ASSOC));
                            ?>
                        </select>
                    </div>
                </div>

                <!-- CONTAINER MARCAS DE MOTOS -->
                <div class="form-group">
                    <div class="top">
                        <label for="tipousuario" class="formulario__label">Cliente</label>
                        <!-- Botón para mostrar la ventana emergente (Modal) -->
                    </div>
                    <div class="formulario__grupo__input">
                        <select id="control" name="usuario" class="formulario__input">
                            <option disabled selected value="">Seleccionar Usuario</option>
                            <?php
                            do {
                            ?>
                                <option value="<?php echo ($clientes['document']) ?>"><?php echo ($clientes['nombre_completo']) ?></option>

                            <?php
                            } while ($clientes = $clientes_report->fetch(PDO::FETCH_ASSOC));
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group" role="group" aria-label="Button group">
                    <input type="submit" class="btn btn-info ml-3" name="validar" value="Registrar"></input>
                    <input type="hidden" name="MM_insert" value="formreg">
                    <a href="index.php" class="btn btn-danger">Cancelar Registro</a>
                </div>
            </form>
        </div>
    </div>

    </div>


    <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO EL NUMERO VALORES REQUERIDOS DE ACUERDO A LA LONGITUD MAXLENGTH DEL CAMPO -->

    <script>
        // FUNCION DE JAVASCRIPT PARA VALIDAR LOS AÑOS DE RANGO PARA LA FECHA DE NACIMIENTO
        var fechaInput = document.getElementById('fecha');
        // Calcular las fechas mínima y máxima permitidas
        var fechaMaxima = new Date();
        fechaMaxima.setFullYear(fechaMaxima.getFullYear() - 18); // Restar 18 años para que la persona se registre
        var fechaMinima = new Date();
        fechaMinima.setFullYear(fechaMinima.getFullYear() - 80); // Restar 80 años
        // Formatear las fechas mínima y máxima en formato de fecha adecuado (YYYY-MM-DD)
        var fechaMaximaFormateada = fechaMaxima.toISOString().split('T')[0];
        var fechaMinimaFormateada = fechaMinima.toISOString().split('T')[0];

        // Establecer los atributos min y max del campo de entrada de fecha
        fechaInput.setAttribute('min', fechaMinimaFormateada);
        fechaInput.setAttribute('max', fechaMaximaFormateada);

        function maxlengthNumber(obj) {

            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el numeros de digitos requeridos");
            }
        }
    </script>

    <script>
        function maxcelNumber(obj) {

            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo 10 numeros.");
            }
        }
    </script>
    <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO LETRAS -->

    <script>
        function multipletext(e) {
            key = e.keyCode || e.which;

            teclado = String.fromCharCode(key).toLowerCase();

            letras = "qwertyuiopasdfghjklñzxcvbnm ";

            especiales = "8-37-38-46-164-46-32";

            teclado_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    teclado_especial = true;
                    alert("Debe ingresar solo letras y espacios en el campo");

                    break;
                }
            }

            if (letras.indexOf(teclado) == -1 && !teclado_especial) {
                return false;
                alert("Debe ingresar solo letras y espacios en el campo");
            }
        }
    </script>
    <!-- para usar botones en datatables JS -->
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

    <!-- Agregar el enlace a Bootstrap JS (requerido para el funcionamiento del formulario) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para mostrar u ocultar el formulario al hacer clic en el enlace -->
    <script>
        document.getElementById('mostrarFormulario').addEventListener('click', function() {
            var formulario = document.getElementById('formulario');
            if (formulario.style.display === 'none') {
                formulario.style.display = 'block';
            } else {
                formulario.style.display = 'none';
            }
        });
    </script>

    <!-- código JS propìo-->
    <script type="text/javascript" src="main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".xp-menubar").on('click', function() {
                $("#sidebar").toggleClass('active');
                $("#content").toggleClass('active');
            });

            $('.xp-menubar,.body-overlay').on('click', function() {
                $("#sidebar,.body-overlay").toggleClass('show-nav');
            });

        });
    </script>





    <script>
        function multiplenumber(e) {
            key = e.keyCode || e.which;

            teclado = String.fromCharCode(key).toLowerCase();

            letras = "1234567890";

            especiales = "8-37-38-46-164-46";

            teclado_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    teclado_especial = true;
                    break;
                }
            }

            if (letras.indexOf(teclado) == -1 && !teclado_especial) {
                return false;
                alert("Debe ingresar solo numeros en el campo y debe ser en un rango de 6 a 10 numeros.");
            }
        }
    </script>





    <!-- TYPED JS -->
    <script src="https://unpkg.com/typed.js@2.0.132/dist/typed.umd.js"></script>
    <script src="../../controller/JS/main.js"></script>

    <!-- VALIDACION DE FORMULARIO -->
    <script src="../../controller/JS/formulario.js"></script>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>

    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>



</body>

</html>