<!-- <script src="js/jquery-1.11.1.min.js"></script> -->  <!-- harus ada disetiap page kecuali yang ada autocomplete -->
<!-- <script src="js/bootstrap.min.js"></script> --> <!-- harus ada disetiap page kecuali yang ada autocomplete -->

<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
			<button type="button" class="close">x</button>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close">x</button>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
?>


<h3>Pengaturan Akses Group</h3>
<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp; Akses Group</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	<tr>
		<th>Nama Group</th>
		<th></th>
	</tr>
	<?php
		$selectGroupBsam	=	mssql_query("SELECT a.groupmenu,a.groupdeskripsi FROM groupbsam a
											WHERE idgroupbsam > '1' ORDER BY idgroupbsam ASC");
		while($sgb			=	mssql_fetch_assoc($selectGroupBsam)){
		
		echo "
		<tr>
		<td>
			Group ".$sgb['groupdeskripsi']."
		</td>
		<td>
			<a href='main.php?mid=updategroup&groupmenu=".$sgb['groupmenu']."'>
			<input class='btn btn-outline btn-success' type=button value='Ubah Akses'>
		</td>
		</tr>
		";

		$selectGroupMenu  =	mssql_query("select c.namamenu,c.idmenu from
										  groupbsam a,
										  groupmenu b,
										  menu c
										  WHERE a.groupmenu=b.groupmenu
										  AND b.idmenu=c.idmenu
										  AND c.idutama = '1'
										  AND c.idmenu <> '1'
										  AND a.groupmenu <> '1'
										  AND b.groupmenu = '".$sgb['groupmenu']."'
										  ");
											  
		while($sgm	=	mssql_fetch_assoc($selectGroupMenu)){
		echo "
			<tr>
				<td colspan=3 align=left bgcolor=#cedadc style='padding-left:20px;'>
				<b>Menu Utama -> ".$sgm['namamenu']."</b>
				</td>
					
			</tr>
		";
			$selectGroupMenuBsam	=	mssql_query("SELECT b.namamenu,b.idmenu FROM
													groupmenu a,
													menu b
													WHERE 
													a.idmenu=b.idmenu
													AND b.idutama <> '1'
													AND a.groupmenu = '$sgb[groupmenu]'
													AND b.menupendahulu = '$sgm[idmenu]'
												
													
												");
			while($sgmb					=	mssql_fetch_assoc($selectGroupMenuBsam)){
			
			
	?>
	<tr>
		<td colspan=3 style='padding-left:100px;'><?php echo $sgmb['namamenu'];?></td>
	</tr>
	<?php
	}
	}
	}
	?>
	
</table>
</div>
</div>