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
	
	<div class="titulo2" style="font-size:16px;">Cadastro de Comanda:</div>
	<label style="font-size:16px; margin-left:20px;" for="dados"> Insira as informações abaixo: </label><br><br>
	
			<form id="formulario" action="" method="POST">
				<label style="font-size:16px; margin-left:6px;" for="nova_comanda"> Número Comanda: </label> <input name="nova_comanda" id="nova_comanda" type="text" autocomplete="off" class="input_produto2"/>	<br>
				<input type="submit" style="margin-left:6px;" name="submit" value="Cadastrar Comanda" class="input_submit"> 
			</form>
';

// [ ### LÓGICA ### ] 
		if (isset($_POST['submit'])) {
			$nova_comanda = $_POST["nova_comanda"];  

			if ($nova_comanda == ''){
				echo '<script>alert("Atenção: Há campo vazio!");</script>';
			}else{
				header("location: ActionNewComand_admin.php?new_comand=$nova_comanda");
			}
		}
echo '
</div>
</body>
</html>
';
echo ' <script>  javascript:window.history.forward(1);</script>';

?>


