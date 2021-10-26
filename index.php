<?php
	// function BrowserValid() {
	// 	$server__port = $_SERVER['SERVER_PORT'];
 //        $server__port=='' ? $port = '' : $port = ":".$server__port;
	// 	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE){
	// 		$kode_browser 	= 'IE';
	// 		$browser 		= 'Internet explorer';
	// 	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE){
	// 		$kode_browser 	= 'IE';
	// 		$browser 		= 'Internet explorer';
	// 	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE){
	// 		$kode_browser 	= 'MF';
	// 		$browser 		= 'Mozilla Firefox';
	// 	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE){
	// 		$kode_browser 	= 'GC';
	// 		$browser 		= 'Google Chrome';
	// 	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE){
	// 		$kode_browser 	= 'OM';
	// 		$browser 		= "Opera Mini";
	// 	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE){
	// 		$kode_browser 	= 'OP';
	// 		$browser 		= "Opera";
	// 	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE){
	// 		$kode_browser 	= 'SF';
	// 		$browser 		= "Safari";
	// 	}else{
	// 		$kode_browser 	= 'SE';
	// 		$browser = 'Something else';
	// 	}

	// 	if ($kode_browser!='GC') {
		?>
		<!-- <script>
			var browser = "<?php //echo $browser; ?>";
			var alert 	= alert(browser+' is not compatible with this app.\nPlease use this app from Chrome browser! \n\n(Silakan buka website menggunakan Google Chrome)');
			var kickAss = "<?php //echo "http://".$_SERVER['SERVER_NAME'].$port."/"; ?>";
			if (alert == true ) {
				window.location.href=kickAss;
			}else{
				window.location.href=kickAss;
			}
		</script> -->
		<?php 
	// 	}else{}
	// }

//BrowserValid();
error_reporting(0);
session_start();

			//header("location:../apps/auth/");
			//include "login.php";
			//include "main.php";

if ($_GET['ref']== "") {
	header("location:https://portal.brins.co.id");
}

$_SESSION['iduser'] = $_GET['ref'];

?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="refresh" content="0;url=main.php">
	<title>A3KOL SYARIAH</title>
	<script language="javascript">
		window.location.href = "main.php";
	</script>
</head>

</html>