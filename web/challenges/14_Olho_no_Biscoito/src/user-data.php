<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$servername = "localhost";
$username   = "user_chall_14";
$password   = "6ff235c177fe5b3d";
$dbname     = "db_chall_14";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Pessoa WHERE Pessoa.id='" . $_COOKIE['id'] . "' LIMIT 1";
$result = $conn->query($sql);

$currRow = 1;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

    	echo '<h3>Nome:</h3> ' . $row['nome'];
    	echo '<h3>Descrição:</h3> ' . $row['description'];

	    if ($currRow++ != $result->num_rows) echo ',';
    }
} else {
    echo "0 results";
}

