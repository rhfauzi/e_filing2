<?php

//====================================== FUNGSI NO URUT MENU =========================
	function noUrutMenu(){

		$selectNoMenu = mssql_query("SELECT MAX(idmenu) as jml  FROM menu");
		$snm	 =	mssql_fetch_assoc($selectNoMenu);
		$maxmenu =	$snm['jml'] + 1;
		return $maxmenu;
	}

//====================================== FUNGSI NO URUT GROUP =========================
	function noUrutGroupBsam(){

		$selectNoMenu = mssql_query("SELECT MAX(groupmenu) as gm  FROM groupbsam");
		$snm	 =	mssql_fetch_assoc($selectNoMenu);
		$maxmenu =	$snm['gm'] + 1;
		return $maxmenu;
	}

//====================================== FUNGSI KODE KATEGORI OTOMATIS =========================

	function kode_kategori($nama){

		$cate = $nama;

		$Que 	= "SELECT top 1 convert(float,substring(kd_kategori,3,2)) as kd_kategori FROM mskategori order by kd_kategori desc";
		$last = mssql_fetch_assoc(mssql_query($Que));
		$cek  = mssql_num_rows(mssql_query($Que));

		$alfa1 = substr(trim($cate),0,1);
		$alfa2 = substr(trim($cate),3,1);
		//$alfa3 = substr(trim($cate),6,1);

		if($alfa1 == ' ' || $alfa1 ==''){$print1 = 'X';}else{$print1 = $alfa1;}
		if($alfa2 == ' ' || $alfa2 ==''){$print2 = 'X';}else{$print2 = $alfa2;}
		//if($alfa3 == ' ' || $alfa3 ==''){$print3 = 'X';}else{$print3 = $alfa3;}

		$printed = $print1.$print2.$print3;
		$awal    = strtoupper($printed)."01";

		if($cek == 0){
			$code =	$awal;
		}else{
			$nomor	=	$last['kd_kategori'];
			$seqno  =	$nomor  + 1;
			$countNo=	strlen($seqno);
			
			if($countNo == 1){$nom	=	'0'.$seqno;}
			// elseif($countNo == 2){$nom	=	'0'.$seqno;}
			else{$nom = $seqno;}

			$code = strtoupper($printed).$nom;
		}
		
		return $code;
	}

//====================================== FUNGSI KODE TYPE OTOMATIS =========================

	// function auto_kd_type($kategori,$nama){

	// 	$cate = $nama;

	// 	$Que 	= "SELECT top 1 convert(float,substring(kd_type,6,2)) as kd_type FROM mstype where kd_kategori = '$kategori' order by kd_type desc";

	// 	$last = mssql_fetch_assoc(mssql_query($Que));
	// 	$cek  = mssql_num_rows(mssql_query($Que));

	// 	// $alfa1 = substr(trim($cate),0,1);

	// 	// if($alfa1 == ' '){$print1 = 'X';}else{$print1 = $alfa1;}

	// 	//$awal    = strtoupper($print1)."001";

	// 	$awal    = "T01";
	// 	$hrf  	 = "T";

	// 	if($cek == 0){
	// 		$code =	$kategori.$awal;
	// 	}else{
	// 		$nomor	=	$last['kd_type'];
	// 		$seqno  =	$nomor  + 1;
	// 		$countNo=	strlen($seqno);
			
	// 		if($countNo == 1){$nom	=	'0'.$seqno;}
	// 		//elseif($countNo == 2){$nom	=	'0'.$seqno;}
	// 		else{$nom = $seqno;}

	// 		$code = $kategori.$hrf.$nom;
	// 	}
		
	// 	return $code;
	// }


	//====================================== FUNGSI KODE LOKASI OTOMATIS =========================

	function auto_kd_lokasi(){

		$Que 	= "SELECT top 1 convert(float,substring(kd_lokasi,2,3)) as kd_lokasi FROM mslokasi ORDER BY kd_lokasi DESC";

		$last = mssql_fetch_assoc(mssql_query($Que));
		$cek  = mssql_num_rows(mssql_query($Que));

		$awal    = "001";

		if($cek == 0){
			$code =	"L".$awal;
		}else{
			$nomor	=	$last['kd_lokasi'];
			$seqno  =	$nomor  + 1;
			$countNo=	strlen($seqno);
			
			if($countNo == 1){$nom	=	'00'.$seqno;}
			elseif($countNo == 2){$nom	=	'0'.$seqno;}
			else{
				$nom = $seqno;
			}

			$code = "L".$nom;
		}
			
		return $code;
	}

