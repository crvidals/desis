<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "desis_php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $ordinal_region = $_POST['ordinal_region'] ? $_POST['ordinal_region'] : 'I';

    $sql = "SELECT
            comuna_id AS id_comuna,
            comuna_nombre AS comuna,
            provincia_nombre AS provincia,
            region_nombre AS region
            FROM comunas
            INNER JOIN provincias ON comunas.provincia_id = provincias.provincia_id
            INNER JOIN regiones ON provincias.region_id = regiones.region_id
            WHERE region_ordinal LIKE '$ordinal_region'";

    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        while($f = $res->fetch_assoc()) {
            echo "<option value='".$f["id_comuna"]."'>".$f["comuna"]."</option>";
        }
    } else {
        echo "No hay comunas registradas.";
    }
?>