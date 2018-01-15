<?php 
include 'functions/connection.php'; 
echo '
	<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title>Produtos | Comanda </title>
		<meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8">
	</head>
	<body>
	<div id="geral">
';  
	// LÓGICA
	$num_comanda = $_GET['comanda'];
	$num_venda = $_GET['venda'];
	
		$sqlComanda = "SELECT col_number_comanda FROM tbl_comanda WHERE col_number_comanda = '$num_comanda' AND comanda_is_used = 1"; 
		$resultComanda = mysql_query($sqlComanda, $conecta); 
		$num_rows_comanda = mysql_num_rows($resultComanda);
		
		$sqlComandaOpen = "SELECT * FROM tbl_venda WHERE col_id = $num_venda AND col_venda_is_open = 1"; 
		$resultComandaOpen = mysql_query($sqlComandaOpen, $conecta);
		$num_rows_comandaOpen = mysql_num_rows($resultComandaOpen);			
		
	// HTML
	echo '<br>
		<div class="titulo2"><center>Comanda: '.$num_comanda.'</center></div><br>
	';
	
	// LÓGICA
		// se comanda existe, se esta aberta e se a venda esta aberta...
		if ($num_rows_comanda > 0 AND $num_rows_comandaOpen > 0){
			echo'
				<div id="procura_prod_geral">
					<div id="procura_prod_nome" style="overflow: auto">
					
						<form method="POST" action="">	
							<div class="titulo2">Busque o produto pelo <u>nome</u>:</div><br>
							<input name="buscar_nome_produto" id="buscar_nome_produto" type="text" class="input_produto2" autocomplete="off"/>
							<input type="submit" name="sub_buscar_nome_produto" value="Buscar" class="input_submit">
						</form>	
					
			';
		// [ ### BUSCA PELO NOME ### ]	
			if (isset($_POST['sub_buscar_nome_produto'])) { 
				$buscar_nome_produto = $_POST["buscar_nome_produto"];  

				if ($buscar_nome_produto == ""){
					echo '<script>alert("\Necessario escrever o nome produto a ser buscado!");</script>';
				}else{
				$sqlSearchProduct = "SELECT col_id, col_nome, col_preco FROM tbl_produto WHERE col_nome LIKE '%$buscar_nome_produto%' ORDER BY col_nome ASC"; 
				$resultSearchProduct = mysql_query($sqlSearchProduct, $conecta); 
				$num_rows_SearchProduct = mysql_num_rows($resultSearchProduct);
					
					// se encontrou produto...
					if($num_rows_SearchProduct > 0){
						echo'<br>
						<div class="sub_titulo1">(Para incluir um produto selecione a quantidade).</div>
						<table border="1" style="border-color:#fff;">
						<tr>
							<th colspan="1"><div class="sub_titulo1">Produtos</div></th>
							<th colspan="1"><div class="sub_titulo1">Preço</div></th>
							<th colspan="1"><div class="sub_titulo1">Quantidade</div></th>
							<th colspan="1"><div class="sub_titulo1"></div></th>
						<tr>

						';
						while($consulta = mysql_fetch_array($resultSearchProduct)) {  
							echo '
							<tr>
								<th><input name="'.$consulta['col_id'].'" id="'.$consulta['col_id'].'" type="text" value="'.$consulta['col_nome'].' " readonly class="input_result1"/></th>
								<th><input name="'.$consulta['col_id'].'" id="'.$consulta['col_id'].'" type="text" value="'.$consulta['col_preco'].' " readonly class="input_result2"/></th>
								<th><input type="number" id="quantidade_produto_id_'.$consulta['col_id'].'" name="quantidade_produto_id_'.$consulta['col_id'].'" min="0" max="15" value="0" class="input_comanda" style=" text-align:center;"></th>
								<th><a href="#"  onclick="insert_product('.$consulta['col_id'].','.$num_venda.');" id="chamarView" class="link_href_include">Incluir</a><br></th>
							<tr>
							';
						} 
						mysql_free_result($resultSearchProduct); 
					}else{		
						echo '
						<div class="sub_titulo1"><br>Nenhum produto encontrado com esse nome!</div>';
					}
				}
			}
				echo '</table></div>';
				
		// [ ### BUSCA PELO ID ### ]	
			echo'	
					<div id="procura_prod_id" style="overflow: auto">
						<form method="POST" action="">
							<div class="titulo2">Busque o produto pelo <u>ID/Codigo</u>:</div><br>
							<input name="buscar_id_produto" id="buscar_id_produto" type="text" autocomplete="off" class="input_produto2"/>	
							<input type="submit" name="sub_buscar_id_produto" value="Buscar" class="input_submit"> 
						</form>	
				';
				
				if (isset($_POST['sub_buscar_id_produto'])) { 
					$buscar_id_produto = $_POST["buscar_id_produto"];  	
					
					// se encontrou produto...
					if ($buscar_id_produto == ""){
					echo '<script>alert("\Necessario escrever o ID do produto a ser buscado!");</script>';
					}else{
						$sqlSearchProduct = "SELECT col_id, col_nome, col_preco FROM tbl_produto WHERE col_cod_produto = '$buscar_id_produto'  ORDER BY col_nome ASC"; 
						$resultSearchProduct = mysql_query($sqlSearchProduct, $conecta); 
						$num_rows_SearchProductID = mysql_num_rows($resultSearchProduct);
						
						if($num_rows_SearchProductID > 0){
							echo'<br>
						<div class="sub_titulo1">(Para incluir um produto selecione a quantidade).</div>
						<table border="1" style="border-color:#fff;">
						<tr>
							<th colspan="1"><div class="sub_titulo1">Produtos</div></th>
							<th colspan="1"><div class="sub_titulo1">Preço</div></th>
							<th colspan="1"><div class="sub_titulo1">Quantidade</div></th>
							<th colspan="1"><div class="sub_titulo1"></div></th>
						<tr>

						';
							while($consulta = mysql_fetch_array($resultSearchProduct)) {  
								echo '
								<tr>
									<th><input name="'.$consulta['col_id'].'" id="'.$consulta['col_id'].'" type="text" value="'.$consulta['col_nome'].'" readonly class="input_result1" style="background:#d1dbe6;"/></th>
									<th><input name="'.$consulta['col_id'].'" id="'.$consulta['col_id'].'" type="text" value="'.$consulta['col_preco'].'" readonly class="input_result2" style="background:#d1dbe6;"/></th>
									<th><input type="number" id="quantidade_produto_id_'.$consulta['col_id'].'" name="quantidade_produto_id_'.$consulta['col_id'].'" min="0" max="15" value="0" class="input_comanda" style="text-align:center;"></th>
									<th><a href="#"  onclick="insert_product('.$consulta['col_id'].','.$num_venda.');" id="chamarView" class="link_href_include">Incluir</a><br></th>
								</tr>
								';
							} 
							mysql_free_result($resultSearchProduct); 
						}else{
							echo '
						<div class="sub_titulo1"><br>Nenhum produto encontrado com esse ID!</div>';
						}
					}
				}
				echo '</table></div>';
				
			
		// [ ### PRODUTOS INCLUIDOS ### ]			
			echo '
			 <div id="produto_incluidos" style="overflow: auto">
				<div class="titulo2">Produtos incluidos:</div>	<br>	
			';	
				$sqlProductInclude = "SELECT col_id_venda_hist, col_id_product_hist, col_name_product_hist, col_quantidade_prod FROM tbl_venda_historical WHERE col_id_venda_hist = $num_venda"; 
				$resultProductInclude = mysql_query($sqlProductInclude, $conecta); 
				$num_rowsProductInclude = mysql_num_rows($resultProductInclude);
				// verifica se tem produto incluido
				if($num_rowsProductInclude > 0){
					echo'
						<table border="1" style="border-color:#fff;">
						<tr>
							<th colspan="1"><div class="sub_titulo1">Produtos</div></th>
							<th colspan="1"><div class="sub_titulo1">Quant.</div></th>
							<th colspan="1"><div class="sub_titulo1"></div></th>
						<tr>
					';	
				}else{
					echo '<br><div class="sub_titulo1">Nenhum produto incluido.</div>';
				}
							
				while($consulta_pruduct = mysql_fetch_array($resultProductInclude)) { 
					echo '
						<tr>
							<th><input name="'.$consulta_pruduct['col_id_product_hist'].'" 
								id="'.$consulta_pruduct['col_id_product_hist'].'" type="text" value="'.$consulta_pruduct['col_name_product_hist'].'"readonly class="input_produto_incluido" style="text-align:center;"/></th>	
							<th><input name="'.$consulta_pruduct['col_id_product_hist'].'" 
								id="'.$consulta_pruduct['col_id_product_hist'].'" type="text" value="'.$consulta_pruduct['col_quantidade_prod'].'"readonly class="input_quant_incluido" style="text-align:center;"/>	</th>
							<th><a href="#"  onclick="remove_product('.$consulta_pruduct['col_id_product_hist'].','.$num_venda.');" id="chamarView" class="link_href_include">Retirar</a></th>
						</tr>
					';
				}
				mysql_free_result($resultProductInclude); 
			echo '</table></div>';
			echo '</div>';
			
		// [ ### FINALIZAR O PEDIDO ### ]		
			if (isset($_POST['finalizar_pedido'])) { 				
					$sqlSearchProductInclude = "SELECT * FROM tbl_venda_historical WHERE col_id_venda_hist = '$num_venda'"; 
					$resultSearchProductInclude = mysql_query($sqlSearchProductInclude, $conecta); 		
					$num_rowsSearchProductInclude = mysql_num_rows($resultSearchProductInclude);

					if ($num_rowsSearchProductInclude > 0){
						echo '<script>window.location.replace("index.php");</script>';
					}else{
						echo '<script>alert("Nenhum produto adicionado! \nAdicione um produto para continuar ou cancele a venda.");</script>';
					}
				}	
				
mysql_close($conecta); 

			echo '
			 <div id="finalizar_pedido">
				<div id="finalizar">
					<form method="POST" action="">
						<input type="submit" name="finalizar_pedido" value="Finalizar Pedido" class="input_submit"> 
					</form>	
				</div>
				
				<div id="cancelar">
					<input type="submit" name="cancelar_pedido" value="Cancelar Pedido" onclick="delete_venda('.$num_venda.','.$num_comanda.')" class="input_submit_cancelar"> 
				</div>		
			';
			echo '</div>';
			}else{
				// comanda inexistente
				echo '<script>alert("Essa Comanda nao existe ou essa comanda está fechada");</script>';
				header("Location:index.php");
			}

