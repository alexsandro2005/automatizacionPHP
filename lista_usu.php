<?php

session_start();
require_once("database/connection.php");
$db = new Database();

$connection = $db->conectar();

$user_report = $connection->prepare("SELECT * FROM usuario");
$user_report->execute();
$reporte = $user_report->fetch(PDO::FETCH_ASSOC);

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
    <title>LISTA DE ENFERMEROS</title>
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

        require_once('menu.php');
        ?>


        <div class="xp-breadcrumbbar text-center">
            <h2 class="page-title"><span>Bienvenido</span></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">lista</a></li>
                <li class="breadcrumb-item active" aria-curent="page">Usuarios</li>
            </ol>
        </div>

    </div>
    </div>

    <div class="container-fluid">

        <div class="mt-3 col-xs-12 ml-2">
            <a href="enfermero.php" class="btn btn-block btn-info">Registrar Enfermero</a>
        </div>

    </div>


    <!--Ejemplo tabla con DataTables-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="table-responsive">

                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>

                                <label for="selectAll"></label></th>
                                
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                

                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $comando = $connection->prepare("SELECT * FROM usuario WHERE tipo_usuario = 1");
                            $comando->execute();
                            $resultado = $comando->fetchAll();
                            ?>

                            <?php
                            foreach ($resultado as $rows) {

                            ?>
                                <tr>

                                   
                                    <th><?= $rows["document"] ?></th>
                                    <th><?= $rows["nombre_completo"] ?></th>
                                    
                                    <th><?= $rows["telefono"] ?></th>
                                    <th><?= $rows["correo"] ?></th>
                                    


                                </tr>

                            <?php

                            }
                            ?>


                        </tbody>
                    </table>
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