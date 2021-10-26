<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 	

<script type='text/javascript'>
function pekerja(){
    $("#myModalpekerja").modal();
}
</script>

<!-- <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" /> -->


<script type='text/javascript'>

$(document).ready(function() {
	$("#simpan").click(function(){
					var	iduser		=	$("#iduser").val();
					var	groupmenu	=	$("#groupmenu").val();
				
					$.ajax({
							type: "POST",
							data: "act=adduser&groupmenu="+groupmenu+"&iduser="+iduser,
							url: "execute/exc_setting.php",
							success: function(data){
								 if(data ==''){
								 	window.location = 'main.php?mid=adduser&alert=1';
								 }else{
								 	window.location = 'main.php?mid=adduser&alert=2';
								 }	
								 //alert(data);
							}
					});
	});

	// $("#iduser").autocomplete("function/autocomplete.php?type=user", {width: 500});
});

</script>

<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=usermenu'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=usermenu'>
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
<div class="panel-heading">Form Tambah User
	<div style="float:right;">
			<a href='main.php?mid=usermenu'><input class="btn btn-info btn-sm" type=button value='Data User'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">


<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp;User <i class="fa fa-arrow-right"></i>&nbsp;Tambah User </i></div><br>
<!-- <form class="form-horizontal row-fluid"> -->
<table width="100%" border="0px">
	<tr>
		<td>Nama User</td>
		<td><input readonly type='text' id='iduser' name='iduser' class="form-control ukuran10	" placeholder="Klik tombol disebelah kanan untuk mencari data ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="pekerja()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="2"></td></tr>
	<tr>
		<td>Group Menu</td>
		<td colspan="2">
		<select id='groupmenu' name='groupmenu' class="form-control ukuran3"> 
				<?php
					$selectDropDown	=	mssql_query("SELECT groupmenu,groupdeskripsi FROM groupbsam WHERE groupmenu > '1' ORDER BY idgroupbsam ASC");
					while($mns	=	mssql_fetch_assoc($selectDropDown)){
						echo '<option value='.$mns['groupmenu'].'>'.$mns['groupdeskripsi'].'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<tr><td height="30px" colspan="2"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right">
			<button id='simpan' class="btn btn-outline btn-primary">Simpan</button>
		</td>
	</tr>
</table>
<br>

<div class="modal fade" id="myModalpekerja" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Nama Pegawai</h4>
    </div>
    <div class="modal-body">
      <p>Choose username.</p>
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Portal / Nip</th>
                    <th>Nama Pegawai</th>
                    <th>Action /<br /><a href="#" data-dismiss="modal" onclick="pilih_kosong()">Cancel</a></th>
                    <script>
                            function pilih_kosong(){
                               document.getElementById('namaPekerja').value='';
                            } 
                        </script>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
                
				$usserapp 	= tb_user_aplikasi();
				

                     $query  =   mssql_query("SELECT * FROM $usserapp");
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $id_pegawai    =   $data[id_pegawai];
                            $kd_pegawai    =   $data[nm_pegawai];
                            $nm_pegawai    =   $data[kd_pegawai];
                            
                ?>
                    <td><? echo $no; ?></td>
                    <td><? echo $id_pegawai." / ".$kd_pegawai; ?></td>
                     <td><? echo $nm_pegawai; ?></td>
                    <td>
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_pekerja('<? echo $id_pegawai; ?>','<? echo $nm_pegawai; ?>','<? echo $kd_pegawai; ?>')">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_pekerja(a,b,c){
                               var x = a+"-"+b+"-"+c;
                               document.getElementById('iduser').value=x;
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
</div>
</div>
</div>
</div>
</div>