//====================================== FUNGSI KODE RAK OTOMATIS =========================

	function auto_kd_rak(){

		$Que 	= "SELECT top 1 convert(float,substring(kd_rak,2,3)) as kd_rak FROM msrak order by kd_rak desc";

		$last = mssql_fetch_assoc(mssql_query($Que));
		$cek  = mssql_num_rows(mssql_query($Que));

		$awal    = "001";

		if($cek == 0){
			$code =	"R".$awal;
		}else{
			$nomor	=	$last['kd_rak'];
			$seqno  =	$nomor  + 1;
			$countNo=	strlen($seqno);
			
			if($countNo == 1){$nom	=	'00'.$seqno;}
			elseif($countNo == 2){$nom	=	'0'.$seqno;}
			else{
				$nom = $seqno;
			}

			$code = "R".$nom;
		}
		
		return $code;
	}



//====================================== FUNGSI KODE BOX OTOMATIS =========================

	function auto_kd_box(){

		$Que 	= "SELECT top 1 convert(float,substring(kd_box,2,4)) as kd_box FROM msbox order by kd_box desc";

		$last = mssql_fetch_assoc(mssql_query($Que));
		$cek  = mssql_num_rows(mssql_query($Que));

		$awal    = "0001";

		if($cek == 0){
			$code =	"B".$awal;
		}else{
			$nomor	=	$last['kd_box'];
			$seqno  =	$nomor  + 1;
			$countNo=	strlen($seqno);
			
			if($countNo == 1){$nom	=	'000'.$seqno;}
			elseif($countNo == 2){$nom	=	'00'.$seqno;}
			elseif($countNo == 3){$nom	=	'0'.$seqno;}
			else{
				$nom = $seqno;
			}

			$code = "B".$nom;
		}
		
		return $code;
	}



