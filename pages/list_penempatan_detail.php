<!-- <script src="plugin/pdfjs/src/pdf.js"></script>
<script src="plugin/pdfjs/src/pdf.worker.js"></script> -->

<?php
echo "<br>";
$scanNo = $isiParam1;

$queCek = "SELECT TOP 1 * FROM arsip_scan with(nolock) WHERE scanNo = '".$scanNo."'";
$resCek = mssql_fetch_assoc(mssql_query($queCek));

?>
<div style="float:right;width:18%;margin-left:2px;">
<h3>Preview Scan</h3>
<table class="table table-hover" border="0px" width="100%">                           
    <tbody>
        <tr class='info'>
            <td width="15%"><i class="fa fa-barcode fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Kode Scan</b></td>
        </tr>
        <tr class='warning'>
            <td width="50%" style="color:#888;"><?php echo $resCek['scanNo']; ?></td>
        </tr>
        <tr class='info'>
            <td width="15%"><i class="fa fa-bookmark fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Nama File</b></td>
        </tr>
        <tr class='warning'>
        <td width="50%" style="color:#888;"><?php echo $resCek['docFileName']; ?></td>
        </tr>
        <tr class='info'>
            <td><b style="color:#707070;"><i class="fa fa-sort-numeric-asc fa-1x" style="color:#616161;"></i>&nbsp;<b>Jumlah Halaman</b></td>
        </tr>
        <tr class='warning'>
        <td width="50%" style="color:#888;"><?php echo $resCek['docPageCount']; ?></td>
        </tr>
        <tr class='info'>
            <td><i class="fa fa-calendar fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Tanggal Scan</b></td>
        </tr>
        <tr class='warning'>
        <td width="50%" style="color:#888;"><?php echo $resCek['createdDate']; ?></td>
        </tr>
        <tr class='info'>
            <td width="15%"><i class="fa fa-university fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Unit Kerja</b></td>
        </tr>
        <tr class='warning'>
        <td width="50%" style="color:#888;"><?php echo $resCek['unitKerja']; ?></td>
        </tr>
        <tr>
            <td><a href='#' onclick='history.back();'>
            <input class='btn btn-primary' type=button style='width:100%' value='Kembali'></a></td>
        </tr>
    </tbody>
</table>
</div>

<?php

if($resCek['docFileName'] != " "){


//$vPath = "http://192.168.13.37/PENGARSIPAN/ArchiveScan/".$resCek['docFileName'];

$path = $resCek['docLocation'];
$folderName = explode("\\",$path);
//echo $folderName[count($folderName)-1];


//$vPath = "http://192.168.13.37/PENGARSIPAN/".$folderName[count($folderName)-1]."/".$resCek['docFileName'];
//$vPath = "http://192.168.13.37/PENGARSIPAN/ArchiveScanKodak_i3450/".$resCek['docFileName'];

if(file_exists("../PENGARSIPAN/ArchiveScanKodak_i3450/".$resCek['docFileName']))
{
    $vPath = "http://192.168.13.37/PENGARSIPAN/ArchiveScanKodak_i3450/".$resCek['docFileName'];
}
else if(file_exists("../PENGARSIPAN//ArchiveScan/".$resCek['docFileName']))
{
    $vPath = "http://192.168.13.37/PENGARSIPAN/ArchiveScan/".$resCek['docFileName'];
}
else if(file_exists("../PENGARSIPAN V2/".$resCek['docLocation']."/".$resCek['docFileName']))
{
    $vPath = "http://192.168.13.37/PENGARSIPAN V2/".$resCek['docLocation']."/".$resCek['docFileName'];
}else{
    $vPath = "null";
}


echo "<object type='application/pdf' width='80%' height='800px' data='".$vPath."#toolbar=0&navpanes=0&statusbar=0&messages=0'>
    <div class='alert alert-danger' style='width:80%;' align='center'>
    <p style='color:#999'>Mohon Maaf File Tidak Ditemukan</p>
    </div>
    <center>
    <img src='images/fileNotFound.jpg' width='50%' height='50%'>
    </center>
    </object>";

}else{

    echo "
    <div class='alert alert-danger' style='width:80%' align='center'>
    <p style='color:#999'>Mohon Maaf File Tidak Ditemukan</p>
    </div>
    <center>
    <img src='images/fileNotFound.jpg' width='50%' height='50%'>
    </center>";

}

echo "<i style='font-size:8px'>FileName : ".$QueInfo['arsip_file']." | Path : ".$vPath."</i><br><br>";
?>
