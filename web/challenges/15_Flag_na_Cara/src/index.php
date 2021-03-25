<?php 
	error_reporting(E_ERROR | E_PARSE);
	
	$filename = $_GET['file'];
	if (!isset($filename)) {
		header("Location: ?file=WIP.txt"); 
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lies</title>
</head>
<body>
	<?php
		$file = fopen($filename, 'r');
		if ($file) {
			while (!feof($file)) {
				$line = fgets($file);
				echo $line;
			}
		} else { 
			echo "Error - Could not open file";
		}
		// GANESH{Fl4G_D3_ScHR0d1NG3r}
	?>
</body>
</html>
