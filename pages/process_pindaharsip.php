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
    $level    = $userInfo['group'];
    $edc = new encdec();


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


$sql = "SELECT count(id_arsip) as jml_data FROM arsip WHERE 1=1";

$query          = mssql_query($sql) or die("process_listarsip.php: get InventoryItems");
$res            = mssql_fetch_array($query);
$totalData      = $res['jml_data'];
$totalFiltered  = $totalData; 


if( !empty($requestData['search']['value'])) {
    // if there is a search parameter

    $sql = " SELECT ROW_NUMBER() OVER(ORDER BY id_arsip) AS Nomor, * 
                FROM (".$func_que_arsip.") as x
                WHERE 1=1 
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

    
    // <script>                                                         
    //     function pilih_data(a,b,c,d,e){
    //        var x = a+" - "+b;
    //        document.getElementById('kd_arsip').value=x;
    //        document.getElementById('LL').value=c;
    //        document.getElementById('RL').value=d;
    //        document.getElementById('BL').value=e;
    //     } 
    // </script>

    $nomor          = $no;
    $kd_arsip       = $res["kd_arsip"];
    $nama_arsip     = $res["nama_arsip"];
    $kd_lokasi      = $res["kd_lokasi"];
    $kd_rak         = $res["kd_rak"];
    $kd_box         = $res["kd_box"];
    
    $action         = '<a href="#" data-dismiss="modal" 
                     onclick="pilih_data(\''.$kd_arsip.'\',\''.$nm_arsip.'\',\''.$kd_lokasi.'\',\''.$kd_rak.'\',\''.$kd_box.'\')">Pilih</a>';
 

    $nestedData     = array(); 
    $nestedData[]   = $nomor;
    $nestedData[]   = $kd_arsip;
    $nestedData[]   = $nama_arsip;
    $nestedData[]   = $action;

    

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

