<?php
session_start();

// // ----------- Log Inserting -------------------
// $w_nama_aplikasi   	=    "E-Filing";
// $w_id_aplikasi    	=    "41";   // ID Aplikasi
// $w_id_pegawai    	=    $_SESSION['ijklmn'];
// $w_aksi     		=    "LOGOUT";
// $w_keterangan_1    	=    "(select top 1 nm_pegawai from aplikasi.dbo.user_aplikasi with (nolock) where id_pegawai = $w_id_pegawai)";

// include("https://portal.brins.co.id/log/index.php");
// ----------- Log Inserting -------------------

unset($_SESSION['iduser']);
unset($_SESSION['namapegawai']);
unset($_SESSION['kd_cabang']);
unset($_SESSION['bsam_nama']);
unset($_SESSION['dev']);

unset($_SESSION['nmuser']);
unset($_SESSION['username']);
unset($_SESSION['usercare']);
unset($_SESSION['nip']);

//session_destroy();
//header("location:login.php");
header("location:https://portal.brins.co.id/apps/pilih.aplikasi/");

//header("location:index.php");
?>