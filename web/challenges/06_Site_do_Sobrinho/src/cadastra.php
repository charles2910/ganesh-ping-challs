<?php

	include "conexao.php" ;
	session_start();

	$nome  = $_POST['nome'];
	$senha = $_POST['senha'];
	$strx  = $senha;
	$senhaencriptada = base64_encode($strx);
	//SQL que faz a inserção no banco dos dados recebidos!
 			 
    $sql = mysqli_query($conexao, "INSERT INTO usuarios (nome, senha)VALUES ('$nome', '$senhaencriptada')") or die ('Erro ao inserir os dados'.mysqli_error($conexao));
	$_SESSION["nome"]          = $nome;
	$_SESSION["nivel_usuario"] = "0";
	header("Location: logado.php");
	
?>
<html>
	<head> 
		<title>Redirecionando</title>
			<script type="text/javascript"> alert("Cadastrado com sucesso!"); 
			window.location="applications.php"; </script> 
	</head>
<body>
</body> 
</html>

