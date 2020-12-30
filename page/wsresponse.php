<?php
require_once '../class/koneksi.php';
require_once '../class/login.php';
require_once '../class/wishlist.php';

$database = new Koneksi();
$koneksi = $database->dapetKoneksi();

$login = new Login($koneksi);
$cekSesi = $login->sessionCheck();

if (empty($_SESSION['id'])) {
	$sesi = null;
}else{
	$sesi = $_SESSION['id'];
}

$wishlist = new Wishlist($koneksi, $cekSesi, $sesi);

if (empty($_GET['act'])) {
	$act = null;
}else{
	$act = $_GET['act'];
}

if (isset($_SESSION['id'])) {
	$wishlist->Request($act);
}

echo $wishlist->Response();
?>