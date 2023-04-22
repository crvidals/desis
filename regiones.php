<?php
    header('Content-Type: text/html; charset=UTF-8');
    $username = "root";
    $password = "";
    $dbname = "desis_php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM regiones";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        while($f = $res->fetch_assoc()) {
            echo "<option value='".$f["region_ordinal"]."'>".$f["region_nombre"]."</option>";
        }
    } else {
        echo "No hay regiones registradas.";
    }
?>