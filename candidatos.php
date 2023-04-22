<?php
    $username = "root";
    $password = "";
    $dbname = "desis_php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM candidatos";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        while($f = $res->fetch_assoc()) {
            echo "<option value='".$f["id"]."'>".$f["nombres"]."</option>";
        }
    } else {
        echo "No hay candidatos registrados.";
    }
?>