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

	// [ ### VERIFICA CAMPOS DE LOGIN E SENHA ### ]
	if (isset($_POST['submit'])) { 
		$login = $_POST["login"];  
		$pass = $_POST["pass"]; 

		if ($login == '' OR $pass == ''){
			echo '<script>alert("Atenção: campos vazios");</script>';
		}else{		
			$sqlVerifiqAdm = "SELECT * FROM tbl_admin WHERE col_login = '$login' AND col_pass = '$pass'"; 
			$resultVerifiqAdm = mysql_query($sqlVerifiqAdm, $conecta); 
			$num_rows_select = mysql_affected_rows();
			
			if ($num_rows_select > 0){
				$_SESSION['LoginSession'] = $login;
				$_SESSION['PassSession'] = $pass;
				echo '<script>window.location.replace("index_admin.php");</script>';		
			}else{
				echo '<script>alert("Atenção: usuário invalido. Tente novamente!");</script>';
			}		
		}
	}
	
mysql_close($conecta); 

	// [ ### HTML ### ] 
	echo '
		<div id="div_login">
			<div id="link_admin" class="link_admin"> <a href="../index.php" class="link_admin">Área de Comanda </a> </div>
			<center>
			<form method="POST" action=""><br>
				<label style="font-size:16px;" for="login"> Login: </label> <input name="login" id="login" type="text" class="input_produto2"/>	<br>
				<label style="font-size:16px;" for="senha"> Senha: </label> <input name="pass" id="pass" type="password" class="input_produto2"/> <br>		
				<input type="submit" name="submit" value="Logar" class="input_submit"> 
			</form>
			</center>
		</div>
</div>
</body>
</html>
';
?>