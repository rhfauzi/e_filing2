<h3>Pilihan Cetak Excel For QRCode</h3>
<div><i class="ketmenu">Utility <i class="fa fa-arrow-right"></i>&nbsp; Excel For QRCode</i></div><br>
<?php

$jumlok 	= mssql_num_rows(mssql_query("SELECT * FROM mslokasi"));
$jumrak 	= mssql_num_rows(mssql_query("SELECT * FROM msrak"));
$jumbox 	= mssql_num_rows(mssql_query("SELECT * FROM msbox"));
$jumarsip 	= mssql_num_rows(mssql_query("SELECT * FROM arsip"));

$url1 	= "mid=paramex_qrlokasi";$urlEnc1 = $edc->encrypt($url1,true);
$url2 	= "mid=paramex_qrrak";$urlEnc2 = $edc->encrypt($url2,true);
$url3 	= "mid=paramex_qrbox";$urlEnc3 = $edc->encrypt($url3,true);
$url4 	= "mid=paramex_qrarsip";$urlEnc4 = $edc->encrypt($url4,true);


?>
<br><br>
<div class="col-lg-3 col-md-6">
	<a href='main.php?<?php echo $urlEnc3; ?>'>
	<div class="panel panel-primary">
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
	   	<div class='panel-footer'><span class='pull-left'>Get Excel</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>
<div class="col-lg-3 col-md-6">
	<a href='main.php?<?php echo $urlEnc4; ?>'>
	<div class="panel panel-orangetwo">
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
	    <div class='panel-footer'><span class='pull-left'>Get Excel</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>
<div class="col-lg-3 col-md-6">
	<a href='main.php?<?php echo $urlEnc2; ?>'>
	<div class="panel panel-primary">
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
	    <div class='panel-footer'><span class='pull-left'>Get Excel</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>
<div class="col-lg-3 col-md-6">
	<a href='main.php?<?php echo $urlEnc1; ?>'>
	<div class="panel panel-orangetwo">
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
	   	<div class='panel-footer'><span class='pull-left'>Get Excel</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>

