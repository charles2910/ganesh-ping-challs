<?php
	session_start();

	if(empty($_SESSION["nome"])){
		header("Location: index.php");
		echo "<center><h1>Página não encontrada!</h1></center>";
		exit();
	}
	if($_GET["logout"] == "1") {
		$_SESSION["nome"] = "";
		$_SESSION["nivel_usuario"] = "0";
		header("Location: index.php");
		exit();
	}
	if($_SESSION["nivel_usuario"] === "1") {
		header("Location: inicio.php");
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
	<h1>Logado</h1>
	<h2>Seja bem vindo, <?php echo $nome;?></h2> <a href="?logout=1">(logout)</a>
	<h4>Você não tem acesso de administrador ao nível 1.</h4>
</body>
</html>

