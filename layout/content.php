<br><br>
<?php
// error_reporting(0);
// session_start();

//===== get url encrypted secure ==========

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 

$exEncUrl 	= explode('?',$actual_link);
$midEnc   	= $exEncUrl[1];

$edc = new encdec();
$urlEnc = $edc->decrypt($midEnc,true);

$urlReplace = str_replace('&','=',$urlEnc);

$exUrl 		= explode('=',$urlReplace);
$midAlias 	= $exUrl[1];
$param1 	= $exUrl[2];
$isiParam1  = $exUrl[3];
$param2 	= $exUrl[4];
$isiParam2  = $exUrl[5];
$param3 	= $exUrl[6];
$isiParam3  = $exUrl[7];
$param4 	= $exUrl[8];
$isiParam4  = $exUrl[9];
$param5  	= $exUrl[10];
$isiParam5  = $exUrl[11];
$param6  	= $exUrl[12];
$isiParam6  = $exUrl[13];
$param7  	= $exUrl[14];
$isiParam7  = $exUrl[15];
$param8  	= $exUrl[16];
$isiParam8  = $exUrl[17];
$param9  	= $exUrl[18];
$isiParam9  = $exUrl[19];
$param10    = $exUrl[20];
$isiParam10 = $exUrl[21];


//=======================================

$mid = $_GET['mid'];


if($midAlias == ''){
		include "dashboard.php";
}else{

	$select_link_param = mssql_query("SELECT idutama,menuprogram,filemenu FROM menu WHERE aktif = 'Y'");

	while($link_param = mssql_fetch_assoc($select_link_param)){
		//if($link_param['idutama'] != '1'){
			if($midAlias == $link_param['menuprogram']){
				include ($link_param['filemenu']);
			}
		//}
	}
}

// echo "<div class='alert alert-warning'>";
// echo "<br>=========//<i style='color:red'>FOR DEBUGING TEST. JUST IGNORE IT</i>//==========<br>";
// echo "<b>actual_link = </b>".$actual_link."<br>";
// echo "<b>midEnc = </b>" .$midEnc."<br>";
// echo "<b>urlEnc = </b>".$urlEnc."<br>";
// echo "<b>urlReplace = </b>".$urlReplace."<br>";
// echo "<b>midAlias = </b>".$midAlias."<br>";
// echo "param1=<b>".$param1."</b>,&nbsp;&nbsp;&nbsp;";
// echo "isiParam1=<b>".$isiParam1."</b>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
// echo "param2=<b>".$param2."</b>,&nbsp;&nbsp;&nbsp;";
// echo "isiParam2=<b>".$isiParam2."</b>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
// echo "param3=<b>".$param3."</b>,&nbsp;&nbsp;&nbsp;";
// echo "isiParam3=<b>".$isiParam3."</b>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
// echo "param4=<b>".$param4."</b>,&nbsp;&nbsp;&nbsp;";
// echo "isiParam4=<b>".$isiParam4."</b>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
// //echo "<br>".$Que;
// echo "<br>//======================================================//<br>";
// echo "</div>";

?>
