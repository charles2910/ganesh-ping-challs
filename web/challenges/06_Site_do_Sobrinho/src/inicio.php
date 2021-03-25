<?php
	session_start();

	if(empty($_SESSION["nome"])){
		header("Location: index.php");
		echo "<center><h1>Página não encontrada!</h1></center>";
		exit();
	}
	if($_SESSION["nivel_usuario"] !== "1") {
		header("Location: logado.php");
		echo "<center><h1>Página não encontrada!</h1></center>";
		exit();
	}
	$nome=$_SESSION["nome"];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de testes </title>
</head>

<body>
        
	<h1>Logado com nível de acesso 1</h1>
	<h2>Seja bem vindo, <?php echo $nome;?></h2> <a href="logado.php?logout=1">(logout)</a>

	<h4>GANESH{PTjxybVpBkjNMBwDooT5}</h4>
</body>
</html>

