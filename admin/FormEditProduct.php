 <?php 
 
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

$product = $_GET['product'];
$id_product = $_GET['id_product'];
$cod_product = $_GET['cod_product'];
$preco = $_GET['preco'];
$_SESSION["ss_IdProduto"] = $id_product;

// [ ### CABEÇALHO HTML ### ]
	echo '
			<div class="titulo2"><center><br>Área Administrativa</center></div><br>
						
			<div id="menu_admin">
				<table border="0">
					<tr>
						<th> <a href="index_admin.php" class="link_admin" style="padding-left:10px; padding-right:10px; font-size:18px;"> Inicio Administrativo</a><br></th>	
						<th> <a href="logout_admin.php" class="link_admin" style="padding-left:10px; padding-right:10px; font-size:18px;"> Sair</a><br></th>	
					<tr>
				</table>	
			</div>
			
	<br>

	<div class="titulo2" style="font-size:16px;">Edição de Produto:</div>
	<label style="font-size:16px; margin-left:20px;" for="dados"> Insira as informações abaixo: </label><br><br><br>

		<form id="formulario" action="" method="POST">
			<label style="font-size:16px; margin-left:6px;" for="produto"> Produto: <input name="new_name_product" id="new_name_product" type="text" autocomplete="off" value="'.$product.'"class="input_produto2"/><br>	
			<label style="font-size:16px; margin-left:9px;" for="cod_produto"> Código: <input name="new_cod_product" id="new_cod_product" type="text" autocomplete="off" value="'.$cod_product.'"class="input_produto2"/><br>
			<label style="font-size:16px; margin-left:20px;" for="preco"> Preço: <input name="new_preco_product" id="new_preco_product" type="text" autocomplete="off" value="'.$preco.'"class="input_produto2"/><br>
			<input type="submit" name="submit" value="Salvar Edição"  class="input_submit"> 
		</form>
	';	

// [ ### LÓGICA ### ] 

		if (isset($_POST['submit'])) {
			$new_name_product = $_POST["new_name_product"];  
			$new_cod_product = $_POST["new_cod_product"]; 
			$new_preco_product = $_POST["new_preco_product"]; 
			
			if ($new_name_product == '' OR $new_preco_product == '' OR $new_cod_product == ''){
				echo '<script>alert("Atenção: Há campo vazio!");</script>';
			}else{
				header("location: ActionEditProduct.php?product=$new_name_product&preco=$new_preco_product&id_product=$id_product&cod_product=$new_cod_product");
			}
		}
echo '
</div>
</body>
</html>
';

echo ' <script>  javascript:window.history.forward(1);</script>';
?>