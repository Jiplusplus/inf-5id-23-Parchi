<!DOCTYPE html>
<html>
    <head>
        <title>Registro elettronico</title>
    </head>
    <body>
        <form method="GET" action="index.php">
            <select name="parco_id">
                <?php

                $ip = '127.0.0.1';
                $username = 'root';
                $pwd = '';
                $database = 'parchi';
                $connection = new mysqli($ip, $username, $pwd, $database);

                if ($connection->connect_error) {
                    die('C\'è stato un errore: ' . $connection->connect_error);
                }

                // echo 'Database collegato';
                $sql = 'SELECT nome, id, regione FROM parco';
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['id'] == $_GET['parco_id']) {
                            echo '<option selected value="' . $row['id'] . '">' . $row['nome'] . $row['regione'] . '</option>';
                        } else {
                            echo '<option value="' . $row['id'] . '">' . $row['nome'] . $row['regione'] . '</option>';
                        }
                    }
                }

                ?>
            </select>
            <input type="submit" />
        </form>
        
        <form method="GET" action="index.php">
            <select name="animale_id">
                <?php

                $ip = '127.0.0.1';
                $username = 'root';
                $pwd = '';
                $database = 'parchi';
                $connection = new mysqli($ip, $username, $pwd, $database);

                if ($connection->connect_error) {
                    die('C\'è stato un errore: ' . $connection->connect_error);
                }

                // echo 'Database collegato';
                $sql = 'SELECT id_animale, data_nascita, sesso, stato_salute, id_specie, id_parco FROM animale';
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_animale'] . '">' . $row['data_nascita'] . $row['sesso'] . $row['stato_salute'] . $row['id_specie'] . $row['id_parco'] .'</option>';
                    }
                }

                ?>
            </select>
            <input type="submit" />
        </form>

        <form method="GET" action="index.php">
            <select name="specie_id">
                <?php

                $ip = '127.0.0.1';
                $username = 'root';
                $pwd = '';
                $database = 'parchi';
                $connection = new mysqli($ip, $username, $pwd, $database);

                if ($connection->connect_error) {
                    die('C\'è stato un errore: ' . $connection->connect_error);
                }

                // echo 'Database collegato';
                $sql = 'SELECT id_specie, nome, id_parco FROM specie';
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_specie'] . '">' . $row['nome'] . $row['id_parco'] . '</option>';
                    }
                }

                ?>
            </select>
            <input type="submit" />
        </form>
        
    </body>
</html>
