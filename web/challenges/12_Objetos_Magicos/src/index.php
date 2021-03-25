<?php
// uncomment ;extension=mysqli in /etc/php/7.2/apache2/php.ini 

include 'connect.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$sql = new SQL();
$sql->connect();
$sql->query = "SELECT username FROM users WHERE id=";


if (isset ($_COOKIE['h4ck_m3'])) {
    $sess_data = unserialize(base64_decode($_COOKIE['h4ck_m3']));
    try {
        if (is_array($sess_data) && $sess_data['ip'] != $_SERVER['REMOTE_ADDR']) {
            die("We are secure, you can't hack us!!");
        }
    } 
    catch (Exception $e) {
        echo $e;
    }
} 
else {
    $cookie = base64_encode(serialize(array( 'ip' => $_SERVER['REMOTE_ADDR']))) ;
    setcookie ('h4ck_m3', $cookie, time () + (86400 * 30));
}

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    try {
        $sql->query .= $_REQUEST['id'];
    } 
    catch (Exception $e) {
        echo 'Invalid query';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
        <title> Cereal is Nation </title>
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: black;
                color: white;
                font-size: 18px;
            }

            div {
                margin: 30px auto;
                border: 1px solid #60fcb6;
                border-radius: 10px;
                width: 800px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 10px;
                background-color: rgba(33, 62, 46, 0.6);
            }

            a {
                color: #60fcb6;
                font-weight: bold;
            }

            h1 {
                color: #60fcb6;
                margin-bottom: 0px;
                margin-top: 5px;
            }

            h2 {
                color: #60fcb6;
                text-align: center;
            }

            .user {
                margin: auto;
                padding: 5px;
                width: 600px;
                border: 1px solid white;
                border-radius: 3px;
            }
        </style>
</head>
    <body>
        <div>
            <h1> Bem-vindo! </h1>
            <p>
                Após alguns problemas com requisições, nós fizemos algumas alterações no nosso sistema para obtermos mais segurança!<br>
                Além disso, nossos desenvolvedores amam POO agora. <br>
                Você pode obter os códigos da página <a href="source1.txt" target="_blank">aqui</a> e <a href="source2.txt" target="_blank">aqui</a>.
            </p>
            <form method='post' action="?">
                <input name='id' class='form-control' type='text' placeholder='Id do usuário'>
                <input name="submit" value='Go' type='submit'>
            </form>
        </div>
    </body>
</html>