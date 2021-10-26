<script src="js/jquery-1.11.1.min.js"></script>  <!-- harus ada disetiap page kecuali yang ada autocomplete -->
<script src="js/bootstrap.min.js"></script> <!-- harus ada disetiap page kecuali yang ada autocomplete -->

<html>
<body>
<center><h1 style=color:#666666>Content Management System MOIS</h1><br>
<?php 
$cekuser = mssql_fetch_assoc(mssql_query("SELECT groupmenu FROM usermenu where iduser ='".$_SESSION['iduser']."'"));
if($cekuser['groupmenu'] == '5'){
	echo "<h1 style=color:#666666><u>Halaman Khusus Penilaian Kinerja Marketing (PKM)</u></h1><br><br><br>";
}
?>
				<table border=0px>
					<tr>
						<td width='300px' align='center'><img src="img/logo_login.png" width='230px' height='100px'></td>
						<td width='300px' align='center'><img src="img/mois_logo.png" width='230px' height='100px'></td>
					</tr>
				</table>
				<br><br><br><br>
				Untuk cara penggunaan silakan download petunjuknya dibawah ini<br><br>
				<a href='#'><img src="img/pdf.png" height=70px width=70px></a>
				<a href='#'><img src="img/word_2013.png" height=70px width=70px></a>
				</center>
</body>
</html>