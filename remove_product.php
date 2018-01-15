<?php

include 'functions/connection.php';

$id_venda = $_GET["venda"];
$id_product = $_GET["product"];

	$sqlRemoveProduct = "DELETE FROM tbl_venda_historical WHERE col_id_venda_hist = $id_venda AND col_id_product_hist = $id_product;"; 
	$resultRemoveProduct = mysql_query($sqlRemoveProduct, $conecta); 
	echo $sqlRemoveProduct;
	//$num_rows_InsertProduct = mysql_num_rows($resultInsertProduct);



?>