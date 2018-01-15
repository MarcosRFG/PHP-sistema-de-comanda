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

	$var_novo_produto = $_GET['produto']; 
	$novo_cod_produto = $_GET['cod_produto']; 
	$var_novo_preco = $_GET['preco']; 

	$sqlConfirmExistProduct = "SELECT * FROM tbl_produto WHERE col_nome = '$var_novo_produto' OR col_cod_produto = '$novo_cod_produto';"; 
	$resultConfirmExistProduct = mysql_query($sqlConfirmExistProduct, $conecta); 
	$num_rows_select = mysql_affected_rows();

		if ($num_rows_select > 0){
			echo '<script>alert("Um produto com esse NOME ou CÓDIGO já esta cadastrado!");</script>';
			echo '<script>window.location.replace("FormNewProduct_admin.php");</script>';
		}else{
			$sqlInsertNewProduct = "INSERT INTO tbl_produto (col_nome, col_preco, col_cod_produto) VALUES ('$var_novo_produto', '$var_novo_preco', '$novo_cod_produto');"; 
			$resultInsertNewProduct = mysql_query($sqlInsertNewProduct, $conecta); 
			$num_rows_InsertNewProduct = mysql_affected_rows();
			
			if($num_rows_InsertNewProduct  > 0){
				echo '<script>alert("Produto cadastrado!");</script>';
				echo '<script>window.location.replace("index_admin.php");</script>';	
			}else{
				echo '<script>alert("Erro. Tente novamente!");</script>';
			}
			
		}	
		
	mysql_close($conecta); 

echo ' <script>  javascript:window.history.forward(1);</script>';
?>