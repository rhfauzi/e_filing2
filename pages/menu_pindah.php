<h3>Pilihan Pemindahan</h3>
<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan</i></div><br>
<?php

$jumrak 	= mssql_num_rows(mssql_query("SELECT * FROM msrak"));
$jumbox 	= mssql_num_rows(mssql_query("SELECT * FROM msbox"));
$jumarsip 	= mssql_num_rows(mssql_query("SELECT * FROM arsip"));


$urlRak    = "mid=pindahrak";$urlRakEnc = $edc->encrypt($urlRak,true);
$urlBox    = "mid=pindahbox";$urlBoxEnc = $edc->encrypt($urlBox,true);
$urlArsip   = "mid=pindaharsip";$urlArsipEnc = $edc->encrypt($urlArsip,true);


?>
<table width="100%" border="0px">
<tr>
<td width="50%">
<div class="col-lg-8 col-md-6">
	<a href='main.php?<?php echo $urlRakEnc; ?>'>
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
	    <div class='panel-footer'><span class='pull-left'>Form Pemindahan Rak</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>
</td>
<td rowspan="3" style="vertical-align: top">
	
<div class="col-lg-12">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	~ Disamping adalah pilihan form untuk pemindahan Rak / Box / Arsip<br><br>
	        	~ Untuk memindahkan <b>Rak dari lokasi tertentu ke lokasi lain</b>, silakan klik kotak warna hijau, maka akan menuju form pemindahan Rak<br><br>
	        	~ Untuk memindahkan <b>Box dari Rak & Lokasi tertentu ke Rak & Lokasi lain</b>, silakan klik kotak warna biru, maka akan menuju form pemindahan Box<br><br>
	        	~ Untuk memindahkan Arsip dari <b>Box, Rak & Lokasi tertentu ke Box,Rak & Lokasi lain</b>, silakan klik kotak warna orange, maka akan menuju form pemindahan Arsip<br><br>
	        </p>
	    </div>
	</div>
</div>

</td>
</tr>
<tr>
<td>
<div class="col-lg-8 col-md-8">
	<a href='main.php?<?php echo $urlBoxEnc; ?>'>
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
	   	<div class='panel-footer'><span class='pull-left'>Form Pemindahan Box</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="col-lg-8 col-md-6">
	<a href='main.php?<?php echo $urlArsipEnc; ?>'>
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
	    <div class='panel-footer'><span class='pull-left'>Form Pemindahan Arsip</span>
            	<span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
         <div class='clearfix'></div></div>
	</div>
	</a>
</div>
</td>
</tr>
</table>


