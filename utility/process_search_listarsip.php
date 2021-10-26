<?php
/* Database connection start */
    session_start();
    set_time_limit(0);


    include "../setting/koneksi.php";
    conDB('.','e_filing');
    /* Database connection end */


    $userlogin =  $_SESSION['iduser'];
    // if($userlogin == ''){
    //   header("location:../../portal.bsam/");
    // }
    include "../function/info.php";
    include "../function/check.php";
    $level = infolog($userlogin);



// mssql_query('SET ANSI_NULLS ON');
// mssql_query('SET ANSI_WARNINGS ON');


// storing  request (ie, get/post) global array to a variable  
$requestData = $_POST;

$func_que_arsip     = mainque_tbarsip();

$columns = array( 
    0 => 'id_arsip',
    1 => 'kd_arsip'
    //7 => 'query'  
);



$start      = $requestData['start'];
$length     = $requestData['length'];
// $stsAdmin   = statusAdmin($user_login);
// $stsUser    = userApproval($user_login);
// $branchID   = $requestData['branchID'];
// $sDate      = date("Y-m-d",strtotime($requestData['sDate']));
// $eDate      = date("Y-m-d",strtotime($requestData['eDate']));
// $statusData = $requestData['statusData'];
$kd_kategori = $_GET['kd_kategori'];
$kd_uker     = $_GET['kd_uker'];
$kd_lokasi   = $_GET['kd_lokasi'];
$kd_rak      = $_GET['kd_rak'];
$kd_box      = $_GET['kd_box'];
$jns_tgl     = $_GET['jns_tgl'];
$tgl_awal    = $_GET['tgl_awal'];
$tgl_akhir   = $_GET['tgl_akhir'];

if($kd_kategori == '0' || $kd_kategori == ''){$f_kat = "";}else{$f_kat = " AND kd_kategori = '".$kd_kategori."'";}

if($kd_uker == '0' || $kd_uker == ''){$f_uker = "";}else{$f_uker = " AND kd_uker = '".$kd_uker."'";}

if($kd_lokasi == '0' || $kd_lokasi == ''){$f_lok = "";}else{$f_lok = " AND kd_lokasi = '".$kd_lokasi."'";}

if($kd_rak == '0' || $kd_rak == ''){$f_rak = "";}else{$f_rak = " AND kd_rak = '".$kd_rak."'";}

if($kd_box == '0' || $kd_box == ''){$f_box = "";}else{$f_box = " AND kd_box = '".$kd_box."'";}

if($jns_tgl == '1'){
    $f_tgl = " AND tgl_terbit >= '".$tgl_awal."' AND tgl_terbit <= '".$tgl_akhir."'";
}else if($jns_tgl =='2'){
    $f_tgl = " AND tgl_masuk >= '".$tgl_awal."' AND tgl_masuk <= '".$tgl_akhir."'";
}else{
    $f_tgl = "";
}



$sql = "SELECT count(id_arsip) as jml_data FROM (".$func_que_arsip.") as x WHERE 1=1 ".$f_kat.$f_uker.$f_lok.$f_rak.$f_box.$f_tgl."";

$query          = mssql_query($sql) or die("process_listarsip.php: get InventoryItems");
$res            = mssql_fetch_array($query);
$totalData      = $res['jml_data'];
$totalFiltered  = $totalData; 


if( !empty($requestData['search']['value'])) {
    // if there is a search parameter

    $sql = " SELECT ROW_NUMBER() OVER(ORDER BY id_arsip) AS Nomor, * 
                FROM (".$func_que_arsip.") as x
                WHERE 1=1 
                ".$f_kat.$f_uker.$f_lok.$f_rak.$f_box.$f_tgl."
                AND (
                    kd_arsip LIKE '%".$requestData['search']['value']."%'
                    OR nama_arsip LIKE '%".$requestData['search']['value']."%'
                    OR kd_kategori LIKE '%".$requestData['search']['value']."%'
                    OR kd_lokasi LIKE '%".$requestData['search']['value']."%'
                    OR kd_rak LIKE '%".$requestData['search']['value']."%'
                    OR kd_box LIKE '%".$requestData['search']['value']."%'
                )
            ";

    $query = mssql_query($sql) or die("ajax-grid-data.php: get PO");
    $totalFiltered = mssql_num_rows($query);  
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";

    $query=mssql_query($sql) or die("process_listarsip.php: get InventoryItems"); 
    //echo $sql;


}else {

    $sql =  "   SELECT ROW_NUMBER() OVER(ORDER BY id_arsip) AS Nomor, * FROM (".$func_que_arsip.") as x
                WHERE 1=1 ".$f_kat.$f_uker.$f_lok.$f_rak.$f_box.$f_tgl."
            ";
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
    //echo $sql;
    $query=mssql_query($sql) or die("process_listarsip.php: get InventoryItems");
    
}

// $nomor=1;
$data = array();
$no = 1;

while( $res=mssql_fetch_array($query) ) {  // preparing an array

    //$res["tgl_terima_sppa"] ==''? $tgl_terima_sppa = '' : $tgl_terima_sppa = date("d/m/Y",strtotime($res["tgl_terima_sppa"]));

    // $nomor          =   $res["Nomor"];

    //jika yang login super admin dan admin/PIC
    if($level == '1' || $level == '2'){
        $ubah  = "<a style='text-decoration:none;' href='main.php?mid=addarsip_laststep&id_arsip=".$res['id_arsip']."'>
        <input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
        $hapus = "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_program.php?act=delarsip&kd_arsip=".$res['kd_arsip']."')>
        <input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
    }else{
        $ubah  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
        $hapus = "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value='Hapus'>";
    }

    $QueKat     = mssql_fetch_assoc(mssql_query("SELECT * FROM mskategori WHERE kd_kategori = '".$res['kd_kategori']."'"));
    $stat       = mssql_fetch_assoc(mssql_query("SELECT * FROM msstatus where id_status = '".$res['status']."'"));

    $nomor          = $no;
    $kd_arsip       = "<a href='main.php?mid=listarsip_detail&kd_arsip=".$res['kd_arsip']."'>".$res["kd_arsip"]."</a>";
    $nama_arsip     = $res["nama_arsip"];
    $kd_kategori    = $QueKat["nm_kategori"];
    $kd_lokasi      = $res["kd_lokasi"];
    $kd_rak         = $res["kd_rak"];
    $kd_box         = $res["kd_box"];
    
    $status         = "<b><i ".$stat['style'].">".$stat['status']."</i></b>";

    // if($level == '1' || $level == '2'){
            
    // $aksi  = "<td align='right'>".$ubah."&nbsp;".$hapus."</td>";
            
    // }
 

    $nestedData     = array(); 
    $nestedData[]   = $nomor;
    $nestedData[]   = $kd_arsip;
    $nestedData[]   = $nama_arsip;
    $nestedData[]   = $kd_kategori;
    $nestedData[]   = $kd_lokasi;
    $nestedData[]   = $kd_rak;
    $nestedData[]   = $kd_box;
    $nestedData[]   = $status;
    //$nestedData[]   = $aksi;
    

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
