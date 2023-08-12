<?php

    class Database
    {
        // Variable para declarar el parametro del servidor
        private $localhost = "localhost";
        // Variable para declarar el parametro del nombre de la base de datos
        private $namedatabase = "vacunas";

        // Variable para declarar el parametro del nombre de usuario
        private $username = "root";

        // Variable para declarar el parametro de la contraseña de usuario
        private $userpassword = "lucho2005533";

        // Variable para declarar el parametro de los caracteres 
        private $charset ="utf8";

        // MANEJO DE EXCEPCIONES TRY AND CATCH


        // CREAMOS UNA FUNCION PARA MEDIANTE UN TRY REALIZAR LA CONEXION A LA BASE DE DATOS LLAMANDO TODOS LOS VALORES DE LAS VARIABLES QUE CREAMOS PARA COLOCAR CADA PARAMETRO REQUERIDO PARA REALIZAR LA CONEXION
        
        function conectar()
        {
            try{
                $connection = "mysql:host=".$this->localhost.";dbname=".$this->namedatabase.";charset=".$this->charset;
                $option=[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

                $pdo= new PDO($connection,$this->username,$this->userpassword,$option);
                return $pdo;

            }catch(PDOException $e ){
                echo 'ERROR DE CONEXION A LA BASE DE DATOS:'.$e ->getMessage();
                exit;
            }
        }
    }


?>