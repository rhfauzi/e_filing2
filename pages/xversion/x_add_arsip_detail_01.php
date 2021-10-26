<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 	

<script type='text/javascript'>

function showmodal(){
    $("#myModal").modal();
}


$(document).ready(function() {

	$('#jumlah_detail').attr("disabled",true);

	// $("#simpan").click(function(){
	// 	var	kd_lokasi	=	$("#kd_lokasi").val();
	// 	var	kd_rak		=	$("#kd_rak").val();

	// 	if(kd_lokasi == '0'){
	// 		window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
	// 	}else if(kd_rak == '0'){
	// 		window.alert('Mohon untuk memilih Kode Rak terlebih dahulu');
	// 	}else{

	// 		if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

	// 			$.ajax({
	// 				type: "POST",
	// 				data: "act=addbox&kd_rak="+kd_rak+"&kd_lokasi="+kd_lokasi,
	// 				url: "execute/exc_master.php",
	// 				success: function(data){
	// 					 $("#kd_lokasi").val("0");
	// 					 $("#kd_rak").val("0");

	// 					 if(data ==''){
	// 					 	window.location = 'main.php?mid=addbox&alert=1';
	// 					 }else{
	// 					 	window.location = 'main.php?mid=addbox&alert=2';
	// 					 }
	// 					 //alert(data);
	// 				}
	// 			});
	// 		}
	// 	}
	// });



//--------------------COMBO BOX CHANGE VALUE----------------------------

	$("#jumlah_detail").change(function(){
	    var jumlah_detail = $("#jumlah_detail").val();
	    $.ajax({
	        url: "pages/procombox.php?act=form_detail",
	        data: "jumlah_detail=" + jumlah_detail,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $("#form_detail").html(data);
	            //alert(data);
	        }
	    });
	});

	//-------------------------------- TANGGAL -----------------------------
	var year = (new Date()).getFullYear() + 10

		$("#tgl_doc").datepicker({
			// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
			dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year

		});

//---------------------------------------------------------------------------

});//end jquery document
</script>
<?php
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
<div class="panel-heading">Form Tambah Arsip Detail
	<div style="float:right;">
			<a href='main.php?mid=listarsip'><input class="btn btn-info btn-sm" type=button value='Data Arsip'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Tambah Arsip Detail</i></div><br>
<form name='form1' id='form1' method='POST' action='execute/exc_program.php?act=adddetail'>
<table width="100%" border="0px">
	<tr>
		<td width="15%">Kode Arsip</td>
		<td width="35%">
		<input readonly type='text' id='kd_arsip' name='kd_arsip' class="form-control ukuran10" placeholder="Klik tombol disebelah kanan untuk mencari data ->">
		</td>
		<td width="20%"><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal()">
		&nbsp;Click</a>
		</td>
		<td width="15%">Jumlah Detail</td>
		<td>
			<select name='jumlah_detail' id='jumlah_detail' class="form-control ukuran5">
				<?php
				$start = 0;
				$limit = 10;
				for($val =$start;$val<=$limit;$val++){
					echo "<option value='".$val."'>".$val."</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr><td height="30px" colspan="5"></td></tr>
	<tr>
		<td colspan="5">
		<table width='100%' border='0px' style='border: 0.5px solid #999;'>
		<div id='form_detail'>
			
			<!-- <tr><td colspan='5' style='text-align: center;background-color: #b4e0e7;color:#7e7e7e'>".$i."</td></tr>
			<tr colspan='5' height='10px'></tr>
			<tr>
				<td width='10%' style='padding-left: 30px;'>No Document</td>
				<td width='20%'><input type='text' id='no_doc' name='no_doc' class='form-control ukuran9' placeholder='Cth : ND/001/DIV/TSI/12/2018'></td>
				<td width='10%' style='padding-left: 30px;'>Tanggal Document</td>
				<td width='20%'>
				<div class='form-group input-group ukuran5' style='padding:10px 0 0 0;'>
				<span class='input-group-addon'><i class='fa fa-calendar-o'></i>
		        </span>
				<input type='text' id='tgl_doc' name='tgl_doc' placeholder='dd/mm/yyyy' readonly class='form-control ukuran3' style='background-color: #fff8bc;cursor: text;'>
				</div>
				</td>
			</tr>
			<tr>
				<td style='padding-left: 30px;'>Dari</td>
				<td><input type='text' id='dari' name='dari' class='form-control ukuran9' placeholder='Cth : Divisi TSI'></td>
				<td style='padding-left: 30px;'>Kepada</td>
				<td><input type='text' id='kepada' name='kepada' class='form-control ukuran9' placeholder='Cth : Divisi Logistik'></td>
			</tr>
			<tr colspan='5' height='20px'></tr> -->
		</div>
		</table>
		</td>
	</tr>
	<tr colspan='5' height='30px'></tr>
	<tr>
		<td></td>
		<td colspan='5' align="right">
			<button id='simpan' class="btn btn-outline btn-primary">Simpan</button>
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
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ <b>Form tambah arsip detail</b> digunakan untuk menambahkan data arsip detail seuai dengan <b>Kode Arsip</b> yang dipilih.<br>
	        	~ Pilih <b>Kode Arsip </b> yang telah terdaftar di sistem terlebih dahulu, kemudian pilih <b>Jumlah Detail</b> yang ingin diinput (dibatasi hingga 10 untuk meminimalisir beratnya proses load tampilan).
	        	~ Setelah memilih <b>Jumlah Detail</b> maka akan muncul form detail sebanyak jumlah detail yang dipilih.<br>
	        	~ Masukan <b> No Document, Dari ,Kepada, Tanggal Document</b> pada form detail.
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
