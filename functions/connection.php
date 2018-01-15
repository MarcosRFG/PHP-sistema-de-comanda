<?php

$conecta = mysql_connect("", "root", "") or print (mysql_error()); 
mysql_select_db("sistemadb", $conecta) or print(mysql_error()); 

?>