<?php 
include '../setting/koneksi.php';
kon_app();

$q = strtolower($_GET["q"]);
if (!$q) return;

if($_GET['type'] == 'user'){
	$sql = mssql_query("SELECT * FROM user_aplikasi where nm_pegawai LIKE '%".$q."%' OR id_pegawai LIKE '%".$q."%' OR kd_pegawai LIKE '%".$q."%'");
	while($r = mssql_fetch_assoc($sql)) {
		$kd 	 = $r['kd_pegawai'];
		$id 	 = $r['id_pegawai'];
		$nm 	 = $r['nm_pegawai'];
		
		echo "$id-$nm-$kd\n";
	}
}

if($_GET['type'] == 'asset'){
	$sql = mssql_query("SELECT * FROM asset where kd_asset LIKE '%".$q."%' OR nm_asset LIKE '%".$q."%'");
	while($r = mssql_fetch_assoc($sql)) {
		$kd 	 = $r['kd_asset'];
		$nm 	 = $r['nm_asset'];
		
		echo "$kd-$nm\n";
	}
}
?>
