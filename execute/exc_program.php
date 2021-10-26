<?php
require '../setting/koneksi.php';
require '../function/seqno.php';
require '../function/changeformat.php';
require '../function/encdec.php';

conDB('.','e_filing');
session_start();
error_reporting(0);


$getact  = $_GET['act'];
$postact = $_POST['act'];

$activity_add     = 'TAMBAH';
$activity_edit    = 'UBAH';
$activity_del  	  = 'HAPUS';
$activity_update  = 'UBAH STATUS';

$data_status 	  = 'N';

// $input_user 	  = '408';
$input_user 	  = $_SESSION['iduser'];
$logdate 		  = date('d-m-Y'); $logtime = date('H:i:s');
$input_date 	  = $logdate." | ".$logtime;
$last_update 	  = $input_user." | ".$input_date;

$status_in = '1';
$status_out = '2';


//============================ URL KODE QRCODE ===================================
$edc   =  new encdec();
// ======================================================================================================

//---------------------------------------------------- INSERT ARSIP ---------------------------------------

// if($getact == 'addarsip'){

// $kd_lokasi 		=	$_POST['kd_lokasi'];
// $kd_rak 		=	$_POST['kd_rak'];
// $kd_box 		=	$_POST['kd_box'];
// $kd_kategori	=	$_POST['kd_kategori'];
// // $kd_type 	=	$_POST['kd_type'];
// $kd_uker 		=	$_POST['kd_uker'];
// $nama_arsip 	=	$_POST['nama_arsip'];
// $deskripsi 		=	$_POST['deskripsi'];
// $tgl_terbit 	=	DBDate($_POST['tgl_terbit']);
// $tgl_masuk 		=	DBDate($_POST['tgl_masuk']);
// $tags 			=	$_POST['tags'];
// $no_scan        =   $_POST['no_scan'];


// $kd_arsip		=	arsipcode($kd_kategori,$_POST['tgl_masuk']);

// //---------------------------- untuk link qrcode --------------------------------
// $ID     		= $kd_arsip;
// $hasil_encrypt  = $edc->encrypt($ID , true);
// $url      		= "http://portal.brins.co.id/e_filing/view/qrarsip_result.php?id=";
// $link_qrcode 	= $url.$hasil_encrypt."";
// //-------------------------------------------------------------------------------

// $id_arsip 		= $_POST['id_arsip'];

// $lokasi_file	= $_FILES['berkas']['tmp_name'];

// //jika ada atau tidak ada yang diupload
// if(empty($lokasi_file)){
// 	$arsip_file 	= '';
// }else{
// 	$tipe_file = $_FILES['berkas']['type'];
// 	$lokasi_file = $_FILES['berkas']['tmp_name'];
// 	$nama = $_FILES['berkas']['name'];
// 	$size = $_FILES['berkas']['size'];
	
// 	$acak = rand(1,99);
// 	$nama_file_unik = $kd_arsip."_".$acak."_".$nama;						//menambahkan nama random
// 	$validname=str_replace(' ','_',$nama_file_unik);	//merubah karakter spasi menjadi '_'
// 	$folder="../file/$validname";						//lokasi penyimpanan foto
// 	// copy($lokasi_file,$folder);							//mengcopy file foto dan paste ke folder tujuan
// 	$arsip_file = $validname;							//variabel yang disimpan di database

// 	$getExtension = explode(".",$nama);
// 	$ext 		  = $getExtension[1];
// }

	

// 	if($id_arsip == ''){
// 		if($ext == "pdf" || $ext == "PDF"){
			
// 			$query	=	"INSERT INTO arsip(kd_arsip,
// 										kd_box,
// 										kd_kategori,
// 										kd_uker,
// 										nama_arsip,
// 										deskripsi,
// 										tgl_terbit,
// 										tgl_masuk,
// 										status,
// 										tags,
// 										no_scan,
// 										arsip_file,
// 										link_qrcode,
// 										input_user,
// 										input_date,
// 										last_update)VALUES('$kd_arsip',
// 															'$kd_box',
// 															'$kd_kategori',
// 															'$kd_uker',
// 															'$nama_arsip',
// 															'$deskripsi ',
// 															'$tgl_terbit',
// 															'$tgl_masuk',
// 															'$status_in',
// 															'$tags',
// 															'$no_scan',
// 															'$arsip_file',
// 															'$link_qrcode',
// 															'$input_user',
// 															'$input_date',
// 															'$last_update')";


