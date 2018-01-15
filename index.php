 <?php 
 header("Content-Type: text/html; charset=ISO-8859-1", true);
include 'functions/connection.php'; 
echo '
	<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title>Inicio | Comanda </title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
	<div id="geral">
'; 

	// INICIO LÓGICAS
	// [ ### INICIAR COMANDA ### ] 
	 if (isset($_POST['iniciar_comanda'])) { 
		$num_comanda = $_POST['num_comanda'];	
		$sqlComanda = "SELECT col_number_comanda FROM tbl_comanda WHERE col_number_comanda = '$num_comanda'"; 
		$resultComanda = mysql_query($sqlComanda, $conecta); 	
		$num_rows = mysql_num_rows($resultComanda);
		
		// se comanda existe...
		if ($num_rows > 0){	
			$sqlComanda_Is_Used = "SELECT * FROM tbl_comanda WHERE col_number_comanda = $num_comanda AND comanda_is_used = 1"; 
			$resultComanda_Is_Used = mysql_query($sqlComanda_Is_Used, $conecta); 
			$num_rows_Is_Used = mysql_num_rows($resultComanda_Is_Used);
			
			// se comanda está aberta...
			if ($num_rows_Is_Used == 1){
				echo '<script> alert("Essa comanda já está sendo usada!"); </script>';
			}else{
				$sqlInicioVenda = "INSERT INTO tbl_venda (col_comanda_venda, col_venda_is_open, col_10Porcent, col_value_total) VALUES ($num_comanda, 1, 0 , 0)"; 
				$resultInicioVenda= mysql_query($sqlInicioVenda, $conecta); 
				$id_insert = mysql_insert_id();
				$sqlComandaIsUsed = "UPDATE tbl_comanda SET comanda_is_used = 1 WHERE col_number_comanda = $num_comanda"; 
				$resultComandaIsUsed = mysql_query($sqlComandaIsUsed, $conecta);	
				header("Location:comanda.php?comanda=$num_comanda&venda=$id_insert");				
			}
		}else{
			// Comanda não existe
			echo '<script>alert("Essa Comanda não existe!");</script>';
		}
	 }else{
		 // Não foi adionado.
	 }
 
	// [ ### EDITAR COMANDA ### ] 
	 if (isset($_POST['editar_comanda'])) { 
			$num_comanda = $_POST['num_comanda'];
			$sqlComanda = "SELECT col_number_comanda FROM tbl_comanda WHERE col_number_comanda = '$num_comanda'"; 
			$resultComanda = mysql_query($sqlComanda, $conecta); 	
			$num_rows = mysql_num_rows($resultComanda);
			
			// se comanda existe...
			if ($num_rows > 0){
				$sqlComanda_Is_Used = "SELECT * FROM tbl_comanda WHERE col_number_comanda = $num_comanda AND comanda_is_used = 1"; 
				$resultComanda_Is_Used = mysql_query($sqlComanda_Is_Used, $conecta); 
				$num_rows_Is_Used = mysql_num_rows($resultComanda_Is_Used);
				
				// se comanda está aberta...
				if ($num_rows_Is_Used == 1){
					$sqlPegaIDVenda = "SELECT col_id FROM tbl_venda WHERE col_comanda_venda = $num_comanda AND col_venda_is_open = 1 ORDER BY col_id DESC LIMIT 1"; 
					$resultPegaIDVenda = mysql_query($sqlPegaIDVenda, $conecta); 				
					
					while($consulta = mysql_fetch_array($resultPegaIDVenda)) {  	
							$IDVenda =  $consulta['col_id'];
						} 
						mysql_free_result($resultPegaIDVenda); 	
						
					header("Location:comanda.php?comanda=$num_comanda&venda=$IDVenda");	
				}else{
					echo '<script> alert("Essa comanda não esta inciada !"); </script>';
				}
			}else{
				echo '<script>alert("Essa Comanda nao existe!");</script>';
			}
		 }else{
			 // Não acionado.
		 }
	 
	// [ ### FATURAR A VENDA ### ] 
 
	 if (isset($_POST['faturar_venda'])) { 
			$num_comanda = $_POST['num_comanda'];
			$sqlComanda = "SELECT col_number_comanda FROM tbl_comanda WHERE col_number_comanda = '$num_comanda'"; 
			$resultComanda = mysql_query($sqlComanda, $conecta); 	
			$num_rows = mysql_num_rows($resultComanda);
			
			// se comanda existe...
			if ($num_rows > 0){
				$sqlComanda_Is_Used = "SELECT * FROM tbl_comanda WHERE col_number_comanda = $num_comanda AND comanda_is_used = 1"; 
				$resultComanda_Is_Used = mysql_query($sqlComanda_Is_Used, $conecta); 
				$num_rows_Is_Used = mysql_num_rows($resultComanda_Is_Used);
				
				// se comanda esta aberta...
				if ($num_rows_Is_Used == 1){
					$sqlPegaIDVenda = "SELECT col_id FROM tbl_venda WHERE col_comanda_venda = $num_comanda AND col_venda_is_open = 1 ORDER BY col_id DESC LIMIT 1"; 
					$resultPegaIDVenda = mysql_query($sqlPegaIDVenda, $conecta); 				
					
					while($consulta = mysql_fetch_array($resultPegaIDVenda)) {  	
							$IDVenda =  $consulta['col_id'];
						} 
						mysql_free_result($resultPegaIDVenda); 	
						
					header("Location:faturar_venda.php?comanda=$num_comanda&venda=$IDVenda");	
				}else{
					echo '<script> alert("Essa comanda não esta inciada!"); </script>';
				}
			}else{
				echo '<script>alert("Essa Comanda não existe!");</script>';
			}
		 }else{
			 // Não acionado
		 }
