<?php
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict'
]);
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$ip_sv = "btoan.com";
$dbname_sv ="nro_goc";
$user_sv = "btoan";
$pass_sv = "toanhotface";

date_default_timezone_set('Asia/Ho_Chi_Minh');

$conn = new mysqli($ip_sv, $user_sv, $pass_sv,$dbname_sv);
$conn->set_charset("utf8mb4");    
?>