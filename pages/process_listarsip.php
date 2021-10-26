<?php
/* Database connection start */
    session_start();
    set_time_limit(0);

    include "../setting/koneksi.php";
    conDB('.','e_filing');
    /* Database connection end */
 
    include "../function/info.php";
    include "../function/check.php";
    include "../function/encdec.php";
    
    $userlogin =  $_SESSION['iduser'];
    //$userlogin = '5677';
    $userInfo = infolog($userlogin);
    $groupdesc  = $userInfo['groupdesc'];
    $level      = $userInfo['group'];
    $kodeunit   = $userInfo['KodeUnit'];
    $unitkerja  = $userInfo['UnitKerja']; //AMBIL DARI SIMSDM
    $kode_uker  = $userInfo['kode_uker']; //AMBIL DARI TABLE USERMENU
    $nm_pegawai = $userInfo['nm_pegawai'];
    $id_pegawai = $userInfo['id_pegawai'];
  
    $edc = new encdec();

    // 1 = superAdmin, 2 = pic , 3 = approver spv, 4 = aprover manager, 5= approver GM, 6 = viewer , 7 =audit,8 = pic plus
    $arr_group_viewer = array('6','7');
    $arr_group_editor = array('1','2','8');
    $arr_group_master = array('1','8'); 

$requestData = $_POST;

$func_que_arsip     = mainque_tbarsip();


$columns = array( 
    0 => 'id_arsip',
    1 => 'kd_arsip',
    2 => 'kd_kategori',
    3 => 'nama_arsip',
    4 => 'kd_lokasi',
    5 => 'kd_rak',
    6 => 'kd_box',
    7 => 'kd_uker',
    8 => 'status',
);

$start      = $requestData['start'];
$length     = $requestData['length'];

if($level == '6') //LEVEL PIC UNITKERJA
{
    $queryData = $func_que_arsip." AND kd_uker = '".$kode_uker."'";
}else{
    $queryData = $func_que_arsip;
}

// echo $queryData."<br>".$level."<br>";


$sql = "SELECT count(id_arsip) as jml_data FROM (".$queryData.") as x WHERE 1=1";

$query          = mssql_query($sql) or die("process_listarsip.php: get InventoryItems");
$res            = mssql_fetch_array($query);
$totalData      = $res['jml_data'];
$totalFiltered  = $totalData; 


if( !empty($requestData['search']['value'])) {
    // if there is a search parameter

    $sql = " SELECT ROW_NUMBER() OVER(ORDER BY id_arsip) AS Nomor, * 
                FROM (".$queryData.") as x
                WHERE 1=1 
                AND (
                    kd_arsip LIKE '%".$requestData['search']['value']."%'
                    OR nama_arsip LIKE '%".$requestData['search']['value']."%'
                    OR kd_kategori LIKE '%".$requestData['search']['value']."%'
                    OR kd_lokasi LIKE '%".$requestData['search']['value']."%'
                    OR kd_rak LIKE '%".$requestData['search']['value']."%'
                    OR kd_box LIKE '%".$requestData['search']['value']."%'
                    OR kd_uker LIKE '%".$requestData['search']['value']."%'
                )
            ";

    $query = mssql_query($sql) or die("ajax-grid-data.php: get PO");
    $totalFiltered = mssql_num_rows($query);  
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";

    $query=mssql_query($sql) or die("process_listarsip.php: get InventoryItems"); 
    //echo $sql;


}else {

    $sql =  "   SELECT ROW_NUMBER() OVER(ORDER BY id_arsip) AS Nomor, * FROM (".$queryData.") as x
                WHERE 1=1 
            ";
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
    //echo $sql;
    $query=mssql_query($sql) or die("process_listarsip.php: get InventoryItems");
    
}
// $nomor=1;
$data = array();
$no = 1;

while( $res=mssql_fetch_array($query) ) {  // preparing an array

    //jika yang login super admin dan admin/PIC
    if(in_array($level,$arr_group_master)){
        if($res['status'] == '1'){   
        $urlUbah       = "mid=formEditArsip&id=".$res['id_arsip'];
        $urlUbahEnc    = $edc->encrypt($urlUbah,true); 
        $ubah  = "<a style='text-decoration:none;' href='main.php?".$urlUbahEnc."'>
        <input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
        $hapus = "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_program.php?act=delarsip&kd_arsip=".$res['kd_arsip']."')>
        <input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
        }else{
        $ubah  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
        $hapus = "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value='Hapus'>";   
        }
    }else{
        $ubah  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
        $hapus = "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value='Hapus'>";
    }

    $QueKat     = mssql_fetch_assoc(mssql_query("SELECT * FROM mskategori WHERE kd_kategori = '".$res['kd_kategori']."'"));
    $stat       = mssql_fetch_assoc(mssql_query("SELECT * FROM msstatus where id_status = '".$res['status']."'"));
    $queket     = mssql_fetch_assoc(mssql_query("SELECT top 1 isi_index2 FROM arsip_scan with (nolock) where scanNo = '".$res["no_scan"]."'"));

    $nomor          = $no;
    $url            = "mid=listarsip_detail&kd_arsip=".$res['kd_arsip'];
    $urlEnc         = $edc->encrypt($url,true);
    $kd_arsip       = "<a href='main.php?".$urlEnc."'>".$res["kd_arsip"]."</a>";
    $no_scan        = $res["no_scan"];
    $nama_arsip     = $res["nama_arsip"];
    $kd_kategori    = $res["kd_kategori"];
    $uker           = $res['kd_uker'];
    $kd_lokasi      = $res["kd_lokasi"];
    $kd_rak         = $res["kd_rak"];
    $kd_box         = $res["kd_box"];
    $keterangan     = $queket['isi_index2'];
    
    $status         = "<b><i ".$stat['style'].">".$stat['status']."</i></b>";

    //jika level super admin dan admin
    if(in_array($level,$arr_group_master)){
            $aksi  = "<td align='right'>".$ubah."&nbsp;".$hapus."</td>";
    }
 

    $nestedData     = array(); 
    $nestedData[]   = $nomor;
    $nestedData[]   = $kd_arsip." / ".$nama_arsip;
    $nestedData[]   = "(".$kd_kategori.") ".$keterangan;
    $nestedData[]   = $uker;

    if(!in_array($level,$arr_group_viewer)){
        $nestedData[]   = $kd_lokasi;
        $nestedData[]   = $kd_rak;
        $nestedData[]   = $kd_box;
    }

    $nestedData[]   = $status;
    $nestedData[]   = $aksi;
    
    //$nestedData[] = $id_arsip;
    //$nestedData[] = $sql;
    
    $data[] = $nestedData;

    $no++;

    
}


$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   
            "recordsTotal"    => intval( $totalData ),  
            "recordsFiltered" => intval( $totalFiltered ), 
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

?>
