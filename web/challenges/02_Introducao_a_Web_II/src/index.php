<?php
	
	$Flag = "GANESH{RhoY8fv9ZOFhQkTyI3WP}";
	
	if($_GET["logout"] === "true") {
		setcookie("admin", "", time() - 1000);
		echo 'Deslogado com sucesso! <a href="?" style="color: blue;">Continuar</a>';
		exit(0);
	}
	
	if(!isset($_COOKIE["admin"])) {
		setcookie("admin", "0");
		header("Location: ?");
		exit(0);
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login no Sistema</title>
</head>

<body>
	<?php
		if($_COOKIE["admin"] === "1") {
	?>
	<h1>Bem-vinde, admin! <a href="?logout=true" style="color: blue;">(sair)</a></h1>
	<p><?php echo $Flag; ?></p>
	<?php
		} else {
	?>
	<h1>Não autorizado</h1>
	<p>Desculpe, você não está autorizado a acessar essa página.</p>
	<?php
		}
	?>
</body>

</html>
