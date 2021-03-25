<?php

	$flag = 'GANESH{G3T_3XP3RT}';
	
	if(isset($_GET['admin']) == false) { 
		header('Location: ?admin=0');
	}

	echo "<!DOCTYPE html><html><head><meta charset='utf8'><title>Uma pagina de web </title>";
	echo "<style type='text/css'>#center { display: inline-block; }</style>";
	echo "</head><body><div style='text-align: center; width: 100%;'><div id='center'>";
	
	if($_GET['admin'] == 1) {
		echo "<h2> Bem vindo, admin! Sua flag é {$flag}</h2>";
	} else {
		echo "<h2> Você precisa estar logado como admin para ver esta página </h2>"; 		
	}
	echo "</div></div></body></html>";