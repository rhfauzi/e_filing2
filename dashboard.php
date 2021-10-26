<script src="scripts/jquery.min.js" type="text/javascript"></script>
<script src="scripts/highcharts.js" type="text/javascript"></script>
 

<!-- <style type="text/css">
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/loading_fish.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}	
</style> -->




</script>

	<!-- <center><h3 style='font-family: monospace;'>SELAMAT DATANG DI APPLIKASI</h3></center> -->
	<br><br>
	<center>
	  <img src="images/brinsave-logo.png" width="10%" height="10%">
	<br>
	<br>
	<!-- <div class="loader"></div> -->
	<?php
	$urlCari 		= "mid=pencarian_arsip";
	$urlPencarian 	= $edc->encrypt($urlCari,true);
	?>
	<form name='pencarian' method='POST' action='main.php?<?php echo $urlPencarian; ?>'>
		<table width="50%">
			<tr>
				<td>
					<input type='text' id='keyword'  name="keyword" class="form-control ukuran10" style="text-align: center;" placeholder="Pencarian Arsip">
				</td>
			</tr>
			<tr><td height="15px"></td></tr>
			<tr>
				<td align="center">
			<input type="submit" name="cari" value="Cari" id='cari' 
			style='width:30%;height:35px;background-image: url(images/search.png);background-repeat: no-repeat;background-size:20px;background-position: 85px 5px;padding-right:30px'  
			class="btn btn-outline btn-info">
				</td>
			</tr>
		</table>
	</form>
	</center>
	<br><br><br>
<?php

$jumlok 	= mssql_num_rows(mssql_query("SELECT * FROM mslokasi"));
$jumrak 	= mssql_num_rows(mssql_query("SELECT * FROM msrak"));
$jumbox 	= mssql_num_rows(mssql_query("SELECT * FROM msbox"));
$jumarsip 	= mssql_num_rows(mssql_query("SELECT * FROM arsip"));


$view_detail = "<div class='panel-footer'><span class='pull-left'>View Details</span>
	            <span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
				<div class='clearfix'></div></div>";

$urlLokasi	 = "mid=mslokasi";
$urlRak  	 = "mid=msrak";
$urlBox 	 = "mid=msbox";
$urlArsip	 = "mid=listarsip";

$urlEncLokasi 	= $edc->encrypt($urlLokasi,true);
$urlEncRak 		= $edc->encrypt($urlRak,true);
$urlEncBox 		= $edc->encrypt($urlBox,true);
$urlEncArsip 	= $edc->encrypt($urlArsip,true);

$link_detail_lok = "<a href='main.php?".$urlEncLokasi."' style='color:#777;'>".$view_detail."</a>";
$link_detail_rak = "<a href='main.php?".$urlEncRak."' style='color:#777;'>".$view_detail."</a>";
$link_detail_box = "<a href='main.php?".$urlEncBox."' style='color:#777;'>".$view_detail."</a>";
$link_detail_arsip = "<a href='main.php?".$urlEncArsip."' style='color:#777;'>".$view_detail."</a>";



if($level == '1' || $level == '2' || $level == '3' || $level == '4' || $level == '5' || $level == '8'){

?>
<div class="col-lg-3">
	<div class="panel panel-softgreen">
	    <div class="panel-heading">
	        <div class="row">
	            <div class="col-xs-3">
	                <i class="fa fa-file-archive-o fa-5x"></i>
	            </div>
	            <div class="col-xs-9 text-right">
	                <div class="huge"><?php echo $jumarsip; ?></div>
	                <div>Arsip</div>
	            </div>
	        </div>
	    </div>
	    <?php echo $link_detail_arsip; ?>
	</div>
</div>
<div class="col-lg-3">
	<div class="panel panel-orangetwo">
	    <div class="panel-heading">
	        <div class="row">
	            <div class="col-xs-3">
	                <i class="fa fa-archive fa-5x"></i>
	            </div>
	            <div class="col-xs-9 text-right">
	                <div class="huge"><?php echo $jumbox; ?></div>
	                <div>Box</div>
	            </div>
	        </div>
	    </div>
	   	<?php echo $link_detail_box; ?>
	</div>
</div>
<div class="col-lg-3">
	<div class="panel panel-softblue">
	    <div class="panel-heading">
	        <div class="row">
	            <div class="col-xs-3">
	                <i class="fa fa-tasks fa-5x"></i>
	            </div>
	            <div class="col-xs-9 text-right">
	                <div class="huge"><?php echo $jumrak; ?></div>
	                <div>Rak</div>
	            </div>
	        </div>
	    </div>
	    <?php echo $link_detail_rak; ?>
	</div>
</div>
<div class="col-lg-3">
	<div class="panel panel-green">
	    <div class="panel-heading">
	        <div class="row">
	            <div class="col-xs-3">
	                <i class="fa fa-university fa-5x"></i>
	            </div>
	            <div class="col-xs-9 text-right">
	                <div class="huge"><?php echo $jumlok; ?></div>
	                <div>Ruang Simpan</div>
	            </div>
	        </div>
	    </div>
	    <?php echo $link_detail_lok; ?>
	</div>
</div>
<?php
}
?>