<?php
/* Database connection start */
    session_start();
    set_time_limit(0);
    
    // function conn() {
    //     mssql_select_db('e_filing',mssql_connect('.','',''));
    // }
    // conn();

    include "../setting/koneksi.php";
    kon_db();
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


$sql = "SELECT count(id_arsip) as jml_data FROM arsip WHERE 1=1";

$query          = mssql_query($sql) or die("process_pindaharsip.php: get InventoryItems");
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
                )
            ";

    $query = mssql_query($sql) or die("ajax-grid-data.php: get PO");
    $totalFiltered = mssql_num_rows($query);  
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";

    $query=mssql_query($sql) or die("process_pindaharsip.php: get InventoryItems"); 
    //echo $sql;


}else {

    $sql =  "   SELECT ROW_NUMBER() OVER(ORDER BY id_arsip) AS Nomor, * FROM (".$func_que_arsip.") as x
                WHERE 1=1 
            ";
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
    //echo $sql;
    $query=mssql_query($sql) or die("process_pindaharsip.php: get InventoryItems");
    
}
// $nomor=1;
$data = array();
$no = 1;

while( $res=mssql_fetch_array($query) ) {  // preparing an array

    $query  =   mssql_query("SELECT * FROM mslokasi");
    $no=1;
    if (mssql_num_rows($query)) {
        while ($data    =   mssql_fetch_assoc($query)) {
            $kd_lokasi  =   $data[kd_lokasi];
            $lokasi     =   $data[lokasi];

        ?>
        <script>                                                         
            function pilih_data2(a,b){
                var x = a + " / " + b;
               document.getElementById('LB').value=x;
            } 

            function ganti(){
                var LB = $("#LB").val();
                var BB = $("#BB").val();
                $.ajax({
                    url: "pages/procombox.php?act=rak2",
                    data: "kd_lokasi=" + LB,
                    success: function(data){
                        // jika data sukses diambil dari server, tampilkan di <select id=kota>
                        $("#RB").attr("disabled",false);
                        $("#RB").html(data);
                        $("#BB").val("");
                        $("#BB").attr("disabled",true);
                        //alert(data);
                    }
                });
            }
        </script>
    <?php
    $no++;
        }
    }
        


    $nomor          = $no;
    $kd_arsip       = $res['kd_arsip'];
    $nama_arsip     = $res['nama_arsip'];
    
    $action         = "<a href='#' data-dismiss='modal' onclick='pilih_data2('".$kd_lokasi."','".$lokasi."');ganti();'>Pilih</a>";


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
