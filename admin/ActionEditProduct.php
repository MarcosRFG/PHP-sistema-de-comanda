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

//	$id_produto = $_SESSION["ss_IdProduto"];
	$produto_edit = $_GET['product']; 
	$cod_product_edit = $_GET['cod_product']; 
	$preco_edit = $_GET['preco']; 
	$id_product = $_GET['id_product']; 
	
	$sqlConfirmExistProduct = "SELECT * FROM  tbl_produto WHERE col_nome = '$produto_edit' AND col_id <> '$id_product';"; 
	$resultConfirmExistProduct = mysql_query($sqlConfirmExistProduct, $conecta);
	$num_rows_select = mysql_affected_rows();

	$sqlConfirmExistCODProduct = "SELECT * FROM  tbl_produto WHERE col_cod_produto = '$cod_product_edit' AND col_id <> '$id_product';"; 
	$resultConfirmExistCODProduct = mysql_query($sqlConfirmExistCODProduct, $conecta);
	$num_rows_ConfirmExistCODProduct = mysql_affected_rows();
	
		if($num_rows_select > 0 OR $num_rows_ConfirmExistCODProduct > 0){
			echo '<script>alert("Um produto com esse NOME ou CÓDIGO ja existe!");</script>';
			echo '<script>window.location.replace("index_admin.php");</script>';
		}else{
			$sqlUpdateProduct = "UPDATE  tbl_produto SET col_nome = '$produto_edit', col_preco = '$preco_edit', col_cod_produto = '$cod_product_edit' WHERE col_id = '$id_product' ;"; 
			$resultUpdateProduct = mysql_query($sqlUpdateProduct, $conecta); 

			$num_rows_update = mysql_affected_rows();

				if ($num_rows_update > 0){
					echo '<script>alert("Produto atualizado!");</script>';
				echo '<script>window.location.replace("index_admin.php");</script>';
								
				}else{
				 echo '<script>window.location.replace("index_admin.php");</script>';		
				}
		}
		
echo '
<br>
<a href="index_admin.php">Inicio Administrativo</a>
<a href="logout_admin.php"> Logout</a><br>
';

mysql_close($conecta);

echo '
<br>
<a href="index_admin.php">Inicio</a>
';

echo ' <script>  javascript:window.history.forward(1);</script>';
?>

