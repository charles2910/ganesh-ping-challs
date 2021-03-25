<?php

const SAME_USER_PASS_ERROR = FALSE; /* A mensagem de erro deve ser a mesma para usuário incorreto e/ou senha incorreta (TRUE) ou não (FALSE)? */
const HTTP_STATUS_ON_ERROR = FALSE; /* Se der erro de login, enviar '200 OK' pro navegador (FALSE) ou 403 Forbidden (TRUE). */
const NONCE = FALSE; /* Ativar número único de sessão para cada tentativa de login? (dificulta muito mais o desafio do chall!). */

const USERNAME = "admin"; /* Usuário correto. */
const PASSWORD = "iloveyou"; /* Senha correta. */
const FLAG = "GANESH{eZTBZamJNd8DIJyeAy5w}"; /* Flag. */

$error = false;

session_start();

function getNonce() {
	$limit = 1000;
	$newNonce = uniqid(time() . "_", true);
	if(empty($_SESSION["nonce"]) || count($_SESSION["nonce"]) >= 1000) {
		$_SESSION["nonce"] = [ ];
	}
	$_SESSION["nonce"][$newNonce] = $limit;
	return $newNonce;
}

function checkNonce($nonce) {
	if(empty($nonce) || gettype($nonce) !== "string") {
		return FALSE;
	}
	if(empty($_SESSION["nonce"])) {
		return FALSE;
	}

	if(empty($_SESSION["nonce"][$nonce])) {
		return FALSE;
	}

	$_SESSION["nonce"][$nonce]--;
	if($_SESSION["nonce"][$nonce] < 1) {
		unset($_SESSION["nonce"][$nonce]);
	}

	return TRUE;
}

$showForm = true;
if($_GET["action"] == "login") {
	if(NONCE && !checkNonce($_POST["nonce"])) {
		$error = 'Algo de errado aconteceu (XSRF/CSRF nonce). Tente novamente.';
	} else if(empty($_POST["username"]) || empty($_POST["password"])) {
		$error = 'Digite o usuário e a senha.';
	} else if($_POST["username"] !== USERNAME) {
		if(SAME_USER_PASS_ERROR) {
			$error = 'Usuário e/ou senha incorreto (s).';
		} else {
			$error = 'Usuário não encontrado.';
		}
	} else if($_POST["password"] !== PASSWORD) {
		if(SAME_USER_PASS_ERROR) {
			$error = 'Usuário e/ou senha incorreto (s).';
		} else {
			$error = 'Senha do usuário incorreta.';
		}
	}
	if($error) {
		if(HTTP_STATUS_ON_ERROR) {
			http_response_code(403);
		}
	} else {
		$showForm = false;
	}
}

$newNonce = getNonce();


