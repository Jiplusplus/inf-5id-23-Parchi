<!DOCTYPE html>
<html>
    <head>
        <title>Parchi</title>
    </head>
    <body>
    <script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("txtHint").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","document.URL&specie=+"+str,true);
  xmlhttp.send();
}
</script>

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
            <select name="specie_id" onchange=showUser(this.value)>
                <?php
                if (isset($_REQUEST['parco_id'])) {
                $ip = '127.0.0.1';
                $username = 'root';
                $pwd = '';
                $database = 'parchi';
                $connection = new mysqli($ip, $username, $pwd, $database);

                if ($connection->connect_error) {
                    die('C\'è stato un errore: ' . $connection->connect_error);
                }

                echo '<option>Specie</option>';
                $sql = 'SELECT DISTINCT s.nome FROM animale a INNER JOIN parco p ON a.id_parco = '.$_REQUEST['parco_id'].' INNER JOIN specie s ON s.id_specie = a.id_specie;';
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['nome'] . '">' . $row['nome'] . '</option>';
                    }
                }
                }
            ?>
                
            </select>
        </form>

        <form method="GET" action="index.php">
            <select name="animale_id">
                <?php
                $message=$_SERVER['QUERY_STRING'];
                $nome_animale=null;
                echo $message;
                if(str_contains($message,'specie')==true){
                   
                    $nome_animale=explode('=',$message)[3];
                     echo $nome_animale;
                    
                }
                if ( $nome_animale!=null){


                    $ip = '127.0.0.1';
                    $username = 'root';
                    $pwd = '';
                    $database = 'parchi';
                    $connection = new mysqli($ip, $username, $pwd, $database);
    
                    if ($connection->connect_error) {
                        die('C\'è stato un errore: ' . $connection->connect_error);
                    }
    
                    // echo 'Database collegato';
                    $sql = 'SELECT a.id_animale, a.data_nascita, a.sesso, a.stato_salute, s.nome FROM animale a INNER JOIN parco p ON a.id_parco = '.$_REQUEST['parco_id'].' INNER JOIN specie s ON s.id_specie = a.id_specie';
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
        <div id="txtHint"></div>
    </body>
</html>
