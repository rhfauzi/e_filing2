<script type="text/javascript" src="js/jquery-1.4.js"></script> 	

<script type='text/javascript'>
function showmodal(){
    $("#myModal").modal();
}

function showmodal2(){
    $("#myModal2").modal();
}

$(document).ready(function() {

	$('#simpan').click(function(){

		var kd_arsip   = $('#kd_arsip').val();
		var alasan     = $('#alasan').val();
		var LL 		   = $('#LL').val();
		var LB 		   = $('#LB').val();
		var RL 		   = $('#RL').val();
		var RB  	   = $('#RB').val();
		var BL  	   = $('#BL').val();
		var BB 		   = $('#BB').val();
		var keterangan = $('#keterangan').val();
		var tgl_pindah = $('#tgl_pindah').val();

		var LBsplit    = LB.split(' / ',1);

		if(kd_arsip =='0' || kd_arsip == ''){
			window.alert('Mohon untuk memilih Kode Arsip terlebih dahulu');
		}else if(alasan == '0' || alasan == ''){
			window.alert('Mohon untuk memilih Alasan terlebih dahulu');
		}else if(LL =='0' || LL == ''){
			window.alert('Lokasi lama masih kosong');
		}else if(RL =='0' || RL == ''){
			window.alert('Rak lama masih kosong');
		}else if(BL =='0' || BL == ''){
			window.alert('Box lama masih kosong');
		}else if(LB =='0' || LB == ''){
			window.alert('Mohon pilih Lokasi baru');
		}else if(RB =='0' || RB == ''){
			window.alert('Mohon pilih Rak baru');
		}else if(BB =='0' || BB == ''){
			window.alert('Mohon pilih Box baru');
		}else if(LL == LBsplit && RL == RB && BL == BB){
			window.alert('Kode Lokasi,Kode Rak,Kode Box masih sama tidak ada yang berbeda. Mohon teliti kembali');
		}else if(tgl_pindah == ''){
			window.alert('Mohon isi tanggal pindah');
		}else {

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){
				$.ajax({
					type:"POST",
					data:"act=pindaharsip&kd_arsip="+kd_arsip+"&alasan="+alasan+"&LL="+LL+"&RL="+RL+"&BL="+BL+"&LB="+LB+"&RB="+RB+"&BB="+BB+"&keterangan="+keterangan+"&tgl_pindah="+tgl_pindah,
					url: "execute/exc_program.php",
					success:function(data){
						$('#kd_arsip').val('');
						$('#alasan').val('');
						$('#LL').val('');
						$('#RL').val('');
						$('#BL').val('');
						$('#LB').val('');
						$('#RB').val('');
						$('#BB').val('');
						$('#keterangan').val('');

						if(data == ''){
							window.location ='main.php?mid=pindaharsip&alert=1';
						}else{
							window.location ='main.php?mid=pindaharsip&alert=2';
						}
						//alert(data);
					}
				})
			}
		}

	});

	$("#RB").attr("disabled",true);
	$("#BB").attr("disabled",true);

	//================= COMBOBOX CHANGE VALUE ==========================

	//-------------------------------- TANGGAL -----------------------------
	var year = (new Date()).getFullYear() + 10

	$("#tgl_pindah").datepicker({
		// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,maxDate:0

	});
	//--------------------------------------------------------------------

	$("#RB").change(function(){
	    var RB = $("#RB").val();
	    $.ajax({
	        url: "pages/procombox.php?act=box",
	        data: "kd_rak=" + RB,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $("#BB").attr("disabled",false);
	            $("#BB").html(data);
	            //alert(data);
	        }
	    });
	});

});//end jquery document
</script>


<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pemindahan Arsip</h3>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan</i></div><br>

