<?php
    function clean_hash($hash) {
        return preg_replace("/[^0-9a-f]/", "", $hash);
    }

    function myhash($str) {
        return clean_hash(md5(md5($str) . "SALT"));
    }

    $admin_user = "pr0_@dm1n";
    $admin_pw = clean_hash("0e408306536730731920197920342119");
?>
<html>
    <head>
        <title>Secure Login Page Pro Version v1.3.37 </title>
        <style>
            body {
                margin: 0;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: rgb(0, 0, 0);
                color: white;
            }
            
            h2{
                text-align: center;
                color: #017572;
            }

            form {
                display: flex;
                flex-direction: column;
                width: 400px;
                margin: auto;
            }

            input, button {
                margin: 5px;    
            }
        </style>
    </head>
    <body>
        <h2> Entre com seu nome de usuário e senha </h2> 
        <div>
            
            <?php
                $msg = '';
                
                if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
                    if ($_POST['username'] == $admin_user && myhash($_POST['password']) == $admin_pw) {
                        $_SESSION['valid'] = true;
                        $_SESSION['timeout'] = time();
                        $_SESSION['username'] = $admin_user;
                    
                        $msg = 'Login realizado com sucesso! Ganesh{PHP_C0mp@r3_1s_W3!rd}';
                    }
                    else {
                        $msg = 'Nome de usuário ou senha incorreta';
                    }
                }
            ?>
        </div>
        
        <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
            <h4> <?php echo $msg; ?> </h4>
            <input type = "text" name = "username" placeholder = "Username" required autofocus>
            <input type = "password" name = "password" placeholder = "Password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login"> Login </button>
        </form>
    </body>
</html>