// 		$ket   = $activity_add;

// 		copy($lokasi_file,$folder);
		
// 		}else{
// 			header("location:../main.php?mid=addarsip_laststep&kd_lokasi=$kd_lokasi&kd_rak=$kd_rak&kd_box=$kd_box&alert=4");
// 		}
// 	}else{
// 		if(empty($lokasi_file)){
// 			$query	=	"UPDATE arsip SET nama_arsip = '$nama_arsip',
// 										deskripsi 	= '$deskripsi',
// 										tgl_terbit 	= '$tgl_terbit',
// 										tgl_masuk 	= '$tgl_masuk',
// 										tags 		= '$tags',
// 										no_scan		= '$no_scan',
// 										last_update = '$last_update'
// 									WHERE id_arsip = '".$id_arsip."'";

// 		}
// 			if($ext != "pdf"){
// 				header("location:../main.php?mid=addarsip_laststep&kd_lokasi=$kd_lokasi&kd_rak=$kd_rak&kd_box=$kd_box&alert=4");
// 			}else{
// 				$getkd = mssql_fetch_assoc(mssql_query("SELECT kd_arsip,arsip_file FROM arsip WHERE id_arsip = '".$id_arsip."'"));

// 				$acak = rand(1,99);
// 				$nama_file_unik = $getkd['kd_arsip']."_".$acak."_".$nama;						//menambahkan nama random
// 				$validname=str_replace(' ','_',$nama_file_unik);	//merubah karakter spasi menjadi '_'
// 				$folder="../file/$validname";						//lokasi penyimpanan foto
// 				copy($lokasi_file,$folder);
// 				$arsip_file = $validname;
// 				unlink("../file/".$getkd['arsip_file']); //menghapus file foto sebelumnya

				
				
// 			$query	=	"UPDATE arsip SET nama_arsip = '$nama_arsip',
// 											deskripsi 	= '$deskripsi',
// 											tgl_terbit 	= '$tgl_terbit',
// 											tgl_masuk 	= '$tgl_masuk',
// 											tags 		= '$tags',
// 											arsip_file  = '$arsip_file',
// 											last_update = '$last_update'
// 										WHERE id_arsip = '".$id_arsip."'";

// 		}
// 		$ket   = $activity_edit;
// 	}


// 	$sql = mssql_query($query);

// 	//echo $query;

// 	if($sql){

// 	//activitylog----------------------------------------------------------------------------------
// 		$actlog = mssql_query("INSERT INTO log_activity (activity,
// 														menu,
// 														kode,
// 														status,
// 														user_log,
// 														date_log)values('$ket',
// 																		'arsip',
// 																		'$kd_arsip',
// 																		'SUCCESS',
// 																		'$input_user',
// 																		convert(varchar(200),'$input_date'))");


// 	//---------------------------------------------------------------------------------------------
// 		if($ket == $activity_add){
// 			//echo "1";
// 			header("location:../main.php?mid=addarsip_laststep&kd_lokasi=$kd_lokasi&kd_rak=$kd_rak&kd_box=$kd_box&alert=1");
// 		}else{
// 			//echo "2";
// 			header("location:../main.php?mid=addarsip_laststep&kd_lokasi=$kd_lokasi&kd_rak=$kd_rak&kd_box=$kd_box&id_arsip=$id_arsip&alert=2");
// 		}
// 	}else{
// 		//echo "3";
// 		header("location:../main.php?mid=addarsip_laststep&kd_lokasi=$kd_lokasi&kd_rak=$kd_rak&kd_box=$kd_box&alert=3");
// 	}

// }


