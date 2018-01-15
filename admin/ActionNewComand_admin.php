 <?php 
include '../functions/connection.php'; 
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
 
session_start();
	if (!isset($_SESSION['LoginSession']) AND !isset ($_SESSION['PassSession'])) {
	   header("location: login_admin.php");
	   exit;
	}

	$var_nova_comanda = $_GET['new_comand']; 

	$sqlConfirmExistProduct = "SELECT * FROM tbl_comanda WHERE col_number_comanda = '$var_nova_comanda';"; 
	$resultConfirmExistProduct = mysql_query($sqlConfirmExistProduct, $conecta); 
	$num_rows_select = mysql_affected_rows();

		if ($num_rows_select > 0){
			echo '<script>alert("Essa Comanda já esta cadastrada!");</script>';
			echo '<script>window.location.replace("FormNewComand_admin.php");</script>';
		}else{
			$sqlInsertNewComand = "INSERT INTO tbl_comanda (col_number_comanda, comanda_is_used) VALUES ('$var_nova_comanda', 0);"; 
			$resultInsertNewComand = mysql_query($sqlInsertNewComand, $conecta); 
			$num_rows_InsertNewComand = mysql_affected_rows();
			
			if($num_rows_InsertNewComand  > 0){
				echo '<script>alert("Comanda cadastrada com sucesso!");</script>';
				echo '<script>window.location.replace("index_admin.php");</script>';	
			}else{
				echo '<script>alert("Erro. Tente novamente!");</script>';
			}
			
		}	
		
	mysql_close($conecta); 

echo ' <script>  javascript:window.history.forward(1);</script>';
?>