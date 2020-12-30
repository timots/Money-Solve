<?php
require_once '../class/koneksi.php';
require_once '../class/login.php';
require_once '../class/user.php';

$database = new Koneksi();
$koneksi = $database->dapetKoneksi();

$login = new Login($koneksi);
$cekSesi = $login->sessionCheck();

$user = new User($koneksi, $cekSesi, $_SESSION['id']);

if (empty($_GET['act'])) {
	$act = null;
}else{
	$act = $_GET['act'];
}

$user->Request($act);

echo $user->Response();
?>