if($postact == 'editarsip'){

		$id 		= $_POST['id_arsip'];
		$scanNo		= $_POST['scanNo'];
		$nm_arsip 	= $_POST['nm_arsip'];
		$keterangan	= $_POST['keterangan'];

		$query = "UPDATE arsip SET nama_arsip = '".$nm_arsip."',
											last_update = '$last_update'
											WHERE id_arsip = '".$id."'";

		$query2 = "UPDATE arsip_scan SET isi_index2 = '".$keterangan."'
											WHERE scanNo = '".$scanNo."'";
																											
		$sql = mssql_query($query);
		$sql2 = mssql_query($query2);

		if($sql && $sql2){

		//activitylog----------------------------------------------------------------------------------
			$actlog = mssql_query("INSERT INTO log_activity (activity,
															menu,
															kode,
															status,
															user_log,
															date_log)values('$activity_edit',
																			'arsip',
																			'".$id."/".$scanNo."',
																			'SUCCESS',
																			'$input_user',
																			convert(varchar(200),'$input_date'))");

		//---------------------------------------------------------------------------------------------
			
			$url    = "mid=formEditArsip&id=$id&alert=1";
		}else{
			$url    = "mid=formEditArsip&id=$id&alert=2";
		}

		$urlEnc = $edc->encrypt($url,true);
		echo $urlEnc;
			
}


//---------------------------------------------------- DELETE arsip ---------------------------------------
if($getact == 'delarsip'){

$kd_arsip		=	$_GET['kd_arsip'];

// $vsqlpathicon = mssql_query("SELECT arsip_file FROM arsip WHERE kd_arsip ='".$kd_arsip."'");	//cek data foto
// $vrespathicon = mssql_fetch_array($vsqlpathicon);
// $oldfile = $vrespathicon['arsip_file'];
// unlink("../file/$oldfile"); //menghapus file foto sebelumnya

$sql	= mssql_query("DELETE FROM arsip WHERE kd_arsip	= '".$kd_arsip."'");
// $sql2	= mssql_query("DELETE FROM arsip_file WHERE kd_arsip	= '".$kd_arsip."'");
			
			
		if($sql){

		 //activitylog----------------------------------------------------------------------------------
				$actlog = mssql_query("INSERT INTO log_activity (activity,
																menu,
																kode,
																status,
																user_log,
																date_log)values('$activity_del',
																				'arsip',
																				'$kd_arsip',
																				'SUCCESS',
																				'$input_user',
																				convert(varchar(200),'$input_date'))");

			//---------------------------------------------------------------------------------------------

			$url    = "mid=listarsip&alert=1&ket=dihapus";
		}else{
			$url    = "mid=listarsip&alert=2&ket=dihapus";
		}
	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");

}
//-------------------------------------------------------------------------------------------------------------


// ====================================  PEMINDAHAN ARSIP =============================================

if($postact == 'pindaharsip'){

$getkode1 		=	explode(" - ",$_POST['kd_arsip']);
$kd_arsip 		=	$getkode1[0];

$alasan 		=	$_POST['alasan'];
$BL 			=	$_POST['BL'];

$BB 			=	$_POST['BB'];
$keterangan 	=	$_POST['keterangan'];
$tgl_pindah  	= 	DBDate($_POST['tgl_pindah']);


		$query = "UPDATE arsip SET kd_box 	 = '$BB'
								   WHERE kd_arsip = '$kd_arsip'";

		$sql = mssql_query($query);

		if($sql){

		$query2	=	"INSERT INTO hist_pindah_arsip(kd_arsip,
											   alasan_pindah,
												box_awal,
												box_akhir,
												keterangan,
												tgl_pindah,
												input_user,
												input_date)VALUES('$kd_arsip',
																  	'$alasan',
																	'$BL',
																	'$BB',
																	'$keterangan',
																	'$tgl_pindah',
																	'$input_user',
																	'$input_date')";

		$sql2 = mssql_query($query2);

			if($sql2){

			//activitylog----------------------------------------------------------------------------------
				$actlog = mssql_query("INSERT INTO log_activity (activity,
																menu,
																kode,
																status,
																user_log,
																date_log)values('$activity_add',
																				'pindah arsip',
																				'$kd_arsip',
																				'SUCCESS',
																				'$input_user',
																				convert(varchar(200),'$input_date'))");


			//---------------------------------------------------------------------------------------------

				$url    = "mid=pindaharsip&alert=1";
			}else{
				$url    = "mid=pindaharsip&alert=2";
			}
				
			$urlEnc = $edc->encrypt($url,true);
			echo $urlEnc;
		}

}


// ====================================  PEMINDAHAN RAK =============================================

