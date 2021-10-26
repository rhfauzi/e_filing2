<?php
session_start();
require 'setting/koneksi.php';

conDB('.','aplikasi');
$s1				= "SELECT * FROM user_aplikasi WHERE id_pegawai	= '".$_SESSION['ijklmn']."'";
$q1				= mssql_query($s1);
$r1				= mssql_fetch_array($q1);

$selectcabang 	= mssql_query("SELECT * FROM cab_aplikasi WHERE kd = '".$r1['kd_cabang']."'");
$x				= mssql_fetch_assoc($selectcabang); 

$_SESSION["kd_cabang"]		= $r1['kd_cabang'];
$_SESSION["namapegawai"]	= ucwords($r1['nm_pegawai']);
$_SESSION["bsam_nama"]		= $x['nama_lgkp'];
$_SESSION["iduser"]			= $r1['id_pegawai'];

$_SESSION['nmuser']   		= $r1['nm_pegawai'];
$_SESSION['username'] 		= $r1['usernamePegawai'];
$_SESSION['usercare'] 		= $r1['userCare'];
$_SESSION['nip']      		= $r1['kd_pegawai'];

		
// ----------- Log Inserting -------------------
$w_nama_aplikasi	="E-Filing";			// Nama Aplikasi
$w_id_aplikasi		="41";			// ID Aplikasi
$w_id_pegawai		=$_SESSION['iduser'];
$w_aksi				="LOGIN";
$w_keterangan_1		="(select top 1 nm_pegawai from aplikasi.dbo.user_aplikasi where id_pegawai = $w_id_pegawai)";

include("../log/index.php");
// ----------- Log Inserting -------------------


header("location:index");

?>