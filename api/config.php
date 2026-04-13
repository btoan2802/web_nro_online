<?php
	$apikey = '6131232B4876B15A62934BA7CA394EDA'; //API key, lấy từ website thesieutoc.net thay vào trong cặp dấu ''
	// database Mysql config
	$local_db = "btoan.com";
	$user_db = "btoan";
	$pass_db = "toanhotface";
	$name_db = "nro_goc";
	# đừng đụng vào 
  $conn = new mysqli($local_db, $user_db, $pass_db, $name_db);
  $conn->set_charset("utf8");
    
?>