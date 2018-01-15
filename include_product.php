<?php

include 'functions/connection.php';

$id_venda = $_GET["venda"];
$id_product = $_GET["product"];
$quantidade_produto = $_GET["quant"];


	$sqlVerifiqProduct = "SELECT * FROM tbl_venda_historical WHERE col_id_venda_hist = $id_venda AND col_id_product_hist = $id_product"; 
	$resultVerifiqProduct = mysql_query($sqlVerifiqProduct, $conecta); 
	$num_rows_VerifiqProduct = mysql_num_rows($resultVerifiqProduct);
					
		if ($num_rows_VerifiqProduct > 0){
			$return = "1";
		}else{
			$sqlInsertProduct = "INSERT INTO tbl_venda_historical (col_id_venda_hist,col_id_product_hist, col_name_product_hist, col_preco_product_hist, col_quantidade_prod) VALUES ($id_venda, $id_product, (SELECT col_nome FROM tbl_produto WHERE col_id = $id_product), (SELECT col_preco FROM tbl_produto WHERE col_id = $id_product), $quantidade_produto)"; 
			$resultInsertProduct = mysql_query($sqlInsertProduct, $conecta); 
			$return = "0";
		}

echo $return;
	
?>
