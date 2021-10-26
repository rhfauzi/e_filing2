<?php

function DBDate($Date){

$extgl	= explode("/",$Date);
$tgl = $extgl[0];
$bln = $extgl[1];
$thn = $extgl[2];
$format_tgl = $thn."-".$bln."-".$tgl;

return $format_tgl;
}


function DBDate_picker($Date){

$extgl	= explode("-",$Date);
$tgl = $extgl[2];
$bln = $extgl[1];
$thn = $extgl[0];
$format_tgl = $tgl."/".$bln."/".$thn;

return $format_tgl;
}

function DateText($GetDate)
{
	$GetTgl = substr($GetDate,6,2);
	$GetBln = substr($GetDate,4,2);
	$GetThn = substr($GetDate,0,4);
	if($GetBln == '01'){ $blnName = "Januari" ;}
	elseif($GetBln == '02'){ $blnName = "Februari" ;}
	elseif($GetBln == '03'){ $blnName = "Maret" ;}
	elseif($GetBln == '04'){ $blnName = "April" ;}
	elseif($GetBln == '05'){ $blnName = "Mei" ;}
	elseif($GetBln == '06'){ $blnName = "Juni" ;}
	elseif($GetBln == '07'){ $blnName = "Juli" ;}
	elseif($GetBln == '08'){ $blnName = "Agustus" ;}
	elseif($GetBln == '09'){ $blnName = "September" ;}
	elseif($GetBln == '10'){ $blnName = "Oktober" ;}
	elseif($GetBln == '11'){ $blnName = "November" ;}
	elseif($GetBln == '12'){ $blnName = "Desember" ;}
	
	$GetFormat = $GetTgl." ".$blnName." ". $GetThn;

return $GetFormat;
}

function ShortDate($GetDate){

$GetTgl = substr($GetDate,6,2);
$GetBln = substr($GetDate,4,2);
$GetThn = substr($GetDate,0,4);
$GetFormat = $GetTgl."/".$GetBln."/". $GetThn;

return $GetFormat;
}

function ShortDate2($GetDate){

	$exTgl  = explode('-',$GetDate);
	$GetTgl = $exTgl[2];
	$GetBln = $exTgl[1];
	$GetThn = $exTgl[0];
	$GetFormat = $GetTgl."/".$GetBln."/". $GetThn;
	
	return $GetFormat;
	}


function DateTime_explode($GetDate){

$exdt = explode("|",$GetDate);

$exres['tgl'] 	= $exdt[0];
$exres['waktu'] = $exdt[1];

return $exres;
}
?>