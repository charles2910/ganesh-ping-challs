<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 'On');

    include("jwt/JWT.php");
    include("jwt/SignatureInvalidException.php");
    use \Firebase\JWT\JWT;

    $key = "ilovepico";
    $flag = 'picoCTF{jawt_was_just_what_you_thought_6ba7694bcc36bdd4fdaf010b2ec1c2c3}';

   // Para testar: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiYWRtaW4iLCJpYXQiOjE1NzA5Njg2NDB9.77pnOGlEdwL7MtxHHS6ZKYD5z1O8w_-SFnzPGyNo9t8  

    // Caso o usuário não possua nenhuma jwt e envie um usuário cria o cookie.
    if(isset($_POST['user']) && !isset($_COOKIE['jwt']) && !empty(trim($_POST['user'])) && trim($_POST['user']) !== "admin"){
        $payload = array( "user" => $_POST['user']  );
        $jwt = JWT::encode($payload, $key);
        
        setcookie('jwt', $jwt); 
        $_COOKIE['jwt'] = $jwt;
    } 

    $jwt_decoded = NULL;

    try {
        $jwt_decoded = (isset($_COOKIE['jwt'])) ? JWT::decode($_COOKIE['jwt'], $key, array('HS256')) : NULL;
        $jwt_decoded = (array) $jwt_decoded;
    } catch(Exception $e){
        // Catch mudinho
    }

    // Se o jwt é inválido...
    if(isset($_COOKIE) && is_null($jwt_decoded)){
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
        <title>500 Internal Server Error</title>
        <h1>Internal Server Error</h1>
        <p>The server encountered an internal error and was unable to complete your request. Either the server is overloaded or there is an error in the application.</p>';
        exit(0);
    }

?>
<!doctype html>
<html>
<title> JaWT - an online scratchpad </title>
<link rel="stylesheet" href="css/stylesheet.css">
<body>
    <header><h1>JaWT</h1> <br> <i><small>powered by <a href="https://jwt.io/">JWT</a></small></i></header>
    
    <div id="main">
    
        <article>
            <h1>Welcome to JaWT!</h1>
            <p>JaWT is an online scratchpad, where you can "jot" down whatever you'd like! Consider it a notebook for your thoughts. <b style="color:blue "> JaWT works best in Google Chrome for some reason. </b></p>

            <?php if(!isset($_COOKIE['jwt']) && !isset($_POST['user'])): ?>
                <p>You will need to log in to access the JaWT scratchpad. You can use any name, other than <code>admin</code>... because the <code>admin</code> user gets a special scratchpad!</p>
                <br>
                <form action="#" method="POST">
                    <input type="text" name="user" id="name">
                </form>

            <?php elseif(!isset($_COOKIE['jwt']) && isset($_POST['user']) &&  $_POST['user'] === 'admin'): ?>
                <br>
                <p style="color:red">YOU CANNOT LOGIN AS THE ADMIN! HE IS SPECIAL AND YOU ARE NOT.</p>
				<p>You will need to log in to access the JaWT scratchpad. You can use any name, other than <code>admin</code>... because the <code>admin</code> user gets a special scratchpad!</p>
				<br>
                <form action="#" method="POST">
                    <input type="text" name="user" id="name">
                </form>
            
            <?php elseif( isset($_COOKIE['jwt']) && isset($jwt_decoded['user'])): ?>
                
					<h2> Hello <?php echo $jwt_decoded['user']; ?>!</h2>
					<p>Here is your JaWT scratchpad!</p>
					<textarea style="margin: 0 auto; display: block;">
                        <?php echo ($jwt_decoded['user'] ==='admin' ? $flag : '' ); ?>
                    </textarea>
					<br>
					<a href="logout.php"><input style="width:100px" type="submit" value="Logout"></a>

            <?php endif; ?>

            <?php // if(!is_null($jwt_decoded)) {  print_r($jwt_decoded); } ?>

            <br>
            <h2> Register with your name! </h2>
            <p>You can use your name as a log in, because that's quick and easy to remember! If you don't like your name, use a short and cool one like <a href="https://github.com/magnumripper/JohnTheRipper">John</a>!</p>
        </article>
        <nav></nav>
        <aside></aside>
            
    </div>
    <script> window.onload = function() { document.getElementById("name").focus(); }; </script>
</body> 
</html>