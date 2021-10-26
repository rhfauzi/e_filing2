<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 	

<script type='text/javascript'>

$(document).ready(function() {

	$('#jumlah_detail').attr("disabled",true);

	//-------------------------------- TANGGAL ------------------------------
	var year = (new Date()).getFullYear() + 10

		$("#tgl_doc").datepicker({
			// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
			dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year

		});

//---------------------------------------------------------------------------

});//end jquery document
</script>
<?php
$id = $_GET['id'];

$show = mssql_fetch_assoc(mssql_query("SELECT a.*,b.nama_arsip FROM arsip_detail a,arsip b WHERE a.kd_arsip = b.kd_arsip AND a.id_arsip_detail = '".$id."'"));

//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=msbox'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=msbox'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Arsip Detail
	<div style="float:right;">
			<input class="btn btn-info btn-sm" type=button value='Kembali' onclick='window.history.back()'>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Tambah Arsip Detail</i></div><br>
<form name='form1' id='form1' method='POST' action='execute/exc_program.php?act=editdetail'>
<table width="100%" border="0px">
	<tr>
		<td width="15%">Kode Arsip</td>
		<td width="35%">
		<input type='hidden' name='id' id='id' value='<?php echo $id ?>'>
		<input type='hidden' name='kd_arsip' id='kd_arsip' value='<?php echo $show['kd_arsip']; ?>'>
		<input readonly type='text' class="form-control ukuran10" value='<?php echo $show[kd_arsip]." - ".$show[nama_arsip]; ?>'>
		</td>
		<td width="20%"></td>
	</tr>
	<tr><td height="30px" colspan="5"></td></tr>
	<tr>
		<td colspan="5">
		<table width='100%' border='0px' style='border: 0.5px solid #999;'>
		<div id='form_detail'>
			
			<tr colspan='5' height='10px'></tr>
			<tr>
				<td width='10%' style='padding-left: 30px;'>No Document</td>
				<td width='20%'>
					<input type='text' id='no_doc' name='no_doc' class='form-control ukuran9' placeholder='Cth : ND/001/DIV/TSI/12/2018' value='<?php echo $show[no_doc]; ?>'></td>
				<td width='10%' style='padding-left: 30px;'>Tanggal Document</td>
				<td width='20%'>
				<div class='form-group input-group ukuran5' style='padding:10px 0 0 0;'>
				<span class='input-group-addon'><i class='fa fa-calendar-o'></i>
		        </span>
				<input type='text' id='tgl_doc' name='tgl_doc' placeholder='dd/mm/yyyy' value='<?php echo date("d/m/Y", strtotime($show[tgl_doc]));
; ?>' readonly class='form-control ukuran3' style='background-color: #fff8bc;cursor: text;'>
				</div>
				</td>
			</tr>
			<tr>
				<td style='padding-left: 30px;'>Dari</td>
				<td><input type='text' id='dari' name='dari' class='form-control ukuran9' placeholder='Cth : Divisi TSI' value='<?php echo $show[dari]; ?>'></td>
				<td style='padding-left: 30px;'>Kepada</td>
				<td><input type='text' id='kepada' name='kepada' class='form-control ukuran9' placeholder='Cth : Divisi Logistik' value='<?php echo $show[kepada]; ?>'></td>
			</tr>
			<tr colspan='5' height='20px'></tr>
		</div>
		</table>
		</td>
	</tr>
	<tr colspan='5' height='30px'></tr>
	<tr>
		<td></td>
		<td colspan='5' align="right">
			<button id='simpan' class="btn btn-outline btn-warning">Update</button>
		</td>
	</tr>	
</table>
</form>
<br>
</div>
</div>
</div>
</div>

	<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	~ Form tambah arsip digunakan untuk menambahkan data arsip.<br>
	        	~ Pilih lokasi penyimpanan terlebih dahulu (tentukan lokasi,rak dan box) sebelum memasuki form isiaan kelengkapan data arsip
	        </p>
	    </div>
	</div>
	</div>
</div>

<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Kode Arsip</h4>
    </div>
    <div class="modal-body">
      <p>Pilih Arsip.</p>
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Arsip</th>
                    <th>Nama Arsip</th>
                    <th>Action /<br /><a href="#" data-dismiss="modal" onclick="pilih_kosong()">Cancel</a></th>
                    <script>
                            function pilih_kosong(){
                               document.getElementById('').value='';
                            } 
                        </script>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
				
                     $query  =   mssql_query("SELECT * FROM arsip");
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $kd_arsip   =   $data[kd_arsip];
                            $nm_arsip   =   $data[nama_arsip];
                            $kd_lokasi  =	$data[kd_lokasi];
                            $kd_rak     =	$data[kd_rak];
                            $kd_box  	=	$data[kd_box];
                            
                ?>
                    <td><? echo $no; ?></td>
                    <td><? echo $kd_arsip ?></td>
                    <td><? echo $nm_arsip; ?></td>
                    <td>
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_data('<? echo $kd_arsip; ?>','<? echo $nm_arsip; ?>','<? echo $kd_lokasi; ?>','<? echo $kd_rak; ?>','<? echo $kd_box; ?>')">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_data(a,b,c,d,e){
                               var x = a+" - "+b;
                               document.getElementById('kd_arsip').value=x;
                               $('#jumlah_detail').attr("disabled",false);
                            } 
                        </script>                                      
                </tr>
                <?php
                    $no++;
                        }
                    }
                ?>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
