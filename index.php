<!DOCTYPE html>
<html>
    <head>
        <title>Parchi</title>
    </head>
    <body>
    <?php
        function getRowsNumber() {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = $this->connect()->query($sql);
        $count = $stmt->fetchColumn();
        print $count;
            }
    ?>
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
                            echo '<option selected value="' . $row['id'] . '">' . $row['nome'] . ' ' .$row['regione'] . '</option>';
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
                        echo '<option value="' . $row['id_specie'] . '">' . $row['nome'] . '</option>';
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
                        if($row['id_animale'] == $_GET['animale_id']){
                            echo '<option selected value="' . $row['id_animale'] . '">' . $row['data_nascita'] . ' ' . $row['sesso'] . ' ' . $row['stato_salute'] .'</option>';
                        }else{
                            echo '<option selected value="' . $row['id_animale'] . '">' . $row['data_nascita'] . ' ' . $row['sesso'] . ' ' . $row['stato_salute'] .'</option>';
                        }
                    
                    }
                }
                

                ?>
            </select>
            <input type="submit" />
        </form>

        <?php
        if (isset($_REQUEST['parco_id'])){
            $eta = 0;
            $elements = 0;
            $slq = 'SELECT data_nascita FROM animale WHERE id_specie ="' . $_REQUEST['parco_id'] . '"';
            $result = $connection->query($slq);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data_nascita = new DateTime($row['data_nascita']);
                    $data_oggi = new DateTime('00:00:00');
                    $diff = $data_oggi->diff($data_nascita);
                    $diff = $diff->format('%y');
                    $eta = $eta + $diff;
                    $elements++;
                }
                $media = $eta / $elements;
                echo "Età media: " . round($media, 1) . "\n";
                echo "Numero esemplari: " . $elements;
            }
        }
        ?>
        
    </body>
</html>
