<?php
    session_start();
    $ip = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "parchi";
    $connection = new mysqli($ip, $username, $password, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kai_Guardaparco</title>
</head>
<body>
    <form action="" method="get">
        <select name="id_parco" id="id_parco">
            <?php 
                $query = "SELECT * FROM parco";
                $result = $connection ->query($query);
                var_dump($result);
                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["Nome"] . " " . $row["Regione"] . "</option>";
                    }
                }
            ?>
        </select>
        <input type="submit" value="inviaParco">
    </form>
    <form action="" method="get">
        <select name="id_specie" id="id_specie">
            <option value="" selected disabled hidden>Seleziona specie</option>
            <?php
                if(isset($_GET["id_parco"])){
                    $_SESSION["id_parco"] = $_GET["id_parco"];
                    $query = "SELECT id_animale, animale.id_specie, id_parco, nome  FROM animale INNER JOIN specie ON animale.id_specie = specie.id_specie WHERE id_parco = '" . $_GET['id_parco'] . "' GROUP BY nome";
                    $result = $connection ->query($query);
                    if ($result->num_rows > 0) {
                    
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id_specie"] . "'>" . $row["nome"] . "</option>";
                        }
                    }
                }
            ?>
        </select>
        <input type="submit" value="inviaSpecie" onClick="clearcontent('contenuto')">
    </form>
    <div id="contenuto">
        <?php
            if(isset($_GET["id_specie"])){
                $query = "SELECT * FROM animale WHERE id_parco = '" . $_SESSION["id_parco"] . "' AND id_specie = '" . $_GET['id_specie'] . "'";
                $result = $connection ->query($query);
                if ($result->num_rows > 0) {
                    echo "<h1>Animali presenti " . $result->num_rows . "</h1>";
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<h4>" . "Nome: " . $row["nome_animale"] . "</h4>";
                        echo "<p>" . "Data di nascita: " . $row["data_nascita"] . "</p>";
                        echo "<p>" . "Sesso: " . $row["sesso"] . "</p>";
                        echo "<p>" . "Stato salute: " . $row["stato_salute"] . "</p>";

                    }
                }
                $query = "SELECT ROUND(AVG(YEAR(CURRENT_DATE) - YEAR(data_nascita))) AS media FROM animale WHERE id_parco = '" . $_SESSION['id_parco'] . "' AND id_specie = '" . $_GET['id_specie'] . "'";
                $result = $connection ->query($query);
                if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       echo "<h3> Età media: " . $row["media"] . "</h3>";
                   }
                }
            }
        ?>
    </div>
    <script>
        function clearcontent(elementID) {
            document.getElementById(elementID).innerHTML = "";
        }
    </script>
</body>
</html>