?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,user-scalable=no">
	<meta name="robots" content="noindex,nofollow,noarchive,noodp,noydir">
	<link rel="icon" type="image/png" sizes="16x16 32x32 64x64" href="resources/favicon64.png">
	<link rel="icon" type="image/png" sizes="128x128 256x256 512x512" href="resources/favicon.png">
	<title>Ganesh Web App</title>
	<style type="text/css">
		@media not all and (min-width: 360px) and (min-height: 360px){
			#main-noscreen {
				display: block;
			}
			#main {
				display: none;
			}
		}
		@media all and (min-width: 360px) and (min-height: 360px){
			#main-noscreen {
				display: none;
			}
			#main {
				display: block;
			}
		}
		body {
			display: block;
			background-color: rgb(0, 0, 0);
			color: rgb(0, 0, 0);
		}
		#main {
			font-size: 16px;
			margin: 100px auto;
			width: 315px;
			padding: 15px;
			border-radius: 10px;
			background-color: rgb(255, 255, 255);
			box-shadow: 0px 0px 20px 10px rgb(255, 255, 255);
			overflow: hidden;
		}
		#header {
			display: block;
			margin-bottom: 25px;
		}
		#header a {
			display: block;
			width: 250px;
			height: 60px;
			margin: 0px auto;
			border: 0px;
			text-decoration: none;
			background-image: url("resources/logoName.png");
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center center;
		}
		#loginInfo {
			display: block;
			text-align: justify;
			margin-bottom: 25px;
		}
		#loginError {
			display: block;
			color: rgb(255, 0, 0);
			text-align: center;
			margin-bottom: 25px;
		}
		#loginError a {
			color: rgb(255, 0, 0);
		}
		#loginForm {
			display: block;
			margin-bottom: 30px;
		}
		#loginForm .field {
			display: block;
			width: 90%;
			margin-top: 0px;
			margin-left: auto;
			margin-bottom: 5px;
			margin-right: auto;
			vertical-align: middle;
		}
		#loginForm .field.text input {
			display: block;
			width: 100%;
		}
		#loginForm .field button {
			display: inline-block;
			margin: 0px 2px;
			padding: 15px;
		}
		#loginForm .field button:first-child {
			margin-left: 0px;
		}
		#loginForm .field button:last-child {
			margin-right: 0px;
		}
		#loginForm .field button.icon {
			display: inline-block;
			width: 30px;
			height: 30px;
			padding: 8px;
			background-image: url("resources/loginIcons.png");
			background-repeat: no-repeat;
			background-size: 26px auto;
		}
		#loginForm .field a {
			display: inline-block;
			color: rgb(0, 0, 0);
			transition: color 0.25s;
		}
		#loginForm .field a:hover {
			color: rgb(58, 233, 69);
		}
		#loginButtons {
			display: block;
			margin-bottom: 25px;
			text-align: center;
		}
		#loginButtons a {
			display: inline-block;
			margin: 0px auto;
			color: rgb(255, 255, 255);
			text-transform: uppercase;
			text-decoration: none;
			text-align: center;
			padding: 10px 40px 10px 10px;
			background-color: rgb(255, 152, 0);
			background-image: url("resources/externalIcon.png");
			background-size: 25px 25px;
			background-repeat: no-repeat;
			background-position: right 10px center;
			transition: box-shadow 0.25s;
			box-shadow: 3px 3px 4px 0px rgb(0, 0, 0);
		}
		#loginButtons a:hover {
			box-shadow: 3px 3px 10px 0px rgb(0, 0, 0);
		}
		#footer {
			display: block;
			font-size: 0.75em;
			text-align: justify;
		}
		#footer .center {
			text-align: center;
		}
		#footer a {
			color: rgb(0, 0, 0);
			transition: color 0.25s;
		}
		#footer a:hover {
			color: rgb(58, 233, 69);
		}
		#main-noscreen {
			margin: 3px;
			color: rgb(255, 255, 255);
			text-align: justify;
		}
	</style>
</head>

<body>
	<div id="main">
		<div id="header">
			<a href="?"></a>
		</div>
		<?php
			if($showForm === true) {
				echo '<div id="loginInfo"><p>Esta é uma área restrita aos membros do Ganesh. Faça login com suas credenciais do Ganesh Web App.</p></div>';
				if($error) {
					echo '<div id="loginError"><p>' . $error . '</p></div>';
				}
			}
		?>
		<div id="loginForm">
			<?php
				if($showForm === true) {
			?>
				<form action="?action=login" method="post">
					<?php
						if(NONCE === TRUE) {
							echo '<input type="hidden" name="nonce" value="' . $newNonce . '">';
						}
					?>
					<div class="field text">
						<input type="text" name="username" placeholder="Nome de usuário" required="required" autofocus="autofocus">
					</div>
					<div class="field text">
						<input type="password" name="password" placeholder="Senha" required="required">
					</div>
					<div class="field">
						<button type="submit">Entrar</button>
					</div>
				</form>
			<?php
				} else {
			?>
				<div class="field">
					<p>Bem-vindo <?php echo USERNAME; ?>!</p>
					<p><?php echo FLAG; ?></p>
				</div>
			<?php
				}
			?>
		</div>
		<div id="footer">
			<p class="center"><a href="terms.html">Termos de Uso</a> - <a href="terms.html#privacy">Política de Privacidade</a> - <a href="terms.html#security">Política de Segurança</a></p>
		</div>
	</div>
	<div id="main-noscreen">
		<span>Sua tela é muito pequena para visualizar esta página da web.</span>
	</div>
</body>

</html>