if($postact == 'pindahrak'){

$kd_rak 		=	$_POST['kd_rak'];
$alasan 		=	$_POST['alasan'];
$LL 			=	$_POST['LL'];

$getkode2 		=   explode(" / ",$_POST['LB']);
$LB 			=	$getkode2[0];
$keterangan 	=	$_POST['keterangan'];
$tgl_pindah  	= 	DBDate($_POST['tgl_pindah']);


		$query1 = "UPDATE msrak SET kd_lokasi = '$LB'
								  WHERE kd_rak = '$kd_rak'";				   

		$sql1 = mssql_query($query1);

		if($sql1){

		$query2	=	"INSERT INTO hist_pindah_rak(kd_rak,
											   alasan_pindah,
												lokasi_awal,
												lokasi_akhir,
												keterangan,
												tgl_pindah,
												input_user,
												input_date)VALUES('$kd_rak',
																  	'$alasan',
																	'$LL',
																	'$LB',
																	'$keterangan',
																	'$tgl_pindah',
																	'$input_user',
																	'$input_date')";

			$sql2 = mssql_query($query2);

			if($sql2){

				//activitylog----------------------------------------------------------------------------------
					$actlog = mssql_query("INSERT INTO log_activity (activity,
																	menu,
																	kode,
																	status,
																	user_log,
																	date_log)values('$activity_add',
																					'pindah rak',
																					'$kd_rak',
																					'SUCCESS',
																					'$input_user',
																					convert(varchar(200),'$input_date'))");


				//---------------------------------------------------------------------------------------------
				$url    = "mid=pindahrak&alert=1";
			}else{
				$url    = "mid=pindahrak&alert=2";
			}
				
			$urlEnc = $edc->encrypt($url,true);
			echo $urlEnc;

		}

}


// ====================================  PEMINDAHAN BOX =============================================

if($postact == 'pindahbox'){

$kd_box 		=	$_POST['kd_box'];
$alasan 		=	$_POST['alasan'];
$LL 			=	$_POST['LL'];
$RL 			=	$_POST['RL'];

$getkode1 		=   explode(" / ",$_POST['LB']);
$LB 			=	$getkode1[0];

$RB 			=   $_POST['RB'];

$keterangan 	=	$_POST['keterangan'];
$tgl_pindah  	= 	DBDate($_POST['tgl_pindah']);

		$query1 = "UPDATE msbox SET kd_rak = '$RB'
								   WHERE kd_box = '$kd_box'";
				   

		$sql1 = mssql_query($query1);

		if($sql1){

		$query2	=	"INSERT INTO hist_pindah_box(kd_box,
											    alasan_pindah,
												rak_awal,
												rak_akhir,
												keterangan,
												tgl_pindah,
												input_user,
												input_date)VALUES('$kd_box',
																  	'$alasan',
																	'$RL',
																	'$RB',
																	'$keterangan',
																	'$tgl_pindah',
																	'$input_user',
																	'$input_date')";

		$sql2 = mssql_query($query2);

			if($sql2){	

					//activitylog----------------------------------------------------------------------------------
						$actlog = mssql_query("INSERT INTO log_activity (activity,
																		menu,
																		kode,
																		status,
																		user_log,
																		date_log)values('$activity_add',
																						'pindah box',
																						'$kd_box',
																						'SUCCESS',
																						'$input_user',
																						convert(varchar(200),'$input_date'))");


					//---------------------------------------------------------------------------------------------

					$url    = "mid=pindahbox&alert=1";
				}else{
					$url    = "mid=pindahbox&alert=2";
				}
					
				$urlEnc = $edc->encrypt($url,true);
				echo $urlEnc;

		}


}

// ============================================================================================================



