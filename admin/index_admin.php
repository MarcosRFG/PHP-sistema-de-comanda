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
	// sessão de logado...
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
						<th> <a href="FormNewProduct_admin.php" class="link_admin" style="padding-left:10px; padding-right:10px; font-size:18px;"> Cadastrar Produto</a><br></th>	
						<th> <a href="FormNewComand_admin.php" class="link_admin" style="padding-left:10px; padding-right:10px; font-size:18px;"> Cadastrar Comanda</a><br></th>
						<th> <a href="logout_admin.php" class="link_admin" style="padding-left:10px; padding-right:10px; font-size:18px;"> Sair</a><br></th>	
					<tr>
				</table>	
			</div>
		';
		
		// seleciona todos os produtos
		$sql = "SELECT col_id, col_nome, col_preco, col_cod_produto FROM tbl_produto ORDER BY col_nome ASC"; 
		$result = mysql_query($sql, $conecta); 
		
		echo '
			<div id="lista_produtos"><br>
				<div class="titulo2" style="font-size:16px;">Produtos e Preços Cadastrados:</div>
		';
		
			while($consulta = mysql_fetch_array($result)) {  
				echo '
					<br>
							<input name="'.$consulta['col_id'].'" id="'.$consulta['col_id'].'" type="text" value="'.$consulta['col_nome'].'" readonly class="input_produto2"/>	
							R$ <input name="preco" id="preco" type="text" value="'.$consulta['col_preco'].'" readonly class="input_comanda" style="text-align:center;"/> 
							<a href="FormEditProduct.php?id_product='.$consulta['col_id'].'&product='.$consulta['col_nome'].'&preco='.$consulta['col_preco'].'&cod_product='.$consulta['col_cod_produto'].'" class="link_href_include"><b>Editar Produto</b></a>
								<label style="" for="|"> | </label>
							<a href="#" onclick="f_deletar('.$consulta['col_id'].')" class="link_href_include"><b>Deletar Produto</b></a>
				';	   
			} // fim loop
			mysql_free_result($result); 
			
			echo '</div>	';
			
mysql_close($conecta); 


echo '
</div>
</body>
</html>
';

 echo '
<script language="Javascript">

	function f_deletar(id_produto){
		
		if(confirm("Tem certeza que deseja apagar o produto ?")){
				window.location.replace("ActionDelete_admin.php?id_product="+id_produto);
			} else {
				alert("produto nao pagado");
			}
	}
	javascript:window.history.forward(1);

</script>
';



?>