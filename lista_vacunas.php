<?php
session_start();
require_once("database/connection.php");
$db = new Database();
$connection = $db->conectar();

$vacunasRegistradas = $connection->prepare("SELECT * FROM detalle_vacuna INNER JOIN usuario ON detalle_vacuna.documento = usuario.document WHERE usuario.tipo_usuario = 1  ");
$vacunasRegistradas->execute();
$vacunas = $vacunasRegistradas->fetchAll(PDO::FETCH_ASSOC);
?>

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
    <title>ACTUALIZACION SOAT || SIFER-APP</title>
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


<body>
    <div class="wrapper">

        <?php

        require_once('./menu.php');

        ?>


        <div class="xp-breadcrumbbar text-center">
            <h2 class="page-title"><span>REPORTE ACTUALIZACION DE VACUNAS </span></h2>
        </div>
    </div>
    </div>


    <!--Ejemplo tabla con DataTables-->
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">

                    <?php

                    date_default_timezone_set('America/Bogota');


                    echo '<table class="table table-striped table-bordered" cellspacing="0" width="100%">';
                    try {
                        $fecha_actual = new DateTime();

                        if (!empty($vacunas)) {
                            foreach ($vacunas as $vacuna) {
                                $fechaVenta = new DateTime($vacuna['fecha_vacuna']);
                                $fechaVencimiento = new DateTime($vacuna['fecha_fin']);
                                $diasRestantes = $fecha_actual->diff($fechaVencimiento)->days;

                                echo '<thead>
                                <tr>
                                    
                                    <th>Vacuna</th>
                                    <th>Enfermero</th>
                                    <th>Usuario</th>
                                    <th>Fecha Vacunacion</th>
                                    <th>Fecha Final</th>
                                    <th>Dias Restantes</th>
                                    <th>Estado</th>
                                    
                                </tr>
                            </thead>';

                                echo '<tbody>';

                                // Agregar clase CSS si el registro está vencido
                                $class = ($fecha_actual > $fechaVencimiento) ? 'vencido' : '';

                                echo '<tr class="' . $class . '">';
                                echo '<td>' . $vacuna['vacuna'] . '</td>';
                                echo '<td>' . $vacuna['nombre_completo'] . '</td>';
                                echo '<td>' . $vacuna['documento_user'] . '</td>';
                                echo '<td>' . $fechaVenta->format('Y-m-d H:i:s') . '</td>';
                                echo '<td>' . $fechaVencimiento->format('Y-m-d H:i:s') . '</td>';
                                echo '<td>' . $diasRestantes . ' dias' . '</td>';

                                if ($vacuna['estado'] == 1) {
                                    echo '<td>Activo</td>';
                                } else {
                                    echo '<td>Vencido</td>';
                                }

                                echo '</tr>';
                                echo '</tbody>';
                            }
                        } else {

                            echo '<thead>
                            <tr>
                                <th>Sin registros</th>
                            </tr>
                        </thead>';

                            echo '<tbody>';
                            echo '<tr class=" align-content-center">';
                            echo '<td> No hay documentos por actualizar</td>';
                            echo '</tr>';
                            echo '</tbody>';
                        }
                    } catch (PDOException $e) {
                        echo 'Error' . $e->getMessage();
                    }
                    echo '</table>';

                    ?>

                    <?php

                    if ($fecha_actual > $fechaVencimiento) {

                        // Encriptacion del numero de documento 

                        $correo_electronico= $vacuna['correo'];

                        $asunto = "Actualizacion de Vacuna";
                        $message = "Estimado Usuario Debe acercarse nuevamente realizar su vacuna";

                        $admin_email = "From:lamunoz0140@misena.edu.co";

                        if (mail($correo_electronico, $asunto, $message, $admin_email)) {
                            echo '<script>alert("El usuario ' . $email['nombre_completo'] . 'Debe actualizar su vacuna.");</script>';
                            echo '<script>window.location="index.php"</script>';
                        } else {
                            echo '<script>alert("Error, no se pudo habilitar el cambio de contraseña");</script>';
                            echo '<script>window.location="index.php"</script>';
                        }
                    } 

                    ?>
                </div>
            </div>
        </div>
    </div>

    </div>





    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>

    <!-- para usar botones en datatables JS -->
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

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


</body>

</html>