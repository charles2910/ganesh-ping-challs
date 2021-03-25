<?php
	require('conexao.php');
	session_start();

	$nome = $_POST['nome'];
	$senha = $_POST['senha'];
	if(!empty($_POST)){
		$error = '';
		
		$senhaencriptada = base64_encode($senha);

		$result = mysqli_query ($conexao, "SELECT * FROM usuarios WHERE nome = '" . $nome . "' AND senha = '$senhaencriptada' ");
		#echo $result;
		#$result=$mysqli->query($sql);
		$rows = $result->num_rows;

		if($rows > 0){
			$row = $result->fetch_assoc();
			$_SESSION['nome'] = $row['nome'];
			$_SESSION['senha'] = $row['senha'];
			$_SESSION['nivel_usuario'] = $row['nivel_usuario'];

			if($_SESSION['nivel_usuario'] == 1){
				header("Location: inicio.php");
			} else {
				header("Location: logado.php");
			}
		}
		else{
			echo 'erro: nome e/ou senha incorretos? <a href="index.php" style="color: blue;">Tentar de novo</a>';
		}
	} else {
		;
	}
	
	if($_POST["debug"] === "1") {
		echo "<br><br>SELECT * FROM usuarios WHERE nome = '" . $nome . "' AND senha = '$senhaencriptada'" . PHP_EOL;
	}
