<?php 
include 'functions/connection.php'; 
echo '
	<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title>Faturamento | Comanda </title>
		<meta charset="ISO-8859-1"/>
	</head>
	<body>
	<div id="geral">
';  
	// LÓGICA
	// valores recebidos/coletados via GET
	$num_comanda = $_GET['comanda'];
	$num_venda = $_GET['venda'];

		$sqlComanda = "SELECT col_number_comanda FROM tbl_comanda WHERE col_number_comanda = '$num_comanda'"; 
		$resultComanda = mysql_query($sqlComanda, $conecta); 
		$num_rows_comanda = mysql_num_rows($resultComanda);
		
		$sqlComandaOpen = "SELECT * FROM tbl_venda WHERE col_id = $num_venda AND col_venda_is_open = 1"; 
		$resultComandaOpen = mysql_query($sqlComandaOpen, $conecta);
		$num_rows_comandaOpen = mysql_num_rows($resultComandaOpen);
					
		if ($num_rows_comanda > 0 AND $num_rows_comandaOpen > 0){
			echo '
				<br><div class="titulo2"><center>Comanda: '.$num_comanda.'</center></div><br>
				<div id="faturar_produto_geral">
					<div id="produto_incluidos_faturar" style="overflow: auto"><br>
					<div class="titulo2">Produtos incluidos:</div>		
			';	
				$sqlProductInclude = "SELECT col_id_venda_hist, col_id_product_hist, col_name_product_hist,col_quantidade_prod,col_preco_product_hist FROM tbl_venda_historical WHERE col_id_venda_hist = $num_venda"; 
				$resultProductInclude = mysql_query($sqlProductInclude, $conecta); 
			 
		// [ ### PRODUTOS INCLUIDOS ### ]
				echo'
				<table border="1" style="border-color:#fff;">
				<tr>
					<th colspan="1"><div class="sub_titulo1">Produtos</div></th>
					<th colspan="1"><div class="sub_titulo1">Quantidade</div></th>
					<th colspan="1"><div class="sub_titulo1">Preço Unid.</div></th>
				<tr>

				';
				while($consulta_pruduct = mysql_fetch_array($resultProductInclude)) { 
					echo '
						<tr>
							<th><input name="'.$consulta_pruduct['col_id_product_hist'].'" 
							id="'.$consulta_pruduct['col_id_product_hist'].'" type="text" value="'.$consulta_pruduct['col_name_product_hist'].'"readonly class="input_produto_incluido" style="text-align:center;"/>	</th>
							<th><input name="'.$consulta_pruduct['col_id_product_hist'].'" 
							id="'.$consulta_pruduct['col_id_product_hist'].'" type="text" value="'.$consulta_pruduct['col_quantidade_prod'].'"readonly class="input_quant_incluido" style="text-align:center;""/>	</th>
							<th><input name="'.$consulta_pruduct['col_id_product_hist'].'" 
							id="'.$consulta_pruduct['col_id_product_hist'].'" type="text" value="'.$consulta_pruduct['col_preco_product_hist'].'"readonly class="input_quant_incluido" style="text-align:center;""/>	</th>
						</tr>
					';
				}
				mysql_free_result($resultProductInclude); 
			echo '</table></div>';
				
		// [ ### LÓGICA VALOR A SER PAGO ### ]
				$sql = "SELECT SUM(preco_quant) soma_preco_quant FROM (SELECT SUM(`col_preco_product_hist` * `col_quantidade_prod`) preco_quant FROM tbl_venda_historical WHERE `col_id_venda_hist` = $num_venda) tabela_virtual"; 	
				$result = mysql_query($sql, $conecta); 
				
				while($consul = mysql_fetch_array($result)) { 
					$soma_venda = $consul['soma_preco_quant'];
				}
				mysql_free_result($result); 
			
				$valor_final_venda = $soma_venda;
			
			// [ ### LÓGICA FINALIZAR FATURAMENTO ### ]
				if (isset($_POST['finalizar_faturamento'])) { 	
					$op_dez_porcent = $_POST['op_dez_porcent'];
					
					if ($op_dez_porcent == "sim"){
						$sqlUpdate10PorcentYes = "UPDATE tbl_venda SET col_10Porcent = 1 WHERE col_id = $num_venda"; 
						$resultUpdate10PorcentYes = mysql_query($sqlUpdate10PorcentYes, $conecta);		
						// acrescenta 10%
						$valor_porcentagem = $soma_venda * 0.10;
						$valor_final_venda = $soma_venda + $valor_porcentagem;
					}else{
						$sqlUpdate10PorcentYes = "UPDATE tbl_venda SET col_10Porcent = 0 WHERE col_id = $num_venda"; 
						$resultUpdate10PorcentYes = mysql_query($sqlUpdate10PorcentYes, $conecta);			
						// NÃO acrescenta 10%
						$valor_final_venda = $soma_venda;
					}											
				}else{
					// ainda nao calculou a venda
					 $valor_final_venda = null;
				}
			
				// busca se porcentagem de 10% sera paga
				$sqlSelect10Porcent = "SELECT col_10Porcent FROM tbl_venda WHERE col_id = $num_venda"; 
				$resultSelect10Porcent = mysql_query($sqlSelect10Porcent, $conecta); 
				
				while($consulta = mysql_fetch_array($resultSelect10Porcent)) {  	
					$Select10Porcent =  $consulta['col_10Porcent'];
				} 
				mysql_free_result($resultSelect10Porcent); 	
				
mysql_close($conecta); 			
			
		// [ ### HTML FINALIZAR FATURAMENTO ### ]
				echo '
					<div id="faturar_fim">
							<div class="sub_titulo1">Adicionar 10% ?</div>
							
							<form id="form" action="" method="POST">
								  <input type="radio" name="op_dez_porcent" id="sim" value="sim"'. ($Select10Porcent == '1' ? 'checked' : '') .' /> sim
								  <input type="radio" name="op_dez_porcent" id="nao" value="nao"'. ($Select10Porcent == '0' ? 'checked' : '') .' /> nao<br><br>
								  <input type="submit" name="finalizar_faturamento" value="Calcular valor a pagar" class="input_submit"><label style="font-size:12px;" for="obrigatorio"> (Obrigatório)</label>
							</form><br>
							
							<div class="sub_titulo1">Total a pagar <input type="text" value="'.$valor_final_venda.'" readonly class="input_comanda" style="font-weight: bold; text-align:center;"/> </div>
							<br>
							<input type="button" onclick="insere_value_total('.$num_venda.', '.$num_comanda.' , '.$valor_final_venda.')" name="fim_venda" value="Finalizar Faturamento" class="input_submit"> 				
				';
			echo '</div>';
			
		// [ ### EDITAR O PEDIDO DA COMANDA ### ]
			 if (isset($_POST['editar_comanda'])) { 
				echo '<script>window.location.replace("comanda.php?comanda="+'.$num_comanda.'+"&venda="+'.$num_venda.');</script>';
			 }else{
				 // comanda nao sera editada
			 }
	 
			echo '
					<div id="editar_comanda">
						<form id="formulario" action="" method="POST">
							<input type="submit" name="editar_comanda" value="Editar Pedido da comanda" class="input_submit"> 
						</form>
					</div>
			';
			}else{
				// SEM SUCESSO
			echo '<script>alert("Essa Comanda nao existe ou essa comanda está fechada");</script>';
			header("Location:index.php");
		}

echo '
</div>
</body>
</html>
';

echo '
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
 
	function insere_value_total(number_venda, num_comanda, value_total){
		
		if (value_total == null){
			
			alert("Antes de finalizar, é necessário calcular a venda!");
		}else{
			
			 var Insert_Value = CriaRequest(); 
			 Insert_Value.open("GET", "insere_value_total.php?venda="+number_venda+"&comanda="+num_comanda+"&value_total="+value_total, true);	 
			 Insert_Value.onreadystatechange = function(){
			 };
			 Insert_Value.send();
			 alert("Venda gravada! Clique em Ok para voltar para a tela inicial.");
			 window.location.replace("index.php");
		}
	}
	
javascript:window.history.forward(1);
</script>
';

?>