mysql_close($conecta); 
	// FIM LÓGICAS

	// INICIO FORMULARIOS	 
		// Form. iniciar comanda
		echo '
			<div id="link_admin" class="link_admin"> <a href="./admin/index_admin.php" class="link_admin">Área Administrativa </a> </div>
			<div id="iniciar_comanda"> <br>
				<div class="titulo1">Inicio de Comanda</div>
				<div class="sub_titulo1">Digite o número da comanda para iniciar:</div>
				
				<form id="form_iniciar_comanda" action="" method="POST">
					<input name="num_comanda" id="num_comanda" type="text" class="input_comanda" autocomplete="off" style="text-align:center;"/>	<br>		
					<input type="submit" name="iniciar_comanda" value="Iniciar Comanda" class="input_submit"> 
				</form>
			</div>
			
			<div id="edit_comanda"><br>
				<div class="titulo1">Editar Pedido de Comanda</div>
				<div class="sub_titulo1">Digite o número da comanda para editar o pedido da comanda:</div>
				
				<form id="form_editar_comanda" action="" method="POST">
					<input name="num_comanda" id="num_comanda" type="text" class="input_comanda" autocomplete="off" style="text-align:center;"/>	<br>		
					<input type="submit" name="editar_comanda" value="Editar Comanda" class="input_submit"> 
				</form>
			</div>
			
			<div id="faturar_venda"><br>
				<div class="titulo1">Faturar Venda</div>
				<div class="sub_titulo1">Digite o número da comanda para faturar e finalizar a comanda:</div>
				
				<form id="form_faturar_venda" action="" method="POST">
					<input name="num_comanda" id="num_comanda" type="text" class="input_comanda" autocomplete="off" style="text-align:center;"/> <br>	
					<input type="submit" name="faturar_venda" value="Faturar Venda" class="input_submit" /> 	
				</form>
			</div>
		';
echo '
</div>
</body>
</html>
';
echo ' <script>  javascript:window.history.forward(1);</script>';

?>



