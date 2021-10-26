<?php
/* Database connection start */
    session_start();
    set_time_limit(0);
    
    include "../setting/koneksi.php";
    conDB('.','e_filing');
    /* Database connection end */

    include "../function/info.php";
    include "../function/encdec.php";

    $userlogin =  $_SESSION['iduser'];
    //$userlogin = '5677';
    $userInfo   = infolog($userlogin);
    $level      = $userInfo['group'];
    $edc        = new encdec();

    // 1 = superAdmin, 2 = pic , 3 = approver spv, 4 = aprover manager, 5= approver GM, 6 = viewer , 7 =audit,8 = pic plus
    $arr_group_viewer = array('6','7');
    $arr_group_editor = array('1','2','8');
    $arr_group_master = array('1','8'); 


// storing  request (ie, get/post) global array to a variable  
$requestData = $_POST;


$columns = array( 
    0 => 'id_pengambilan',
    1 => 'kd_arsip'
    //7 => 'query'  
);



$start      = $requestData['start'];
$length     = $requestData['length'];


$sql = "SELECT count(id_pengambilan) as jml_data FROM pengambilan WHERE 1=1";

$query          = mssql_query($sql) or die("process_pengambilan.php: get InventoryItems");
$res            = mssql_fetch_array($query);
$totalData      = $res['jml_data'];
$totalFiltered  = $totalData; 


if( !empty($requestData['search']['value'])) {
    // if there is a search parameter
    $sql = " SELECT ROW_NUMBER() OVER(ORDER BY id_pengambilan) AS Nomor, * 
                FROM pengambilan
                WHERE 1=1 
                AND (
                    kd_arsip LIKE '%".$requestData['search']['value']."%'
                    OR nama_pengambil LIKE '%".$requestData['search']['value']."%'
                    OR keperluan LIKE '%".$requestData['search']['value']."%'
                    OR tgl_ambil LIKE '%".$requestData['search']['value']."%'
                    OR tgl_kembali LIKE '%".$requestData['search']['value']."%'
                )
            ";

    $query = mssql_query($sql) or die("ajax-grid-data.php: get PO");
    $totalFiltered = mssql_num_rows($query);  
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";

    $query=mssql_query($sql) or die("process_pengambilan.php: get InventoryItems"); 
    //echo $sql;


}else {

    $sql =  "SELECT ROW_NUMBER() OVER(ORDER BY id_pengambilan desc) AS nomor, * FROM pengambilan
                WHERE 1=1 
            ";
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
    //echo $sql;
    $query=mssql_query($sql) or die("process_pengambilan.php: get InventoryItems");
    
}
// $nomor=1;
$data = array();
$no = 1;

while( $res=mssql_fetch_array($query) ) {

  //jika yang login super admin dan admin/PIC
  
  if(in_array($level,$arr_group_editor)){
        if($res['status'] == '4'){//status DONE lihat table msstatus
            $masuk_kembali  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Masukan Kembali'>";
        }else{
            $url1     = "mid=pengambilan_arsip&kd_arsip=".$res['kd_arsip']."&id=".$res['id_pengambilan'];
            $urlEnc1  = $edc->encrypt($url1,true);
    
            $masuk_kembali  = "<a style='text-decoration:none;' href='main.php?".$urlEnc1."'>
            <input class='btn btn-outline btn-success btn-xs' type=button value='Masukan kembali'></a>";
        }
    }else{
        $masuk_kembali  = "";
    }

    $stat       = mssql_fetch_assoc(mssql_query("SELECT * FROM msstatus where id_status = '".$res['status']."'"));

    $nomor          = $res['nomor'];
    
	$url2     = "mid=listarsip_detail&kd_arsip=".$res['kd_arsip'];
	$urlEnc2  = $edc->encrypt($url2,true);
	
    $kd_arsip       = "<a href='main.php?".$urlEnc2."'>".$res["kd_arsip"]."</a>";
    $nama_pengambil = $res["nama_pengambil"];
    $keperluan      = $res["keperluan"];
    $tgl_ambil      = $res["tgl_ambil"];
    $tgl_kembali    = $res["tgl_kembali"];
    
    $status         = "<b><i ".$stat['style'].">".$stat['status']."</i></b>";
       
    $aksi  = "<td align='right'>".$masuk_kembali."</td>";

    $nestedData     = array();
    $nestedData[]   = $nomor;
    $nestedData[]   = $kd_arsip;
    $nestedData[]   = $nama_pengambil;
    $nestedData[]   = $keperluan;
    $nestedData[]   = $tgl_ambil;
    $nestedData[]   = $tgl_kembali;
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
