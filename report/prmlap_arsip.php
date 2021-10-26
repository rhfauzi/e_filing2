<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 

<script>
$(document).ready(function() {

	$("#kd_rak").attr("disabled",true);
	$("#kd_box").attr("disabled",true);

	//--------------------COMBO BOX CHANGE VALUE TYPE----------------------------

	// $("#kd_kategori").change(function(){
	// 	    var kd_kategori = $("#kd_kategori").val();
	// 	    $.ajax({
	// 	        url: "pages/procombox.php?act=type",
	// 	        data: "kd_kategori=" + kd_kategori,
	// 	        success: function(data){
	// 	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	// 	            $("#kd_type").html(data);
	// 	            //alert(data);
	// 	        }
	// 	    });
	// 	});

	//--------------------COMBO BOX CHANGE VALUE RAK----------------------------

	// $("#kd_lokasi").change(function(){
	// 	    var kd_lokasi = $("#kd_lokasi").val();
	// 	    $.ajax({
	// 	        url: "pages/procombox.php?act=rak",
	// 	        data: "kd_lokasi=" + kd_lokasi,
	// 	        success: function(data){
	// 	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	// 	            $("#kd_rak").html(data);
	// 	            //alert(data);
	// 	        }
	// 	    });
	// 	});


	//--------------------COMBO BOX CHANGE VALUE BOX----------------------------

	$("#kd_rak").change(function(){
		    var kd_rak = $("#kd_rak").val();
		    $.ajax({
		        url: "pages/procombox.php?act=box",
		        data: "kd_rak=" + kd_rak,
		        success: function(data){
		            // jika data sukses diambil dari server, tampilkan di <select id=kota>
		            $("#kd_box").attr("disabled",false);
		            $("#kd_box").html(data);
		            //alert(data);
		        }
		    });
		});

var year = (new Date()).getFullYear() + 10

	$("#tgl_awal").datepicker({
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year
	});

	$("#tgl_akhir").datepicker({
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year
	});
});

// function validate(form1)
// {
// 	if(form1.tgl_awal.value != ""){
// 		if(form1.tgl_akhir.value == "" || form1.tgl_akhir.value== null){
// 			alert("Range Tanggal Kedua Harus diisi !");form1.tgl_akhir.focus();return(false);
// 		}
// 	}

// 	if(form1.tgl_akhir.value != ""){
// 		if(form1.tgl_awal.value == "" || form1.tgl_awal.value== null){
// 			alert("Mohon isi Range Tanggal Pertama terlebih dahulu !");form1.tgl_awal.focus();return(false);
// 		}
// 	}

// }

function showmodal(){
    $("#myModal").modal();
}

</script>

<br>
<div class="panel panel-default">
<div class="panel-heading">Parameter Laporan Arsip</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Report <i class="fa fa-arrow-right"></i>&nbsp; Laporan Arsip</i></div><br>

<?php
	$url 	= "mid=reslaparsip";
	$urlEnc = $edc->encrypt($url,true);