//====================================== FUNGSI KODE ASSET OTOMATIS =========================

	//=====method 1========

	function arsipcode($kat,$tgl){

	//VC01T01170000198
	// $kat = "Tanah dan Bangunan";

	// $tgl = "01/01/2016";
	$getthn = explode("/",$tgl);
	$thn 	= $getthn[2];

	// $r1 	= substr(strtoupper($kat),0,1);
	// $r2 	= substr(strtoupper($kat),2,1);
	//$r3 	= substr(strtoupper($kat),4,1);
	//$r      = substr($kat,0,3);

	$short_thn = substr($thn,2,2);

	$char	= $kat;
	$randno = rand(10,99);
	$awal	= $char.$short_thn.'00000001'.$randno;

	$query_cek	=	" SELECT count(kd_arsip) as jumlah FROM 
						(
						SELECT kd_arsip,SUBSTRING(kd_arsip,5,2) as thn_input FROM arsip
						WHERE kd_arsip LIKE '".$char."%'
						) as x
						WHERE x.thn_input = '".$short_thn."'";

	$query		=	"SELECT TOP 1 convert(float,SUBSTRING(kd_arsip,7,8)) as kd_arsip 
					 FROM 
						(
						SELECT kd_arsip,SUBSTRING(kd_arsip,5,2) as thn_input FROM arsip
						WHERE kd_arsip LIKE '".$char."%'
						) as x
					WHERE x.thn_input = '".$short_thn."' ORDER BY convert(float,SUBSTRING(kd_arsip,7,8)) DESC";

	$ada		=	mssql_fetch_assoc(mssql_query($query_cek));
	$select		=	mssql_query($query);
	$res		=	mssql_fetch_assoc($select);

	if($ada['jumlah'] == 0){
		$code	=	$awal;
	}else{
		$nomor	=	$res['kd_arsip'];
		$seqno  =	$nomor  + 1;
		$countNo=	strlen($seqno);
		
		if($countNo == 1){$nom	=	'0000000'.$seqno;}
		elseif($countNo == 2){$nom	=	'000000'.$seqno;}
		elseif($countNo == 3){$nom	=	'00000'.$seqno;}
		elseif($countNo == 4){$nom	=	'0000'.$seqno;}
		elseif($countNo == 5){$nom	=	'000'.$seqno;}
		elseif($countNo == 6){$nom	=	'00'.$seqno;}
		elseif($countNo == 7){$nom	=	'0'.$seqno;}

		$code	=	$char.$short_thn.$nom.$randno;
	}

	return $code;
	}


	//===method 2======

	function arsipcode2(){

		$dateNow 	= date('d/m/Y');
		$getDate 	= explode("/",$dateNow);
		$tgl 		= $getDate[0];
		$bln 		= $getDate[1];
		$thn 		= $getDate[2];

		$short_thn  = substr($thn,2,2);
		$dates 		= $tgl.$bln.$short_thn;
	
		$char	= 'EF'.$dates;
		$randno = rand(10,99);
		$awal	= $char.'0001'.$randno;
	
		$query		=	"SELECT TOP 1 kd_arsip FROM arsip WHERE kd_arsip LIKE '$char%' ORDER BY kd_arsip DESC";
	
		$select		=	mssql_query($query);
		$ada		=	mssql_num_rows($select);
		$res		=	mssql_fetch_assoc($select);
	
		if($ada == 0){
			$code	=	$awal;
		}else{
			$nomor	=	substr($res['kd_arsip'],8,4);
			$seqno  =	$nomor  + 1;
			$countNo=	strlen($seqno);
			
			if($countNo == 1){$nom	=	'000'.$seqno;}
			elseif($countNo == 2){$nom	=	'00'.$seqno;}
			elseif($countNo == 3){$nom	=	'0'.$seqno;}
	
			$code	=	$char.$nom.$randno;
		}
	
		return $code;
		}
	


//====================================== FUNGSI KODE HIBAH OTOMATIS =========================

function hibahcode($tgl){

	$getthn = explode("/",$tgl);
	$tgl 	= $getthn[0];
	$bln 	= $getthn[1];
	$thn 	= $getthn[2];


	$char	= "H";
	$randno = rand(10,99);
	$awal	= $thn.$char.$bln.'0001'.$randno.$tgl;

	$query		=	"SELECT TOP 1 kd_hibah FROM asset_hibah ORDER BY id_hibah DESC";
	$select		=	mssql_query($query);
	$ada		=	mssql_num_rows($select);
	$res		=	mssql_fetch_assoc($select);

	if($ada){
		$nomor	=	substr($res['kd_hibah'],7,4);
		$seqno  =	$nomor  + 1;
		$countNo=	strlen($seqno);
		
		if($countNo == 1){$nom	=	'000'.$seqno;}
		elseif($countNo == 2){$nom	=	'00'.$seqno;}
		elseif($countNo == 3){$nom	=	'0'.$seqno;}

		$code	=	$thn.$char.$bln.$nom.$randno.$tgl;
		
	}else{
		$code	=	$awal;
	}

	return $code;
	}

//====================================== FUNGSI KODE MUSNAH OTOMATIS =========================	