if($getact == 'ambilarsip'){

$kd_arsip 			=	$_POST['kd_arsip'];
$nama_pengambil 	=	$_POST['nama_pengambil'];
$keperluan 			=	$_POST['keperluan'];
$tgl_ambil 			=	DBDate($_POST['tgl_ambil']);
$tgl_kembali		=	DBDate($_POST['tgl_kembali']);
$id_pengambilan 	= 	$_POST['id_pengambilan'];
$status_ambil 		= 	'3'; //TAKED lihat ditable msstatus


	if($id_pengambilan == ""){

		$query	=	"INSERT INTO pengambilan(kd_arsip,
											   nama_pengambil,
												keperluan,
												tgl_ambil,
												status,
												log_user,
												log_date,
												last_update)VALUES('$kd_arsip',
																  	'$nama_pengambil',
																	'$keperluan',
																	'$tgl_ambil',
																	'$status_ambil',
																	'$input_user',
																	'$input_date',
																	'$last_update')";

		$status = $status_out;
		$url	= "mid=listarsip_detail&kd_arsip=".$kd_arsip."&alert=1";

	}else{
		$status_ambil = '4';

		$query	=	"UPDATE pengambilan SET tgl_kembali = '$tgl_kembali',
											status = '$status_ambil',
											last_update = '$last_update' 
											WHERE id_pengambilan ='".$id_pengambilan."'";
																

		$status = $status_in;
		$url	= "mid=pengambilan&alert=1";

	}

	$sql = mssql_query($query);

	//echo $query;

	if($sql){

		$update = "UPDATE arsip set status = '".$status."' WHERE kd_arsip ='".$kd_arsip."'";

		$sql2 = mssql_query($update);

	//activitylog----------------------------------------------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_add',
																		'arsip',
																		'$kd_arsip',
																		'SUCCESS',
																		'$input_user',
																		convert(varchar(200),'$input_date'))");
																		
		$urlEnc = $edc->encrypt($url,true);
		header("location:../main.php?".$urlEnc."");
	}

}



//---------------------------------- ALOKASI ARSIP ---------------------------------------------

if($postact == 'addLocated'){


$kd_box 		=	$_POST['kd_box'];
$kd_uker 		=	$_POST['uker'];
$createdDate    =	$_POST['crdate'];
$arsip_file 	= 	$_POST['docname'];
$no_scan        =   $_POST['scan_no'];
$namaLen 		=   strlen($arsip_file);
$getNama 		=   $namaLen-4;
$nama_arsip 	=   substr($arsip_file,0,$getNama);

$queScan = mssql_query("SELECT fileSource,kategori FROM arsip_scan where scanno = '".$no_scan."'");
$sqlScan = mssql_fetch_assoc($queScan);

if($sqlScan['fileSource'] == '1'){
	$deskripsi 		=   "Upload Document";
	$kd_kategori	=	$sqlScan['kategori'];
}else{
	$deskripsi 		=   "scanned archive";
	$kd_kategori	=	$_POST['kategori'];
}

//$dateNow 		=   date('d/m/Y');
$kd_arsip		=	arsipcode2();

//---------------------------- untuk link qrcode --------------------------------
$ID     		= $kd_arsip;
$hasil_encrypt  = $edc->encrypt($ID , true);
$url      		= "http://portal.brins.co.id/e_filing/view/qrarsip_result.php?id=";
$link_qrcode 	= $url.$hasil_encrypt."";
//-------------------------------------------------------------------------------
			
	$query	=	"INSERT INTO arsip(kd_arsip,
									kd_box,
									kd_kategori,
									kd_uker,
									nama_arsip,
									deskripsi,
									tgl_terbit,
									tgl_masuk,
									status,
									no_scan,
									arsip_file,
									link_qrcode,
									input_user,
									input_date,
									last_update,
									savehardcopy)VALUES('$kd_arsip',
														'$kd_box',
														'$kd_kategori',
														'$kd_uker',
														'$nama_arsip',
														'$deskripsi ',
														'$createdDate',
														'$createdDate',
														'$status_in',
														'$no_scan',
														'$arsip_file',
														'$link_qrcode',
														'$input_user',
														'$input_date',
														'$last_update',
														'1')";


		$ket   = $activity_add;

		$sql = mssql_query($query);

	//echo $query;

	if($sql){

	//activitylog----------------------------------------------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$ket',
																		'arsip',
																		'$kd_arsip',
																		'SUCCESS',
																		'$input_user',
																		convert(varchar(200),'$input_date'))");


	//---------------------------------------------------------------------------------------------
		$url    = "mid=alocated&alert=1&ket=dialokasikan";
	}else{
		$url    = "mid=alocated&alert=2&ket=dialokasikan";
	}
		
	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;


}


//-----------------------------ADD MULTI ALOCATED---------------------------------------




