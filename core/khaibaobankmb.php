<?php
include ('set.php');

$stk = '00352924355';
$tennh = 'TienPhongBank';
$chutaikhoan = 'NGUYEN BAO TOAN';
$password = 'Daominhtien1602@';
$token = 'C8CBDD8F-0C90-03A1-809A-09AC1D36D7CC';
$data = curl_get_contents("https://api.web2m.com/historyapimb/$password/$stk/$token");

$MEMO_PREFIX = 'btoan';