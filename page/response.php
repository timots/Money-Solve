<?php
require_once '../class/koneksi.php';
require_once '../class/login.php';
require_once '../class/transaksi.php';

$database = new Koneksi();
$koneksi = $database->dapetKoneksi();

$login = new Login($koneksi);
$cekSesi = $login->sessionCheck();

$transaksi = new Transaksi($koneksi,$cekSesi);
echo $transaksi->response();
?>