if($postact == 'add_multiLocated'){

	$jmlcek			= $_POST['jmlcek'];
	$kd_box 		= $_POST['kd_box'];

	$kd_kategori	= explode(',',$_POST['kategori']);
	$kd_uker 		= explode(',',$_POST['uker']);
	$createdDate    = explode(',',$_POST['crdate']);
	$arsip_file 	= explode(',',$_POST['docname']);
	$no_scan        = explode(',',$_POST['scan_no']);
	

	for($x=1;$x<=$jmlcek;$x++){

		$i = $x - 1;

		//echo "no_scan =".$no_scan[$i]." <br><br>";
		//echo $kd_kategori[$i]."<br><br>";
		// echo $kd_uker[$i]."<br><br>";
		// echo $createdDate[$i]."<br><br>";
		// echo $arsip_file[$i]."<br><br>";

		$namaLen 		=   strlen($arsip_file[$i]);
		$getNama 		=   $namaLen-4;
		$nama_arsip 	=   substr($arsip_file[$i],0,$getNama);

		//$dateNow 		=   date('d/m/Y');
		$kd_arsip		=	arsipcode2();

		$queScan = mssql_query("SELECT fileSource,kategori FROM arsip_scan where scanno = '".$no_scan[$i]."'");
		$sqlScan = mssql_fetch_assoc($queScan);

		if($sqlScan['fileSource'] == '1'){
			$deskripsi 		=   "Upload Document";
			$kd_kategori	=	$sqlScan['kategori'];
		}else{
			$deskripsi 		=   "scanned archive";
			$kd_kategori	=	$kd_kategori[$i];
		}
		
		//---------------------------- untuk link qrcode --------------------------------
		$ID     		= $kd_arsip;
		$hasil_encrypt  = $edc->encrypt($ID , true);
		$url      		= "http://portal.brins.co.id/e_filing/view/qrarsip_result.php?id=";
		$link_qrcode 	= $url.$hasil_encrypt."";
		//-------------------------------------------------------------------------------
					
			$query	=	"INSERT INTO arsip(kd_arsip,
											kd_box,
											kd_kategori,
											kd_uker,
											nama_arsip,
											deskripsi,
											tgl_terbit,
											tgl_masuk,
											status,
											no_scan,
											arsip_file,
											link_qrcode,
											input_user,
											input_date,
											last_update,
											savehardcopy)VALUES('$kd_arsip',
																'$kd_box',
																'$kd_kategori',
																'$kd_uker[$i]',
																'$nama_arsip',
																'$deskripsi ',
																'$createdDate[$i]',
																'$createdDate[$i]',
																'$status_in',
																'$no_scan[$i]',
																'$arsip_file[$i]',
																'$link_qrcode',
																'$input_user',
																'$input_date',
																'$last_update',
																'1')";
		
				$ket   = $activity_add;
				$sql = mssql_query($query);
			
				//echo $query;
		
			if($sql){
		
			//activitylog----------------------------------------------------------------------------------
				$actlog = mssql_query("INSERT INTO log_activity (activity,
																menu,
																kode,
																status,
																user_log,
																date_log)values('$ket',
																				'arsip',
																				'$kd_arsip',
																				'SUCCESS',
																				'$input_user',
																				convert(varchar(200),'$input_date'))");
		
		
			//---------------------------------------------------------------------------------------------
				$url    = "mid=alocated&alert=1&ket=dialokasikan";
			}else{
				$url    = "mid=alocated&alert=2&ket=dialokasikan";
			}
		}

		$urlEnc = $edc->encrypt($url,true);
		echo $urlEnc;
	
	
	}


//---------------------------------------------	 ADD ARSIP DETAIL ---------------------------------------

// if($getact == 'adddetail'){

// 	$jumlah_detail = $_POST['jumlah_detail'];

// 	$getkode 	=	explode(" - ",$_POST['kd_arsip']);
// 	$kd_arsip 	=	$getkode[0];

// 	for($i=1;$i<=$jumlah_detail;$i++){

// 			$query = "INSERT INTO arsip_detail (kd_arsip,
// 												no_doc,
// 												tgl_doc,
// 												dari,
// 												kepada,
// 												input_user,
// 												input_date) VALUES('$kd_arsip',
// 																	'".$_POST["no_doc".$i]."',
// 																	'".date("d-m-Y", strtotime($_POST["tgl_doc".$i]))."',
// 																	'".$_POST["dari".$i]."',
// 																	'".$_POST["kepada".$i]."',
// 																	'$input_user',
// 																	'$input_date')";

// 		$sql = mssql_query($query);

// 		if($sql){

