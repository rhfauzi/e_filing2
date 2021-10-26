<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	kd_lokasi	= $("#LB").val();
		var	kd_rak		= $("#RB").val();
		var	kd_box		= $("#BB").val();
		var	scan_no		= $("#scanno").val();
		var	docname		= $("#docname").val();
		var	uker		= $("#uker").val();
		var	kategori	= $("#kategori").val();
		var	crdate		= $("#crdate").val();
		var jmlcek		= $("#jmlcek").val();

		if(kd_lokasi == '0' || kd_lokasi == ''){
			window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
			$("#LB").focus();
		}else if(kd_rak == '0'){
			window.alert('Mohon untuk memilih Kode Rak terlebih dahulu');
			$("#RB").focus();
		}else if(kd_box == '0'){
			window.alert('Mohon untuk memilih Kode Box terlebih dahulu');
			$("#BB").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=add_multiLocated&kd_box="+kd_box+"&scan_no="+scan_no+"&crdate="+crdate+"&docname="+docname+"&uker="+uker+"&kategori="+kategori+"&jmlcek="+jmlcek,
					url: "execute/exc_program.php",
					success: function(data){
						 $("#LB").val("0");
						 $("#RB").val("0");
						 $("#BB").val("0");

						//  if(data ==''){
						//  	window.location = 'main.php?mid=alocated&alert=1';
						//  }else{
						//  	window.location = 'main.php?mid=alocated&alert=2';
						//  }
						window.location = 'main.php?'+data;
						//alert(data);
					}
				});
			}
		}
	});



