<?php

include 'functions/connection.php';

$id_venda = $_GET["venda"];
$num_comanda = $_GET["comanda"];

	// fecha comanda
	$sqlComandaIsUsed = "UPDATE tbl_comanda SET comanda_is_used = 0 WHERE col_number_comanda = $num_comanda"; 
	$resultComandaIsUsed = mysql_query($sqlComandaIsUsed, $conecta);
	
	// fecha venda 
	$sqlExitVenda = "UPDATE tbl_venda SET col_venda_is_open = 0 WHERE col_id = $id_venda"; 
	$resultExitVenda= mysql_query($sqlExitVenda, $conecta); 




?>