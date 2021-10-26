<script type="text/javascript" src="js/jquery-1.4.js"></script> 	

<script type='text/javascript'>

function showmodal2(){
    $("#myModal2").modal();
}

$(document).ready(function() {

	$('#simpan').click(function(){

		var kd_rak     = $('#kd_rak').val();
		var alasan     = $('#alasan').val();
		var LL 		   = $('#LL').val();
		var LB 		   = $('#LB').val();
		var keterangan = $('#keterangan').val();
		var tgl_pindah = $('#tgl_pindah').val();

		var LBsplit    = LB.split(' / ',1);

		if(alasan == '0' || alasan == ''){
			window.alert('Mohon untuk memilih Alasan terlebih dahulu');
			$('#alasan').focus();
		}else if(LL =='0' || LL == ''){
			window.alert('Lokasi lama masih kosong');
			$('#LL').focus();
		}else if(LB =='0' || LB == ''){
			window.alert('Mohon pilih Lokasi baru');
			$('#LB').focus();
		}else if(LL == LBsplit){
			window.alert('Kode Lokasi,Kode Rak,Kode Box masih sama tidak ada yang berbeda. Mohon teliti kembali');
		}else if(tgl_pindah == ''){
			window.alert('Mohon isi tanggal pindah');
			$('#tgl_pindah').focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){
				$.ajax({
					type:"POST",
					data:"act=pindahrak&kd_rak="+kd_rak+"&alasan="+alasan+"&LL="+LL+"&LB="+LB+"&keterangan="+keterangan+"&tgl_pindah="+tgl_pindah,
					url: "execute/exc_program.php",
					success:function(data){
						$('#kd_arsip').val('');
						$('#alasan').val('');
						$('#LL').val('');
						$('#LB').val('');
						$('#keterangan').val('');

						window.location = 'main.php?'+data;
						
					}
				})
			}
		}

	});

	$("#RB").attr("disabled",true);
	$("#BB").attr("disabled",true);


	//-------------------------------- TANGGAL -----------------------------
	var year = (new Date()).getFullYear() + 10

	$("#tgl_pindah").datepicker({
		// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,maxDate :0

	});
	//--------------------------------------------------------------------

});//end jquery document
</script>



<?php
$kd_lokasi 	= $isiParam1;
$kd_rak 	= $isiParam2;
?>


<h3>Pemindahan Rak</h3>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan Rak</i></div><br>

<div class="panel panel-default">
<div class="panel-heading">Form Tambah Pemindahan (<i><b>step 2</b></i>)
	<div style="float:right;">
		<?php
		$url1    = "mid=menupindah";
		$urlEnc1 = $edc->encrypt($url1,true);
		echo "<a id='tambah' href='main.php?".$urlEnc1."'><input class='btn btn-info btn-sm' type=button value='Menu Pemindahan'></a>";
		echo "&nbsp";
		$url2    = "mid=addpindah_rak&kd_lokasi=".$kd_lokasi;
		$urlEnc2 = $edc->encrypt($url2,true);
		echo "<a href='main.php?".$urlEnc2."'><input class='btn btn-info btn-sm' type=button value='Kembali'></a>";
		?>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<table width="100%" border="0px">

	<tr>
		<td colspan="5" align="right">
			<input type='hidden' name='kd_rak' id='kd_rak' value ='<?php echo $kd_rak; ?>'>
			<i>Kode Rak </i> : <?php echo "<b>".$kd_rak."</b>"; ?> <i>, Kode Lokasi</i> : <?php echo "<b>".$kd_lokasi."</b>"; ?>
			<i>, Lokasi Saat ini</i> : 
			<?php 
			$getloc = mssql_fetch_assoc(mssql_query("SELECT lokasi FROM mslokasi WHERE kd_lokasi = '".$kd_lokasi."'"));
			echo "<b>".$getloc['lokasi']."</b>"; 
			?>
			
		</td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
	<td>Alasan Pindah</td>
	<td colspan="2">
	<select id='alasan' name='alasan' class="form-control ukuran7"> 
		<option value='0'>~ Pilih ~</option>
			<?php
				$selectDropDown	=	mssql_query("SELECT * FROM msalasan_pindah");
				while($mns	=	mssql_fetch_assoc($selectDropDown)){
					echo '<option value='.$mns['kode_alasan'].'>'.$mns['alasan'].'</option>';
				}
			?>
	</select>
	</td>
	<td colspan="2"></td>
	</tr>
	<tr><td height="30px" colspan="5"></td></tr>
	<tr>
		<td>Lokasi Lama</td>
		<td width="35%"><input readonly type='text' id='LL' name='LL' class="form-control ukuran5" value="<?php echo $kd_lokasi; ?>"></td>
		<td width="15%">Lokasi Baru</td>
		<td>
		<input readonly type='text' id='LB' name='LB' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal2()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
		<td>Keterangan</td>
		<td colspan="3"><textarea name="Keterangan" id='keterangan' class="form-control ukuran10"> </textarea></td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
	<td>Tanggal Pindah</td>
	<td>
		<div class="form-group input-group ukuran6">
		<span class="input-group-addon"><i class="fa fa-calendar-o"></i>
	    </span>
		<input type='text' id='tgl_pindah' name="tgl_pindah" placeholder="dd/mm/yyyy" readonly class="form-control ukuran6" style="background-color: #fff8bc;cursor: text;">
		</div>
	</td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
		<td></td>
		<td colspan="5" align="right">
			<button id='simpan' class="btn btn-outline btn-primary">Simpan</button>
		</td>
	</tr>
</table>

</div></div></div></div>

	<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ Form ini adalah untuk menginput data perpindahan rak pada ruang arsip <br>
	        	~ Pilih alasan pemindahan terlebih dahulu <br>
	        	~ Kemudian pilih Lokasi baru <br>
	        </p>
	    </div>
	</div>
	</div>



<div class="modal fade" id="myModal2" role="dialog">
<div class="modal-dialog" style="width: 800px;">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan pemindahan Rak</h4>
      <!-- <div style="float:right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
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
				
                     $query  =   mssql_query("SELECT * FROM mslokasi WHERE data_status = 'A'");
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
                    onclick="pilih_data2('<?php echo $kd_lokasi; ?>','<?php  echo $lokasi; ?>');ganti();">Pilih</a>
                    </td>
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



