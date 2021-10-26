<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 

<script>
$(document).ready(function() {

	$("#kd_rak").attr("disabled",true);
	$("#kd_box").attr("disabled",true);
	$("#tgl_awal").attr("disabled",true);
	$("#tgl_akhir").attr("disabled",true);
	$("#tgl_awal").val("");
	//$("#tgl_awal").css('background-color', '#cccccc');
	$("#tgl_akhir").val("");
	//$("#tgl_akhir").css('background-color', '#cccccc');


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


	$("#jns_tgl").change(function(){
	    var jns_tgl = $("#jns_tgl").val();

	    if(jns_tgl == 0){
	    	$("#tgl_awal").attr("disabled",true);
	    	$("#tgl_akhir").attr("disabled",true);
	    	$("#tgl_awal").val("");
			$("#tgl_awal").css('background-color', '#efefef');
			$("#tgl_akhir").val("");
			$("#tgl_akhir").css('background-color', '#efefef');
	    }else{
	    	$("#tgl_awal").attr("disabled",false);
	    	$("#tgl_akhir").attr("disabled",false);
	    	$("#tgl_awal").val("");
			$("#tgl_awal").css('background-color', '#fff8bc');
			$("#tgl_akhir").val("");
			$("#tgl_akhir").css('background-color', '#fff8bc');
	    }
            
    
	});

var year = (new Date()).getFullYear() + 10

	$("#tgl_awal").datepicker({
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year
	});

	$("#tgl_akhir").datepicker({
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year
	});
});


function showmodal(){
    $("#myModal").modal();
}

</script>

<br>

<div class="panel panel-default">
<div class="panel-heading">Parameter Pencarian Data Arsip</div>
<div class="panel-body">
<div class="row">

<div class="col-lg-7">

<div><i class="ketmenu">Utility <i class="fa fa-arrow-right"></i>&nbsp; Advanced Search</i></div><br>
<?php
$url    = "mid=res_advc_sch";$urlEnc = $edc->encrypt($url,true);
?>
<form name="form1" method="POST" action="main.php?<?php echo $urlEnc; ?>" onsubmit="return validate(this)">
<center>
<table width="100%" border="0px">
	<tr>
		<td width="40%">Kategori</td>
		<td width="50%">
		<select id='kd_kategori' name="kd_kategori" class="form-control ukuran8">
		<option value='0'>Semua Kategori</option>
		<?php
		$sqlkategori = mssql_query("SELECT * FROM mskategori");
		while($reskat = mssql_fetch_assoc($sqlkategori)){
			echo"
				<option value='".$reskat['kd_kategori']."'>".$reskat['kd_kategori']." - ".$reskat['nm_kategori']."</option>
			";
		}
		?>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Unit Kerja</td>
		<td>
		<select id='kd_uker' name="kd_uker" class="form-control ukuran8">
		<option value='0'>Semua Unit Kerja</option>
			<option value="AKT">AKUTANSI</option>
			<option value="TSI">TSI</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Lokasi</td>
		<td>
		<input readonly type='text' id='kd_lokasi' name='kd_lokasi' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Rak</td>
		<td>
		<select id='kd_rak' name="kd_rak" class="form-control ukuran8">
		<option value='0'>Semua Rak</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Box</td>
		<td>
		<select id='kd_box' name="kd_box" class="form-control ukuran8">
		<option value='0'>Semua Box</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Cari Berdasarkan Tanggal</td>
		<td>
		<select id='jns_tgl' name="jns_tgl" class="form-control ukuran10">
		<option value='0'>Tidak Menggunakan Tanggal</option>
			<option value="1">Tanggal Fisik Arsip</option>
			<option value="2">Tanggal Input Sistem</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Dari / Lebih dari</td>
		<td>
		<input type='text' id='tgl_awal' name="tgl_awal" class="form-control ukuran5" placeholder="dd/mm/yyyy" readonly>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Sampai / Kurang dari</td>
		<td>
		<input type='text' id='tgl_akhir' name="tgl_akhir" class="form-control ukuran5" placeholder="dd/mm/yyyy" readonly>
		</td>
	</tr>
	<tr><td height="20px" colspan="3"></td></tr>
	<tr><td colspan="3" align="center"><input type="submit"  name="submit" value="Proses Pencarian" class="page gradient"></td></tr>
</table>
</center>
</form>
</div>

	<div class="col-lg-5">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	<center><img src='images/advcsch.png'></center><br>
	        	~ Fitur ini digunakan untuk melakukan pencarian data arsip berdasarkan detail tertentu sesuai dengan parameter yang diinput.<br><br>
	        	~ Fitur ini sekaligus memfilter pencarian apabila arsip yang dicari tidak ditemukan pada dashboard dikarenakan banyaknya data. <br><br>
	        	~ Untuk mencari data, pilih dan sesuaikan parameter isi dengan kriteria data yang ingin dicari kemudian klik tombol proses pencarian untuk mendapatkan hasil.

	        </p>
	    </div>
	</div>
	</div>
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
							            //alert(data);
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
