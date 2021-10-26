<!-- <script src="plugin/pdfjs/src/pdf.js"></script>
<script src="plugin/pdfjs/src/pdf.worker.js"></script> -->


<?php

$kd_arsip = $isiParam1;

//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param2 == 'alert')
{	
	if($isiParam2 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>SUCCESS !</strong> Arsip berhasil dikeluarkan dari box, status menjadi 'OUT-BOX'. 
		</div>
	<?php
	}elseif($isiParam2 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>DENIED !</strong> mohon maaf, Data gagal diubah, mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------

    $QueInfo	=	mssql_fetch_assoc(mssql_query("".$func_que_arsip." AND kd_arsip = '".$kd_arsip."'"));


?>
<div style="float:right;width:18%;margin-left:2px;">
<h3>Detail Arsip</h3>
<table border="0px" width="100%">
<tr>
<td>
    <?php
    $url1     = "mid=listarsip";$urlEnc1  = $edc->encrypt($url1,true);
    $url2     = "mid=pencarian_arsip";$urlEnc2  = $edc->encrypt($url2,true);
    ?>
    <a id='tambah' href='main.php?<?php echo $urlEnc1; ?>'><input class='btn btn-primary' type=button value='Data Arsip'></a>
    <a id='cari' href='main.php?<?php echo $urlEnc2; ?>'><input class='btn btn-primary' type=button value='Pencarian'></a>
</td>
</tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr>
<td colspan="2">
<?php 
if($QueInfo['status'] == '2'){ //OUT-BOX keluar dari boc lihat table msstatus
echo "<a id='ambil' href='#'>
    <input class='btn btn-default disabled' style='width:97%;' type=button value='Pengambilan'>
    </a>";
}else{
    if(in_array($level,$arr_group_editor)){
    $url3     = "mid=pengambilan_arsip&kd_arsip=".$kd_arsip;
    $urlEnc3  = $edc->encrypt($url3,true);
    echo "<a id='ambil' href='main.php?".$urlEnc3."'>
            <input class='btn btn-info' style='width:97%;' type=button value='Pengambilan'></a>";
    }else{
    echo "<a id='ambil' href='#'>
    <input class='btn btn-default disabled' style='width:97%;' type=button value='Pengambilan'>
    </a>";
    }
}
?>

</td>
</tr>
</table>
<br>
<table class="table table-hover" border="0px" width="100%">                           
    <tbody>
        <tr class='info'>
            <td width="15%"><i class="fa fa-barcode fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Kode Arsip</b></td>
        </tr>
        <tr class='warning'>
            <td width="50%"><?php echo $kd_arsip; ?></td>
        </tr>
        <tr class='info'>
            <td width="15%"><i class="fa fa-tags fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Status</b></td>
        </tr>
        <tr class='warning'>
        <?php 
        $stat = mssql_fetch_assoc(mssql_query("SELECT * FROM msstatus where id_status = '".$QueInfo['status']."'"));
        ?>
            <td width="50%" <?php echo $stat['style'];?>><b><?php echo $stat['status']; ?></b></td>
        </tr>
        <tr class='info'>
            <td><i class="fa fa-bookmark fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Nama Arsip</b></td>
        </tr>
        <tr class='warning'>
            <td><?php echo $QueInfo['nama_arsip']; ?></td>
        </tr>
        <tr class='info'>
            <td><i class="fa fa-calendar fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Tanggal Masuk</b></td>
        </tr>
        <tr class='warning'>
            <td><?php echo ShortDate($QueInfo['tgl_masuk']); ?></td>
        </tr>
        <tr class='info'>
            <td width="15%"><i class="fa fa-university fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Lokasi</b></td>
        </tr>
        <tr class='warning'>
            <td><?php echo "(".$QueInfo['kd_lokasi'].") ".$QueInfo['lokasi']; ?></td>
        </tr>
        <?php 
        if(!in_array($level,$arr_group_viewer)){ ?>
        <tr class='info'>
            <td><i class="fa fa-tasks fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Rak</b></td>
        </tr>
        <tr class='warning'>
            <td><?php echo $QueInfo['kd_rak']; ?></td>
        </tr>
        <tr class='info'>
            <td><i class="fa fa-archive fa-1x" style="color:#616161;"></i>&nbsp;<b style="color:#707070;">Box</b></td>
        </tr>
        <tr class='warning'>
            <td><?php echo $QueInfo['kd_box']; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><a href='#' onclick='history.back();'>
            <input class='btn btn-primary' type=button style='width:100%' value='Kembali'></a></td>
        </tr>
        
    </tbody>
</table>
</div>

<?php
if($QueInfo['arsip_file'] != " "){

//$vPath = "http://192.168.14.97/PENGARSIPAN/ArchiveScan/".$QueInfo['arsip_file'];

$queCek = "SELECT TOP 1 docLocation,docFileName FROM arsip_scan with(nolock) WHERE scanNo = '".$QueInfo['no_scan']."'";
$resCek = mssql_fetch_assoc(mssql_query($queCek));

$path = $resCek['docLocation'];
$folderName = explode("\\",$path);
//echo $folderName[count($folderName)-1];


// $vPath = "http://192.168.14.97/PENGARSIPAN/".$folderName[count($folderName)-1]."/".$resCek['docFileName'];
//$vPath = "http://192.168.14.97/PENGARSIPAN/ArchiveScanKodak_i3450/".$resCek['docFileName'];

if(file_exists("../PENGARSIPAN/ArchiveScanKodak_i3450/".$resCek['docFileName']))
{
    $vPath = "http://192.168.14.97/PENGARSIPAN/ArchiveScanKodak_i3450/".$resCek['docFileName'];
}
else if(file_exists("../PENGARSIPAN//ArchiveScan/".$resCek['docFileName']))
{
    $vPath = "http://192.168.14.97/PENGARSIPAN/ArchiveScan/".$resCek['docFileName'];
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
