<?php
error_reporting(0);
require '../setting/koneksi.php';
require '../function/seqno.php';
require '../function/encdec.php';

conDB('.','e_filing');
session_start();
$postact = $_POST['act'];

$edc   =  new encdec();

$input_user 	  = $_SESSION['iduser'];
$logdate 		  = date('d-m-Y'); $logtime = date('H:i:s');
$input_date 	  = $logdate." | ".$logtime;
$last_update 	  = $input_user." | ".$input_date;
$activity_add     = 'TAMBAH';


if($postact == 'uploadscan1'){
    date_default_timezone_set("Asia/Bangkok");

    $tahun = $_POST["tahun"];

	$kd_arsip 		=	arsipcode2();
	$kd_box 		=	'';
    $kd_kategori	=	$_POST['kd_kategori'];
    $kd_uker 		=	$_POST['unit_kerja'];
    $createdDate    =	date("M d Y H:i:s");
    $arsip_file 	= 	$_POST['nm_documents'] . ".pdf";
    $saveHardcopy 	= $_POST["chk_hardcopy"];
    if($saveHardcopy == 1){ //simpan hardcopy
        //arsip no_scan = null
        //arsip_scan scanNo = isi
        $no_scan    =   '';
        $no_scan2    =   $_POST["no_document"];
        $id_status  =   1;
    }else{ //tidak simpan hardcopy
        //arsip no_scan = isi
        //arsip_scan scanNo = isi
        $no_scan    =   $_POST["no_document"];
        $no_scan2    =  $_POST["no_document"];
        $id_status  =   5;
    }
    
    // $namaLen 		=   strlen($arsip_file);
    // $getNama 		=   $namaLen-4;
    // $nama_arsip 	=   substr($arsip_file,0,$getNama);
    $nama_arsip 	=   $_POST['nm_documents'];
    $deskripsi 		=   "Upload Document";
    $fileSource = $_POST["file_source"];
    $filename = $_POST["filename"];


    //---------------------------- untuk link qrcode --------------------------------
    $ID     		= $kd_arsip;
    $hasil_encrypt  = $edc->encrypt($ID , true);
    $url      		= "http://portal.brins.co.id/e_filing/view/qrarsip_result.php?id=";
    $link_qrcode 	= $url.$hasil_encrypt."";
    // $link_qrcode 	=   "";
    //-------------------------------------------------------------------------------

    if($saveHardcopy == 0){
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
                                        saveHardcopy)
                                VALUES('$kd_arsip',
                                        '$kd_box',
                                        '$kd_kategori',
                                        '$kd_uker',
                                        '$nama_arsip',
                                        '$deskripsi ',
                                        '$tahun',
                                        '$tahun',
                                        '$id_status',
                                        '$no_scan',
                                        '$arsip_file',
                                        '$link_qrcode',
                                        '$input_user',
                                        '$input_date',
                                        '$last_update',
                                        '$saveHardcopy')";
		$ket   = $activity_add;

		$sql = mssql_query($query);
    }




    $lastid = mssql_fetch_assoc(mssql_query("select top(1) id from ARSIP_SCAN ORDER BY id DESC"));
    $newid = $lastid['id'] + 1;
    $docFileName 	=   $_POST['nm_documents'] . ".pdf";
    $docPageCount 	=   $_POST["total_pages"];
    $fileText 	=   "";
    $fileContent 	=  str_replace("'", "", $_POST['file_content']);
    $unitKerja 	=   "";
    $isi_index1 	=   $_POST['nm_documents'];
    $isi_index2 	=   $_POST['nm_documents'];
    $isi_index3 	=   date("Y");
    $isi_index4 	=   "";
    $isi_index5 	=   "";
    $isi_index6 	=   "";
    $isi_index7 	=   "";
    $isi_index8 	=   "";
    $isi_index9 	=   "";
    $isi_index10 	=   "";
    $index1 	=   "";
    $index2 	=   "Keterangan";
    $index3 	=   "Tanggal";
    $index4 	=   "Versi";
    $index5 	=   "Nama Aplikasi";
    $index6 	=   "No Berkas";
    $index7 	=   "";
    $index8 	=   "";
    $index9 	=   "";
    $index10 	=   "";
    $location 	=   date("Y_m");

	$query2	=	"INSERT INTO arsip_scan(
            id,
            scanNo,
            docLocation,
            docFileName,
            docPageCount,
            fileText,
            fileContent,
            createdDate,
            unitKerja,
            kategori,
            index1,
            index2,
            index3,
            index4,
            index5,
            index6,
            index7,
            index8,
            index9,
            index10,
            isi_index1,
            isi_index2,
            isi_index3,
            isi_index4,
            isi_index5,
            isi_index6,
            isi_index7,
            isi_index8,
            isi_index9,
            isi_index10,
            logDate,
            saveHardcopy,
            fileSource)
    VALUES($newid,
            '$no_scan2',
            '$location',
            '$docFileName',
            '$docPageCount',
            '$fileText',
            '$fileContent',
            '$createdDate',
            '$kd_uker',
            '$kd_kategori',
            '$index1',
            '$index2',
            '$index3',
            '$index4',
            '$index5',
            '$index6',
            '$index7',
            '$index8',
            '$index9',
            '$index10',
            '$isi_index1',
            '$isi_index2',
            '$isi_index3',
            '$isi_index4',
            '$isi_index5',
            '$isi_index6',
            '$isi_index7',
            '$isi_index8',
            '$isi_index9',
            '$isi_index10',
            '$createdDate',
            '$saveHardcopy',
            '$fileSource')";
    $sql2 = mssql_query($query2);


	if($sql2){
    // if($sql && $sql2){

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

        if($saveHardcopy == 0){ //tidak saveHardcopy
            $url    = "mid=upload_file&alert=1&ket=listarsip";

        }else{ //saveHardcopy
            $url    = "mid=upload_file&alert=1&ket=alocated";
        }
	}else{ //error simpan ke db
        $url    = "mid=upload_file&alert=2&ket=upload_file";
	}

	$urlEnc = "main.php?$url";
}

//-------------------------------------------------------------------------------------------------------------

?>