function musnahcode($tgl){

	$getthn = explode("/",$tgl);
	$tgl 	= $getthn[0];
	$bln 	= $getthn[1];
	$thn 	= $getthn[2];


	$char	= "N";
	$randno = rand(10,99);
	$awal	= $thn.$char.$bln.'0001'.$randno.$tgl;

	$query		=	"SELECT TOP 1 kd_musnah FROM asset_musnah ORDER BY id_musnah DESC";
	$select		=	mssql_query($query);
	$ada		=	mssql_num_rows($select);
	$res		=	mssql_fetch_assoc($select);

	if($ada){
		$nomor	=	substr($res['kd_musnah'],7,4);
		$seqno  =	$nomor  + 1;
		$countNo=	strlen($seqno);
		
		if($countNo == 1){$nom	=	'000'.$seqno;}
		elseif($countNo == 2){$nom	=	'00'.$seqno;}
		elseif($countNo == 3){$nom	=	'0'.$seqno;}

		$code	=	$thn.$char.$bln.$nom.$randno.$tgl;
		
	}else{
		$code	=	$awal;
	}

	return $code;
	}


//====================================== FUNGSI KODE HILANG OTOMATIS =========================

function hilangcode($tgl){
	
	$getthn = explode("/",$tgl);
	$tgl 	= $getthn[0];
	$bln 	= $getthn[1];
	$thn 	= $getthn[2];


	$char	= "L";
	$randno = rand(10,99);
	$awal	= $thn.$char.$bln.'0001'.$randno.$tgl;

	$query		=	"SELECT TOP 1 kd_hilang FROM asset_hilang ORDER BY id_hilang DESC";
	$select		=	mssql_query($query);
	$ada		=	mssql_num_rows($select);
	$res		=	mssql_fetch_assoc($select);

	if($ada){
		$nomor	=	substr($res['kd_hilang'],7,4);
		$seqno  =	$nomor  + 1;
		$countNo=	strlen($seqno);
		
		if($countNo == 1){$nom	=	'000'.$seqno;}
		elseif($countNo == 2){$nom	=	'00'.$seqno;}
		elseif($countNo == 3){$nom	=	'0'.$seqno;}

		$code	=	$thn.$char.$bln.$nom.$randno.$tgl;
		
	}else{
		$code	=	$awal;
	}

	return $code;
	}


// //====================================== FUNGSI KODE TYPE OTOMATIS =========================

// 	function auto_kd_type($kategori){
// 	//$kategori = 'b';

// 	$que 		= "SELECT TOP 1 kd_type FROM mstype_asset WHERE kd_kategori LIKE '$kategori%' ORDER BY kd_type DESC";
// 	$selectNo 	= mssql_query($que);
// 	$snm	 	= mssql_fetch_assoc($selectNo);

// 	$alfa = (substr($snm['kd_type'],1,1));
// 	$nodb = (substr($snm['kd_type'],0,1));

// 	if($alfa == 'A' || $alfa == 'a'){ $num = 1;}
// 	if($alfa == 'B' || $alfa == 'b'){ $num = 2;}
// 	if($alfa == 'C' || $alfa == 'c'){ $num = 3;}
// 	if($alfa == 'D' || $alfa == 'd'){ $num = 4;}
// 	if($alfa == 'E' || $alfa == 'e'){ $num = 5;}
// 	if($alfa == 'F' || $alfa == 'f'){ $num = 6;}
// 	if($alfa == 'G' || $alfa == 'g'){ $num = 7;}
// 	if($alfa == 'H' || $alfa == 'h'){ $num = 8;}
// 	if($alfa == 'I' || $alfa == 'i'){ $num = 9;}
// 	if($alfa == 'J' || $alfa == 'j'){ $num = 10;}
// 	if($alfa == 'K' || $alfa == 'k'){ $num = 11;}
// 	if($alfa == 'L' || $alfa == 'l'){ $num = 12;}
// 	if($alfa == 'M' || $alfa == 'm'){ $num = 13;}
// 	if($alfa == 'N' || $alfa == 'n'){ $num = 14;}
// 	if($alfa == 'O' || $alfa == 'o'){ $num = 15;}
// 	if($alfa == 'P' || $alfa == 'p'){ $num = 16;}
// 	if($alfa == 'Q' || $alfa == 'q'){ $num = 17;}
// 	if($alfa == 'R' || $alfa == 'r'){ $num = 18;}
// 	if($alfa == 'S' || $alfa == 's'){ $num = 19;}
// 	if($alfa == 'T' || $alfa == 't'){ $num = 20;}
// 	if($alfa == 'U' || $alfa == 'u'){ $num = 21;}
// 	if($alfa == 'V' || $alfa == 'v'){ $num = 22;}
// 	if($alfa == 'W' || $alfa == 'w'){ $num = 23;}
// 	if($alfa == 'X' || $alfa == 'x'){ $num = 24;}
// 	if($alfa == 'Y' || $alfa == 'y'){ $num = 25;}
// 	if($alfa == 'Z' || $alfa == 'z'){ $num = 26;}