echo '
</div>
</body>
</html>
';		

echo'
<script>
	function CriaRequest() {
		 try{
			 request = new XMLHttpRequest();        
		 }catch (IEAtual){ 
			 try{
				 request = new ActiveXObject("Msxml2.XMLHTTP");       
			 }catch(IEAntigo){
			 
				 try{
					 request = new ActiveXObject("Microsoft.XMLHTTP");          
				 }catch(falha){
					 request = false;
				 }
			 }
		 }		 
		 if (!request) 
			 alert("Seu Navegador não suporta Ajax!");
		 else
			 return request;
	 }
 
	function insert_product(id_product, number_venda){
		// concateza quantidade_produto ao id do produto, ex: "quantidade_produto_10"
		var quantidade_produto_id = "quantidade_produto_id_"+id_product;
		var num_quantidade_produto = document.getElementById(quantidade_produto_id).value;

		if (num_quantidade_produto == 0){
			alert("Necessario informar a quantidade de produto comprada!");
		}else{
			 var Insert_Product = CriaRequest(); 
			 Insert_Product.open("GET", "include_product.php?venda="+number_venda+"&quant="+num_quantidade_produto+"&product="+id_product, true);	 
			 Insert_Product.onreadystatechange = function(){
			
				 if (Insert_Product.readyState == 4) {
					 if (Insert_Product.status == 200) {
						var x = Insert_Product.responseText;
						if(x == 1){
							alert ("Produto ja incluido na venda!");
						}else{
							window.location.reload();	
						}
					 }else{
						 alert("Carregando...");
					 }
				 }
			 };
			 Insert_Product.send();
		}
	}
	
		function remove_product(id_product, number_venda){

		 var Remove_Product = CriaRequest(); 
		 Remove_Product.open("GET", "remove_product.php?venda="+number_venda+"&product="+id_product, true);	 
		 Remove_Product.onreadystatechange = function(){
		
			 if (Remove_Product.readyState == 4) {
				 if (Remove_Product.status == 200) {
					 window.location.reload();		
					 alert("Produto retirado da venda!");					 
				 }else{
					 alert("excessao");
				 }
			 }
		 };
		 Remove_Product.send();
	}	
	
		function delete_venda(number_venda, number_comanda){

		 var Delete_Venda = CriaRequest(); 
		 Delete_Venda.open("GET", "delete_venda.php?venda="+number_venda+"&comanda="+number_comanda, true);	 
		 Delete_Venda.onreadystatechange = function(){
		
			 if (Delete_Venda.readyState == 4) {
					alert("Venda excluida. Comanda liberada! ");
			 }
		 };
		 Delete_Venda.send();
		 window.location.replace("index.php");
	}
	
 javascript:window.history.forward(1);
	
</script>
';		
?>