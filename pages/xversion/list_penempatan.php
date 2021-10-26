
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
	<!-- <link href="css/sb-admin-2.css" rel="stylesheet"> -->
</head>

<script>
$(document).ready(function() {

	$("#actBtn").attr('disabled',true);
	$("#actSelect").change(function(){
		var	actSelect = $("#actSelect").val();
		
		//jika select pilihan 'cek semua'
		if(actSelect == 1){
			$("#actBtn").attr('disabled',false);
            $(".locate_button").attr('disabled',true);
			$('input:checkbox').prop('checked',true);
		}else{
			//jika set pilihan 'uncek semua' maka pilihan kembali ke pilihan 'pilih'
			if(actSelect == 2){ 
				$('select').prop('selectedIndex',0);
			}
			$("#actBtn").attr('disabled',true);
            $(".locate_button").attr('disabled',false);
			$('input:checkbox').prop('checked',false);
		}
	});

	//jika ada cekbox yang tercentang maka button 'proses terpilih' enabled
	//sebaliknya jika tidak ada cekbox yang tercentang maka button 'proses terpilih' disabled
	var ckbox = $('.ck');

    $('input').on('click',function () {
        if (ckbox.is(':checked')) {
            $("#actBtn").attr('disabled',false);
            $(".locate_button").attr('disabled',true);
        } else {
            $("#actBtn").attr('disabled',true);
            $(".locate_button").attr('disabled',false);
			$('select').prop('selectedIndex',0);
        }
    });


});
</script>
<body>
<br>
<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>SUCCESS !</strong> Data berhasil <?php echo $isiParam2; ?>. 
            Silakan Lihat pada menu 
            <?php
            $url    = "mid=listarsip";
            $urlEnc = $edc->encrypt($url,true);
            echo "<a href='main.php?".$urlEnc."'>Data Arsip</a>";
            ?>
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>DENIED !</strong> mohon maaf, Data gagal <?php echo $isiParam2; ?>. mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pengalokasian arsip</h3>
<h4 style="color: #777777;">Data hasil scan yang arsip fisiknya belum ditentukan tempatnya</h4>
<div style="float:right;">
</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pengalokasian</i></div><br>
<?php
    $url = "mid=formlokmulti";
    $urlEnc = $edc->encrypt($url,true);
?>
<div class="dataTables_filter formsrc">
    <form action="main.php?mid=alocated" method="POST">
        <label style="display: inline-flex;">
            <input type="search" class="form-control input-sm" placeholder="" aria-controls="DataArsip" style="width: 250px" name="search" value="<?php if(isset($_POST['search'])){ echo $_POST['search']; } ?>">
        </label>
        <input type="submit" class="btnok" value="Search">
    </form>
</div>
<form name="form_scan" method="post" action="<?php echo 'main.php?'.$urlEnc;?>" enctype='multipart/form-data'>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example4 DataArsip"> 
	<thead> 
		<?php
		if(in_array($level,$arr_group_editor)){
		?>
		<tr>
			<td colspan="7">
				<table border="0px" width="100%">
				<tr>
					<td width='8%'>action check</td>
					<td width='3%' align="center">:</td>
					<td width="20%">
					<select class="form-control" id='actSelect'>
						<option value='0'>-Pilih-</option>
						<option value='1'>Check Semua</option>
						<option value='2'>UnCheck Semua</option>
					</select>
					</td>
					<td width="50%">
                    </td>
					<td width="13%" align="right">
						<input class="btn btn-primary" type=submit title='proses ini akan mengeksekusi data yang terceklist' value='Proses Terpilih' id='actBtn' name="actBtn">
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<?php
		}
		?>
		<tr> 
			<th width="5%">No</th> 
			<th width="10%">No Scan</th>
            <th width="15%">Nama File</th>
            <th width="8%">Jml Hal</th>
			<th width="30%">Keterangan</th>
            <th width="10%">Tgl Scan</th>
			<?php if(in_array($level,$arr_group_editor)){?>
                <th width="10%">Aksi</th>
            <?php } ?>  
		</tr> 
	</thead>
	<tbody>
		<?php
        if(isset($_POST['search'])){
			$sql = mssql_query("SELECT * FROM arsip_scan 
            where scanNo not in (select no_scan from arsip where no_scan is not null) AND (
                scanNo LIKE '%".$_POST['search']."%'
                OR docFileName LIKE '%".$_POST['search']."%'
                OR isi_index2 LIKE '%".$_POST['search']."%'
                OR fileContent LIKE '%".$_POST['search']."%'
            )
            order by id desc");
        }else{
			// $sql = mssql_query("SELECT * FROM arsip_scan where scanNo not in (select no_scan from arsip where no_scan is not null) order by id desc");
			$sql = mssql_query("SELECT scanNo,docFileName,unitKerja,docPageCount,isi_index2,createdDate,kategori FROM arsip_scan where scanNo not in (select no_scan from arsip where no_scan is not null) order by id desc");
        }
			$no = 1;
			while($res = mssql_fetch_assoc($sql)){

				if(in_array($level,$arr_group_editor)){
				$cekBox = "<div style='float:right'>
							<label class='ckbox'>
							<input type='checkbox' name='chk_$no' id='chk_od$no' class='ck' value='1'>
							<span class='checkmark'></span>
							</label>
							<input type='hidden' name='jml[]'></div>";
				}

				$urlDetail    = "mid=preview_scan&scanNo=".$res['scanNo'];
				$urlDetailEnc = $edc->encrypt($urlDetail,true);
				$docFileName  = "<a href='main.php?".$urlDetailEnc."'>
									<img src='images/detail.png' width='10%'>".$res['docFileName']."
								</a>";

				$urlEnc = $edc->encrypt($url,true); 
				$urlEnc = $url; 
				$located  = "<a style='text-decoration:none;' href='main.php?".$urlEnc."'>
				<input class='btn btn-info btn-xs locate_button'  type=button value='ALOKASIKAN'></a>";

				echo"
				<tr>
				<td>".$no." ".$cekBox."</td>
				<td><input type='hidden' name='scanno_$no' value='".$res['scanNo']."'>".$res['scanNo']."</td>
				<td><input type='hidden' name='docname_$no' value='".$res['docFileName']."'>".$docFileName."</td>
				<td align='center'><input type='hidden' name='uker_$no' value='".$res['unitKerja']."'>".$res['docPageCount']."</td>
				<td>".$res['isi_index2']."</td>
				<td><input type='hidden' name='crdate_$no' value='".$res['createdDate']."'>".$res['createdDate']."</td>
				";
				if(in_array($level,$arr_group_editor)){
				echo"
				<td><input type='hidden' name='kategori_$no' value='".$res['kategori']."'>".$located."</td>
				</tr>
				";
				}
			$no++;
			}
		?>
	</tbody>
</table>
</form>

<div class="col-lg-13">
    <div class="panel panel-info">
        <div class="panel-heading">
            Informasi
        </div>
        <div class="panel-body" align="justify">
            <p style="font-size:12px">
                ~ <b>Daftar Penempatan</b> digunakan untuk melihat data-data arsip yang sudah diupload softcopynya namun hardcopynya belum ditempatkan
                <br>~ klik button <input class='btn btn-info btn-xs locate_button'  type=button value='ALOKASIKAN'> jika ingin menentukan lokasi hardcopy dari arsip.<br>
            </p>
        </div>
    </div>
</div>


</body>
</html>