// 	$maxmenu 	= $num + 1;

// 	if($maxmenu == 1){ $printf = 'A';}
// 	if($maxmenu == 2){ $printf = 'B';}
// 	if($maxmenu == 3){ $printf = 'C';}
// 	if($maxmenu == 4){ $printf = 'D';}
// 	if($maxmenu == 5){ $printf = 'E';}
// 	if($maxmenu == 6){ $printf = 'F';}
// 	if($maxmenu == 7){ $printf = 'G';}
// 	if($maxmenu == 8){ $printf = 'H';}
// 	if($maxmenu == 9){ $printf = 'I';}
// 	if($maxmenu == 10){ $printf = 'J';}
// 	if($maxmenu == 11){ $printf = 'K';}
// 	if($maxmenu == 12){ $printf = 'L';}
// 	if($maxmenu == 13){ $printf = 'M';}
// 	if($maxmenu == 14){ $printf = 'N';}
// 	if($maxmenu == 15){ $printf = 'O';}
// 	if($maxmenu == 16){ $printf = 'P';}
// 	if($maxmenu == 17){ $printf = 'Q';}
// 	if($maxmenu == 18){ $printf = 'R';}
// 	if($maxmenu == 19){ $printf = 'S';}
// 	if($maxmenu == 20){ $printf = 'T';}
// 	if($maxmenu == 21){ $printf = 'U';}
// 	if($maxmenu == 22){ $printf = 'V';}
// 	if($maxmenu == 23){ $printf = 'W';}
// 	if($maxmenu == 24){ $printf = 'X';}
// 	if($maxmenu == 25){ $printf = 'Y';}
// 	if($maxmenu == 26){ $printf = 'Z';}

// 	$auto = $nodb.$printf;

// 	$cek = mssql_num_rows($selectNo);
// 	if($cek){
// 		$res = $auto;
// 	}else{
// 		$res = 1;
// 	}

// 	return $res;
// }



// //====================================== FUNGSI KODE POSISI OTOMATIS =========================

// 	function auto_kd_lokasi(){
// 	//$kategori = 'b';

// 	$que 		= "SELECT TOP 1 kd_lokasi FROM mslokasi ORDER BY kd_lokasi DESC";
// 	$selectNo 	= mssql_query($que);
// 	$snm	 	= mssql_fetch_assoc($selectNo);

// 	$nodb = (substr($snm['kd_lokasi'],1,1));
// 	$alfa = (substr($snm['kd_lokasi'],0,1));

// 	$first = 'A1';
	

