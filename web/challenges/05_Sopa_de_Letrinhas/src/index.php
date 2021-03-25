<?php

set_time_limit(5); /* ESSENCIAL: pro caso de algum processo (tipo cat, vim, ...) travar o código, só isso aqui é capaz de encerrar ele. */

$query = trim($_GET["q"]);
$results = [ ];

if(!empty($query)) {
	# Parte de verificação (pra ter certeza que o cara não vai usar um "reboot" ou "rm -Rf /".) */
	$queryC = trim(preg_replace("/^[a-zA-Z0-9\/\:\s\.\-\_]*/", "", $query));
	while(preg_match("/^\s*[\|\&\<\;]+\s*(ls|cat|cd|file|cut|grep)\s*[a-zA-Z0-9\/\:\s\.\-\_]*/", $queryC) == 1) {
		$queryC = trim(preg_replace("/^\s*[\|\&\<\;]+\s*(ls|cat|cd|file|cut|grep)\s*[a-zA-Z0-9\/\:\s\.\-\_]*/", "", $queryC));
	}
	$queryC = trim($queryC);
	# Fim da verificação
	if(empty($queryC)) {
		exec("cat list.txt | grep " . $query, $results);
	}
}

?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,user-scalable=no">
	<meta name="robots" content="noindex,nofollow,noarchive,noodp,noydir">
	<title>Busca Dicionário</title>
	<style type="text/css">
		#info {
			margin-bottom: 15px;
		}
		#form {
			margin-bottom: 30px;
		}
		#form input {
			margin-right: 10px;
		}
		#results {
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<div id="info">
		<p>Digite um termo para buscar em nosso dicionário online...</p>
	</div>
	<div id="form">
		<form action="?" method="get">
			<input type="text" name="q" placeholder="(busca)" value="<?php echo htmlentities($query, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"); ?>" required="required" autofocus="autofocus">
			<button type="submit">&#x1f50d;</button> <!-- O código "&#x1f50d;" é o emoji da Lupa em UTF-8. Se não funcionar, substitua por "buscar" ou qualquer coisa. -->
		</form>
	</div>
	<?php
		if(!empty($query)) {
			echo '<div id="results">';
			echo '<h2>' . count($results) . ' resultados encontrados:</h2>';
			echo '<pre>';
			foreach($results as $line) {
				echo htmlentities($line, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") . PHP_EOL;
			}
			echo '</pre>';
			echo '</div>';
		}
	?>
</body>

</html>