//--------------------COMBO BOX CHANGE VALUE----------------------------

	$("#RB").attr("disabled",true);
	$("#BB").attr("disabled",true);

	$("#RB").change(function(){
	    var RB = $("#RB").val();
	    $.ajax({
	        url: "pages/procombox.php?act=box2",
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
<script type="text/javascript">
function showmodal(){
    $("#myModal").modal();
}
</script>
<?php
//back to list
$url    = "mid=alocated";
$urlEnc = $edc->encrypt($url,true);
//----------------------------

//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>SUCCESS !</strong> Data berhasil dialokasikan. 
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>DENIED !</strong> mohon maaf, Data gagal dialokasikan mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<br>

<div class="panel panel-default">
<div class="panel-heading">Form Pengalokasian Multiple Arsip 
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Pengalokasian'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pengalokasian</i></div><br>
<?php
	$noScan = $isiParam1;
	$queGetScanData = mssql_query("SELECT convert(date,createdDate) as dateCreateed,* FROM arsip_scan WHERE scanNo ='".$noScan."'");
	$resScanData = mssql_fetch_assoc($queGetScanData);
?>
<table width="100%" border="0px">
	<tr>

		<td width='50%' style='vertical-align:top;'>
			<!-- tampilan keterangan gambar lokasi rak dan box -->
			<div class="col-lg-12 col-md-6">
				<div class="panel panel-softblue">
				<div class="panel-heading">
					<table border="0px" width="100%">
					<tr>
						<td width="20%"><i class="fa fa-bank fa-4x"></i></td>
						<td>Lokasi</td>
						<td colspan="2">
						<input readonly type='text' id='LB' name='LB' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
						</td>
						<td>
							<a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;color:#FFF;" onclick="showmodal()">
						&nbsp;Click</a></td>
					</tr>
					</table>
				</div>
				<div class="panel-body">
					<div class="col-lg-12 col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<table border="0px" width="100%">
								<tr>
									<td width="20%"><i class="fa fa-tasks fa-3x" style="color:#90c3f0;"></i></td>
									<td width="10%">Rak :</td>
									<td>
										<select id='RB' name='RB' class="form-control"></select>
									</td>
								</tr>
							</table>
						</div>
					    <div class="panel-body">
					    	<!-- <div class="col-lg-2 col-md-6">
					    		<i class="fa fa-tasks fa-4x"></i>
					    	</div> -->
			            	<div class="col-lg-12 col-md-6">
								<div class="panel panel-orangetwo">
									<div class="panel-heading">
									<table border="0px" width="100%">
										<tr>
										<td width="20%"><i class="fa fa-archive fa-2x"></i></td>
										<td width="20%">Box :</td>
										<td>
										<select id='BB' name='BB' class="form-control"></select>
										</td>
										</tr>
									</table>
									</div>
								    <div class="panel-body">
								        <div class="row">
								            <!-- <div class="col-xs-2">
								                <i class="fa fa-file-o fa-2x" style="color:#FEDD7E;"></i>
								            </div> -->
								            <div class="col-xs-12 text-left">
								            <table border="0px" width="100%">
								            <tr>
								            <td width="10%"><i class="fa fa-file-o fa-2x" style="color:#90c3f0;"></i></td>
								            <td width="30%" align="center">Kode Arsip</td>
								            <td><input type='text' id='kd_arsip'  name="kd_arsip" placeholder="Cth : A001" readonly=readonly class="form-control"></td>
								        	</tr>
								        	</table>
								        	</div>
								        </div>
								    </div>
								</div>
							</div>
					    </div>
					</div>
					</div>
				</div>
				</div>
			</div>
		<!-- ==============================================-->
		</td>
		<td>	

		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example3"> 
			<thead> 	
				<tr> 
				<td>Arsip Terpilih</td>
				<tr>
			</thead>
			<tbody>

		<?php
			
			if(isset($_POST['actBtn'])){

				//mengetahui jumlah data
				$jumlah		= count($_POST['jml']);

					//looping berdasarkan jumlah data
					//$arscan = array();
					for($i=1;$i<=$jumlah;$i++)
					{
						$chk = $_POST['chk_'.$i];

						if(isset($chk))
						{
							$arr_scanno[]	= $_POST['scanno_'.$i];
							$arr_docname[]	= $_POST['docname_'.$i];
							$arr_uker[]		= $_POST['uker_'.$i];
							$arr_kategori[]	= $_POST['kategori_'.$i];
							$arr_crdate[]	= $_POST['crdate_'.$i];

							$jml_cek 		+= $_POST['chk_'.$i];

							echo 
							"<tr>
								<td>".$i." |
									<b style='color:#777'>".$_POST['scanno_'.$i]."</b> |
									<i style='color:blue;'>".$_POST['docname_'.$i]."</i> |
								".$_POST['crdate_'.$i]."
								</td>
							</tr>";
						}

					}

					echo "<input type='hidden' name='jmlcek' id='jmlcek' value='".$jml_cek."'>";
					echo "<input type='hidden' name='scanno' id='scanno' value='".implode(',',$arr_scanno)."'>";
					echo "<input type='hidden' name='docname' id='docname' value='".implode(',',$arr_docname)."'>";
					echo "<input type='hidden' name='uker' id='uker' value='".implode(',',$arr_uker)."'>";
					echo "<input type='hidden' name='kategori' id='kategori' value='".implode(',',$arr_kategori)."'>";
					echo "<input type='hidden' name='crdate' id='crdate' value='".implode(',',$arr_crdate)."'>";
						
			}
		?>
			</tbody>
		</table>
		</td>
	</tr>
	<tr><td height="20px" colspan="2"></td></tr>
	<tr>
	<td>
	<button id='simpan' class='btn btn-primary' style='width:100%;'>Simpan</button>
	</td>
	<td></td>
	</tr>
</table>
<br>
</div>
</div>
</div>
</div>

	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ <b>Form Pengalokasian Arsip</b> digunakan untuk menentukan lokasi penyimpanan hardcopy arsip.<br>
	        </p>
	    </div>
	</div>

<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog" style="width: 800px">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan penempatan fisik arsip</h4>
      <!-- <div style="float: right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="datatable-example2">
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
							        url: "pages/procombox.php?act=rak4",
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
