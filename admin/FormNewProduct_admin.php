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
	
	<div class="titulo2" style="font-size:16px;">Cadastro de Produto:</div>
	<label style="font-size:16px; margin-left:20px;" for="dados"> Insira as informações abaixo: </label><br><br>
	
			<form id="formulario" action="" method="POST">
				<label style="font-size:16px; margin-left:6px;" for="produto"> Produto: </label> <input name="novo_produto" id="novo_produto" type="text" autocomplete="off" class="input_produto2"/>	<br>
				<label style="font-size:16px; margin-left:09px;" for="cod_produto"> Código: </label> <input name="novo_cod_produto" id="novo_cod_produto" type="text" autocomplete="off" class="input_produto2"/>	<br>
				<label style="font-size:16px; margin-left:20px;" for="preco"> Preço: </label> <input name="novo_preco" id="novo_preco" type="text" autocomplete="off" class="input_produto2"/>	<br><br>
				<input type="submit" style="margin-left:6px;" name="submit" value="Cadastrar Produto" class="input_submit"> 
			</form>
			<label style="font-size:14px; margin-left:20px;" for="obs"><br> Exemplos de formato de cadastro de preço:  <br> 
			10.50 <br> 20.00<br>Obs.: Utilize "." (ponto) antes dos centavos, conforme exemplos acima. </label>
';

// [ ### LÓGICA ### ] 
		if (isset($_POST['submit'])) {
			$novo_produto = $_POST["novo_produto"];  
			$novo_cod_produto = $_POST["novo_cod_produto"]; 
			$novo_preco = $_POST["novo_preco"]; 

			if ($novo_produto == '' OR $novo_preco == '' OR $novo_cod_produto == ''){
				echo '<script>alert("Atenção: Há campo vazio!");</script>';
			}else{
				header("location: ActionNewProduct_admin.php?produto=$novo_produto&cod_produto=$novo_cod_produto&preco=$novo_preco");
			}
		}
echo '
</div>
</body>
</html>
';
echo ' <script>  javascript:window.history.forward(1);</script>';

?>


