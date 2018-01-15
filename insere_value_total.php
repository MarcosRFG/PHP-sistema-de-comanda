<?php

include 'functions/connection.php';

$id_venda = $_GET["venda"];
$num_comanda = $_GET["comanda"];
$value_total = $_GET["value_total"];

		// fecha comanda
		$sqlComandaIsUsed = "UPDATE tbl_comanda SET comanda_is_used = 0 WHERE col_number_comanda = $num_comanda"; 
		$resultComandaIsUsed = mysql_query($sqlComandaIsUsed, $conecta);	

		// fecha venda e insere valor da venda
		$sqlExitVenda = "UPDATE tbl_venda SET col_venda_is_open = 0, col_value_total = $value_total WHERE col_id = $id_venda"; 
		$resultExitVenda= mysql_query($sqlExitVenda, $conecta); 
		
		echo $sqlExitVenda ;	
?>
