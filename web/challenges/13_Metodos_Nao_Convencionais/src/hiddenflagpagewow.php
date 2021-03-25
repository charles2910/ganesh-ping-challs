<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Allow: POST, OPTIONS");
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h1> Ganesh{tRu3_h4Ck3R_M@n} </h1>";
}
?>

