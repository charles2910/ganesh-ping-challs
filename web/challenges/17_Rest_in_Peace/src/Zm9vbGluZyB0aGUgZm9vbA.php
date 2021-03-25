<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "<h1>Zugriff verweigert.</h1>"; // Acesso negado
    echo "<h3>Wenn der Fehler weiterhin besteht, lesen Sie die <a href='documentation.yaml'>API Dokumentation.</a></h3>";
    exit(0);
}


$mysqli = new mysqli('localhost', 'user_chall_20', 'F6wVLZ=&J9pDDdXV', 'db_chall_20');
if (mysqli_connect_errno()) {
    echo "<h1>Ein Fehler ist aufgetreten.</h1>"; // Um erro ocorreu
    exit(0);
} 

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['f']) && isset($_POST['v'])){
    
    $stmt = $mysqli->prepare("INSERT INTO stolendata VALUES (?, ?, ?)");
    $stmt->bind_param('dss', $_POST['aaa'], $_POST['f'], $_POST['v']);
    $stmt->execute();
    echo " $stmt->affected_rows Row inserted.";
    
} else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['aaa']) && is_numeric($_GET['aaa']) ) {

    $stmt = $mysqli->prepare("SELECT * FROM stolendata WHERE id = ?");
    $stmt->bind_param('d', $_GET['aaa']);
    $stmt->execute();

    $result = $stmt->get_result();
    echo "<h1>Results: $result->num_rows</h1>";
    echo "<table>";
    while ($row = $result->fetch_array(MYSQLI_NUM)){
        echo "<tr>";
        foreach ($row as $r){
            print "<td>$r</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

} else if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $stmt = $mysqli->prepare("SELECT * FROM stolendata ORDER BY id DESC LIMIT 20");
    $stmt->execute();

    $result = $stmt->get_result();
    echo "<h1>Results: $result->num_rows</h1>";
    echo "<table>";
    while ($row = $result->fetch_array(MYSQLI_NUM)){
        echo "<tr>";
        foreach ($row as $r){
            print "<td>$r</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

}

$mysqli->close();