// 		//activitylog----------------------------------------------------------------------------------
// 			$actlog = mssql_query("INSERT INTO log_activity (activity,
// 															menu,
// 															kode,
// 															status,
// 															user_log,
// 															date_log)values('$activity_add',
// 																			'arsip_detail',
// 																			'".$kd_arsip." / ".$_POST["no_doc".$i]."',
// 																			'SUCCESS',
// 																			'$input_user',
// 																			convert(varchar(200),'$input_date'))");

// 		//---------------------------------------------------------------------------------------------
// 		}

// 		if($i == $jumlah_detail){
// 			$complete = '1';
// 		}

// 	}
// 		if($complete == '1'){
// 			echo "<script type='text/javascript'>alert('Data Successfully Saved');window.location='../main.php?mid=listarsip_detail&kd_arsip=$kd_arsip';</script>";
// 		}else{
// 			echo "<script type='text/javascript'>alert('Sory, data Unsuccessfully Saved');window.location='../main.php?mid=addarsip_detail';</script>";
// 		}
// }


// //---------------------------------------------	 EDIT ARSIP DETAIL ---------------------------------------

// if($getact == 'editdetail'){

// 		$id 		= $_POST['id'];
// 		$kd_arsip 	= $_POST['kd_arsip'];

// 		$query = "UPDATE arsip_detail SET no_doc = '".$_POST["no_doc"]."',
// 											tgl_doc = '".date("d-m-Y", strtotime($_POST["tgl_doc"]))."',
// 											dari = '".$_POST["dari"]."',
// 											kepada = '".$_POST["kepada"]."',
// 											input_user = '$input_user',
// 											input_date = '$input_date'
// 											WHERE id_arsip_detail = '".$id."'";
																
													
// 		$sql = mssql_query($query);

// 		if($sql){

// 		//activitylog----------------------------------------------------------------------------------
// 			$actlog = mssql_query("INSERT INTO log_activity (activity,
// 															menu,
// 															kode,
// 															status,
// 															user_log,
// 															date_log)values('$activity_add',
// 																			'arsip_detail',
// 																			'".$kd_arsip." / ".$_POST["no_doc".$i]."',
// 																			'SUCCESS',
// 																			'$input_user',
// 																			convert(varchar(200),'$input_date'))");

// 		//---------------------------------------------------------------------------------------------
// 			echo "<script type='text/javascript'>alert('Data Successfully Saved');window.location='../main.php?mid=listarsip_detail&kd_arsip=$kd_arsip';</script>";
// 			//echo $query;
// 		}else{
// 			echo "<script type='text/javascript'>alert('Sory, data Unsuccessfully Saved');window.location='../main.php?mid=addarsip_detail';</script>";
// 			//echo $query;
// 		}
			
// }


// //---------------------------------------------------- DELETE arsip ---------------------------------------
// if($getact == 'delarsip_detail'){

// $id			=  $_GET['id'];
// $kd_arsip	=  $_GET['kd_arsip'];

// $sql	=  mssql_query("DELETE FROM arsip_detail WHERE id_arsip_detail	= '".$id."'");
			
			
// 		if($sql){
// 		 //activitylog----------------------------------------------------------------------------------
// 				$actlog = mssql_query("INSERT INTO log_activity (activity,
// 																menu,
// 																kode,
// 																status,
// 																user_log,
// 																date_log)values('$activity_del',
// 																				'arsip',
// 																				'".$kd_arsip." / ".$id."',
// 																				'SUCCESS',
// 																				'$input_user',
// 																				convert(varchar(200),'$input_date'))");

// 			//---------------------------------------------------------------------------------------------

// 			header("location:../main.php?mid=listarsip_detail&alert=1&kd_arsip=".$kd_arsip."");

// 				// echo "INSERT INTO log_activity (activity,
// 				// 												menu,
// 				// 												kode,
// 				// 												status,
// 				// 												user_log,
// 				// 												date_log)values('$activity_del',
// 				// 																'arsip',
// 				// 																'".$kd_arsip." / ".$id."',
// 				// 																'SUCCESS',
// 				// 																'$input_user',
// 				// 																convert(varchar(200),'$input_date'))";
// 		}else{
// 			header("location:../main.php?mid=listarsip_detailp&alert=2");
// 		}

// }
//-------------------------------------------------------------------------------------------------------------

?>