// 	if($alfa == 'A' || $alfa == 'a'){ $num = 1;}
// 	if($alfa == 'B' || $alfa == 'b'){ $num = 2;}
// 	if($alfa == 'C' || $alfa == 'c'){ $num = 3;}
// 	if($alfa == 'D' || $alfa == 'd'){ $num = 4;}
// 	if($alfa == 'E' || $alfa == 'e'){ $num = 5;}
// 	if($alfa == 'F' || $alfa == 'f'){ $num = 6;}
// 	if($alfa == 'G' || $alfa == 'g'){ $num = 7;}
// 	if($alfa == 'H' || $alfa == 'h'){ $num = 8;}
// 	if($alfa == 'I' || $alfa == 'i'){ $num = 9;}
// 	if($alfa == 'J' || $alfa == 'j'){ $num = 10;}
// 	if($alfa == 'K' || $alfa == 'k'){ $num = 11;}
// 	if($alfa == 'L' || $alfa == 'l'){ $num = 12;}
// 	if($alfa == 'M' || $alfa == 'm'){ $num = 13;}
// 	if($alfa == 'N' || $alfa == 'n'){ $num = 14;}
// 	if($alfa == 'O' || $alfa == 'o'){ $num = 15;}
// 	if($alfa == 'P' || $alfa == 'p'){ $num = 16;}
// 	if($alfa == 'Q' || $alfa == 'q'){ $num = 17;}
// 	if($alfa == 'R' || $alfa == 'r'){ $num = 18;}
// 	if($alfa == 'S' || $alfa == 's'){ $num = 19;}
// 	if($alfa == 'T' || $alfa == 't'){ $num = 20;}
// 	if($alfa == 'U' || $alfa == 'u'){ $num = 21;}
// 	if($alfa == 'V' || $alfa == 'v'){ $num = 22;}
// 	if($alfa == 'W' || $alfa == 'w'){ $num = 23;}
// 	if($alfa == 'X' || $alfa == 'x'){ $num = 24;}
// 	if($alfa == 'Y' || $alfa == 'y'){ $num = 25;}
// 	if($alfa == 'Z' || $alfa == 'z'){ $num = 26;}

// 	$maxmenu = $num + 1;

// 	if($maxmenu == 1){ $printf = 'A';}
// 	if($maxmenu == 2){ $printf = 'B';}
// 	if($maxmenu == 3){ $printf = 'C';}
// 	if($maxmenu == 4){ $printf = 'D';}
// 	if($maxmenu == 5){ $printf = 'E';}
// 	if($maxmenu == 6){ $printf = 'F';}
// 	if($maxmenu == 7){ $printf = 'G';}
// 	if($maxmenu == 8){ $printf = 'H';}
// 	if($maxmenu == 9){ $printf = 'I';}
// 	if($maxmenu == 10){ $printf = 'J';}
// 	if($maxmenu == 11){ $printf = 'K';}
// 	if($maxmenu == 12){ $printf = 'L';}
// 	if($maxmenu == 13){ $printf = 'M';}
// 	if($maxmenu == 14){ $printf = 'N';}
// 	if($maxmenu == 15){ $printf = 'O';}
// 	if($maxmenu == 16){ $printf = 'P';}
// 	if($maxmenu == 17){ $printf = 'Q';}
// 	if($maxmenu == 18){ $printf = 'R';}
// 	if($maxmenu == 19){ $printf = 'S';}
// 	if($maxmenu == 20){ $printf = 'T';}
// 	if($maxmenu == 21){ $printf = 'U';}
// 	if($maxmenu == 22){ $printf = 'V';}
// 	if($maxmenu == 23){ $printf = 'W';}
// 	if($maxmenu == 24){ $printf = 'X';}
// 	if($maxmenu == 25){ $printf = 'Y';}
// 	if($maxmenu == 26){ $printf = 'Z';}

// 	if($maxmenu == 27){
// 		$huruf = 'A';
// 		$no = $nodb + 1;
// 	}else{
// 		$huruf = $printf;
// 		$no = $nodb;
// 	}

// 	$auto = $huruf.$no;
	
// 	$cek = mssql_num_rows($selectNo);
// 	if($cek){
// 		$res = $auto;
// 	}else{
// 		$res = $first;
// 	}

// 	return $res;
// }


?>