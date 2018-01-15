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

	$id_product = $_GET['id_product'];
	$_SESSION["ss_IdProduto"] = $id_product;

	$sqlDeleteProduct = "DELETE FROM tbl_produto WHERE col_id = $id_product ;"; 
	$resultDeleteProduct = mysql_query($sqlDeleteProduct, $conecta); 
	
	$num_rows_delete = mysql_affected_rows();

		if($num_rows_delete > 0){
			echo '<script>alert("Produto Apagado!");</script>';
			echo '<script>window.location.replace("index_admin.php");</script>';		
		}else{	
			echo '<script>window.location.replace("index_admin.php");</script>';
		}
	
mysql_close($conecta); 

echo '
</div>
</body>
</html>
';

?>