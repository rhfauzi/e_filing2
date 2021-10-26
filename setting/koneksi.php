<?php

function conDB($srv,$db)
{
	 ini_set('mssql.textlimit','2217483647');
	 ini_set('mssql.textsize','2217483647');
	 ini_set('memory_limit','2048M');
	

	 if($srv ==	".")//local
	 {
		mssql_select_db($db, mssql_connect('192.168.14.30', 'dev-brinsave', 'BR1@21sav3'));
	 }
	

	 $result = mssql_query("SET ANSI_NULLS ON;");
	 $result = mssql_query("SET ANSI_WARNINGS ON;");
}


function linkSEA(){
	return "[192.168.14.51].SEA.dbo.";
}

function linkSDM(){
	// return "[192.168.14.52].SIMSDM.dbo.";
	return "SIMSDM.dbo.";
}

function tb_unitkerja(){
	 //$lokasi	= "SIMSDM.dbo.MUnitKerja";

	//===== jika error dalam cross server gunakan ini
	$result = mssql_query("SET ANSI_NULLS ON;");
	$result = mssql_query("SET ANSI_WARNINGS ON;"); 
	//=================================================

	// $lokasi	= "(SELECT KodeUnit,name as UnitKerja FROM
	// 			(
	// 			SELECT branch as KodeUnit,name = CASE branch
	// 									when '115' then  'KCU'
	// 									when '125' then  'SEMANGGI'
	// 									when '126' then  'MRO BATAM'
	// 									when '129' then  'MRO PARE PARE'
	// 									when '130' then  'MRO PONTIANAK'
	// 									when '131' then  'MRO JEMBER'
	// 									when '132' then  'MRO KEDIRI'
	// 									when '212' then  'SYARIAH JAKARTA'
	// 									when '121' then	 'CIREBON'
	// 									when '122' then  'SOLO'
	// 									ELSE
	// 									LEFT(name,CHARINDEX(' -',name))
	// 									END
	// 			FROM SEA.dbo.branch where Branch like '1%' or Branch = '212'
	// 			)AS x)";

	$lokasi = "uker";

	return $lokasi;
}

function tb_user_aplikasi(){
	$user	= "APLIKASI.dbo.user_aplikasi";

	return $user;
}

?>