<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Pemindahan
		<div style="float:right;">
			<a id='tambah' href='main.php?mid=menupindah'><input class='btn btn-info btn-sm' type=button value='Menu Pemindahan'></a>
			<input class="btn btn-info btn-sm" type=button value='Kembali' onclick='window.history.back()'>
		</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<table width="100%" border="0px">
	<tr>
		<td width="15%">Kode Arsip</td>
		<td colspan="3">
		<input readonly type='text' id='kd_arsip' name='kd_arsip' class="form-control ukuran10" placeholder="Klik tombol disebelah kanan untuk mencari data ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal()">
		&nbsp;Click</a></td>
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
	</tr>
	<tr><td height="30px" colspan="5"></td></tr>
	<tr>
		<td>Lokasi Lama</td>
		<td width="35%"><input readonly type='text' id='LL' name='LL' class="form-control ukuran5"></td>
		<td width="15%">Lokasi Baru</td>
		<td>
		<input readonly type='text' id='LB' name='LB' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal2()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="4"></td></tr>
	<tr>
		<td>Rak Lama</td>
		<td><input readonly type='text' id='RL' name='RL' class="form-control ukuran5"></td>
		<td>Rak Baru</td>
		<td>
		<select id='RB' name='RB' class="form-control ukuran5"> 
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="5"></td></tr>
	<tr>
		<td>Box Lama</td>
		<td><input readonly type='text' id='BL' name='BL' class="form-control ukuran5"></td>
		<td>Box Baru</td>
		<td>
		<select id='BB' name='BB' class="form-control ukuran5"> 
		</select>
		</td>
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

</div></div></div></div></div>

<br>
<table width="100%" class="table table-striped table-bordered table-hover">
<thead>
	<tr>
		<th width="2%">No</th>
		<th width="8%">Kode Arsip</th>
		<th width="5%"><font style='color:orange;'>BL</font></th>
		<th width="5%"><font style='color:orange;'>BB</font></th>
		<th width="8%">Tgl Pindah</th>
		<th width="20%">Alasan Pindah</th>
	</tr>
</thead>
<tbody>
	<?php
	$no =1;

		$QueMain	=	mssql_query("SELECT a.*,b.alasan FROM hist_pindah_arsip a,msalasan_pindah b where a.alasan_pindah=b.kode_alasan");
		
		while($res	=	mssql_fetch_assoc($QueMain)){

	?>
	<tr>
		<td align="center"><?php echo $no;?></td>
		<td><?php echo "<a href='main.php?mid=listarsip_detail&kd_arsip=".$res['kd_arsip']."'>".$res["kd_arsip"]."</a>"; ?></td>
		<td><?php echo $res['box_awal'];?></td>
		<td><?php echo $res['box_akhir'];?></td>
		<td><?php echo ShortDate($res['tgl_pindah']);?></td>
		<td><?php echo $res['alasan'];?></td>
		
	</tr>
	<?php
	$no++;
	}
	?>
	</tbody>
</table>
<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	~ Menu pemindahan Arsip digunakan untuk melihat history data pemindahan arsip<br>
					<font style='color:orange;'><b>BL</b></font> = Box Lama,
					<font style='color:orange;'><b>BB</b></font> = Box Baru
	        </p>
	    </div>
	</div>
</div>

<br>


<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog" style='width:800px;'>

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Arsip yang akan dipindahkan</h4>
      <!-- <div style="float: right"><a href="#" data-dismiss="modal" onclick="pilih_kosong()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Arsip</th>
                    <th>Nama Arsip</th>
                    <th>Action</th>
                    <script>
                        // function pilih_kosong(){
                        //    document.getElementById('').value='';
                        // } 
                    </script>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
				
                     $query  =   mssql_query($func_que_arsip);
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $kd_arsip   =   $data[kd_arsip];
                            $nm_arsip   =   $data[nama_arsip];
                            $kd_lokasi  =	$data[kd_lokasi];
                            $kd_rak     =	$data[kd_rak];
                            $kd_box  	=	$data[kd_box];
                            
                ?>
                    <td width='10%' align="center"><? echo $no; ?></td>
                    <td width='20%'><? echo $kd_arsip ?></td>
                    <td width='55%'><? echo $nm_arsip; ?></td>
                    <td width='15%' align="center">
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_data('<? echo $kd_arsip; ?>','<? echo $nm_arsip; ?>','<? echo $kd_lokasi; ?>','<? echo $kd_rak; ?>','<? echo $kd_box; ?>')">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_data(a,b,c,d,e){
                               var x = a+" - "+b;
                               document.getElementById('kd_arsip').value=x;
                               document.getElementById('LL').value=c;
                               document.getElementById('RL').value=d;
                               document.getElementById('BL').value=e;
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


<br>

<div class="modal fade" id="myModal2" role="dialog">
<div class="modal-dialog" style="width: 800px">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan pemindahan Arsip</h4>
      <!-- <div style="float: right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example2">
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