<?php
    session_start();

	echo '
	<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<title>Inicio | Comanda </title>
		<meta charset="ISO-8859-1"/>
	</head>
	<body>
	<div id="geral">
'; 

    unset ($_SESSION['LoginSession']);
    unset ($_SESSION['PassSession']);
    echo '<script>window.location.replace("../index.php");</script>';
	
echo '
</div>
</body>
</html>
';
?>