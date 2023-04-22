<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "desis_php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if($_POST){
        $rut = $_POST["rut"];

        $buscar_rut = "SELECT COUNT(rut) AS cantidad_rut FROM votaciones WHERE rut = '$rut'";
        $count_rut = $conn->query($buscar_rut);
        $row = $count_rut->fetch_assoc();

        if($row['cantidad_rut'] > 0){
            echo 1;
        }else{
            $checks = implode(', ', $_POST["checks"]);
            $nombres = $_POST["nombres"];
            $rut = $_POST["rut"];
            $alias = $_POST["alias"];
            $email = $_POST["email"];
            //$checks = $_POST["checks"];
            $regiones = $_POST["regiones"];
            $candidato = $_POST["candidato"];
            $comunas = $_POST["comunas"];
            $fecha_hora = date("Y/m/d")." ".date("h:i:sa");

            $sql = "INSERT INTO votaciones (nombres, rut, alias, email, checks, region, comuna, candidato, fecha_hora) VALUES ('$nombres', '$rut', '$alias', '$email', '$checks', '$regiones', '$comunas', '$candidato', '$fecha_hora')";

            if ($conn->query($sql) === TRUE) {
                echo 2;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

    }
?>