?>
<form name="form1" method="POST" action="main.php?<?php echo $urlEnc; ?>" onsubmit="return validate(this)">
<center>
<table width="100%" border="0px">
	<tr>
		<td width="15%">Kategori</td>
		<td width="35%">
		<select id='kd_kategori' name="kd_kategori" class="form-control ukuran8">
		<option value='0'>Semua Kategori</option>
		<?php
		$sqlkategori = mssql_query("SELECT distinct kd_kategori FROM arsip where kd_kategori != ''");
		while($reskat = mssql_fetch_assoc($sqlkategori)){
			echo"
				<option value='".$reskat['kd_kategori']."'>".$reskat['kd_kategori']."</option>
			";
		}
		?>
		</select>
		</td>
		<td>Lokasi</td>
		<td>
		<input readonly type='text' id='kd_lokasi' name='kd_lokasi' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
		<td>Unit Kerja</td>
		<td>
		<select id='kd_uker' name="kd_uker" class="form-control ukuran8">
		<option value='0'>Semua Unitkerja</option>
		<?php
		$sqlkategori = mssql_query("SELECT distinct kd_uker FROM arsip");
		while($reskat = mssql_fetch_assoc($sqlkategori)){
			echo"
				<option value='".$reskat['kd_uker']."'>".$reskat['kd_uker']."</option>
			";
		}
		?>
		</select>
		</td>
		<td>Rak</td>
		<td colspan="2">
		<select id='kd_rak' name="kd_rak" class="form-control ukuran8">
		<option value='0'>Semua Rak</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
		<td colspan="2"></td>
		<td>Box</td>
		<td colspan="2">
		<select id='kd_box' name="kd_box" class="form-control ukuran8">
		<option value='0'>Semua Box</option>
		</select>
		</td>
	</tr>
	<tr><td height="30px" colspan="5"></td></tr>
	<tr>
		<td colspan="5" align="center"><h4>Tanggal Masuk</h4></td>
	</tr>
	<tr><td height="10px" colspan="5"><hr></td></tr>
	<tr>
		<td>Dari / Lebih dari</td>
		<td>
		<input type='text' id='tgl_awal' name="tgl_awal" class="form-control ukuran5" placeholder="dd/mm/yyyy" readonly style="background-color: #fff8bc;cursor: text;">
		</td>
		<td>Sampai / Kurang dari</td>
		<td colspan="2">
		<input type='text' id='tgl_akhir' name="tgl_akhir" class="form-control ukuran5" placeholder="dd/mm/yyyy" readonly style="background-color: #fff8bc;cursor: text;">
		</td>
	</tr>
	<tr><td height="20px" colspan="5"></td></tr>
	<tr><td colspan="5" align="center"><input type="submit"  name="submit" value="Proses" class="page gradient"></td></tr>
</table>
<form>
</center>

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
	        	~ Pilih parameter - parameter yang ingin ditampilikan sebagai acuan untuk hasil reporting <br>
	        	~ Pilih range tanggal untuk menentukan data pada range tanggal tertentu dari tanggal masuk. jika tanggal awal dan akhir dikosongkan keduanya maka tidak ada batasan tanggal, jika hanya tanggal awal yang ditentukan maka data yang muncul akan lebih dari tanggal tersebut, jika hanya tanggal akhir yang diisi maka data yang muncul akan kurang dari tanggal tersebut 
	        </p>
	    </div>
	</div>
	</div>

<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog" style="width: 800px">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan pemindahan Arsip</h4>
      <!-- <div style="float: right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Action</th>
                    <script>
                        // function pilih_kosong2(){
                        //    document.getElementById('').value='';
                        // } 
                    </script>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
				
                     $query  =   mssql_query("SELECT * FROM mslokasi");
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $kd_lokasi  =   $data[kd_lokasi];
                            $lokasi  	=   $data[lokasi];
                            
                ?>
                    <td width="10%" align="center"><? echo $no; ?></td>
                    <td width="20%"><? echo $kd_lokasi ?></td>
                    <td width="55%"><? echo $lokasi; ?></td>
                    <td width="15%" align="center">
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_data2('<?php echo $kd_lokasi; ?>');ganti();">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_data2(a){
                               document.getElementById('kd_lokasi').value=a;
                            } 

                            function ganti(){
                            	var kd_lokasi = $("#kd_lokasi").val();
                            	var kd_box = $("#kd_box").val();
							    $.ajax({
							        url: "pages/procombox.php?act=rak2",
							        data: "kd_lokasi=" + kd_lokasi,
							        success: function(data){
							            // jika data sukses diambil dari server, tampilkan di <select id=kota>
							            $("#kd_rak").attr("disabled",false);
							            $("#kd_rak").html(data);
							            $("#kd_box").val("");
							            $("#kd_box").attr("disabled",true);
							            // alert(data);
							        }
							    });
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
