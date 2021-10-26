<?php
require '../setting/koneksi.php';
require '../function/changeformat.php';
conDB('.','e_filing');
$getact  = $_GET['act'];
$postact = $_POST['act'];


//---------------------------------------------------- INSERT MENU ---------------------------------------
if($postact == 'addmenu'){
$idmenu			=	$_POST['idmenu'];
$idutama		=	$_POST['idutama'];
$namamenu		=	$_POST['namamenu'];
$filemenu		=	$_POST['filemenu'];
$menuprogram	=	$_POST['menuprogram'];
$menupendahulu	=	$_POST['menupendahulu'];
$menuorder		=	$_POST['menuorder'];
$status			=	$_POST['status'];

$sqlmenu	=	mssql_query("
				INSERT INTO menu(idmenu,idutama,namamenu,filemenu,menuprogram,menupendahulu,menuorder,aktif)
				VALUES(
				'$idmenu','$idutama','$namamenu','$filemenu','$menuprogram','$menupendahulu','$menuorder','$status')");
//if($sqlmenu){
//alert succes or error ada didalam ajax nya
//}else{}
}
//---------------------------------------------------- UPDATE MENU ---------------------------------------
elseif($postact == 'editmenu'){
$idmenu			=	$_POST['idmenu'];
$idutama		=	$_POST['idutama'];
$namamenu		=	$_POST['namamenu'];
$filemenu		=	$_POST['filemenu'];
$menuprogram	=	$_POST['menuprogram'];
$menupendahulu	=	$_POST['menupendahulu'];
$menuorder		=	$_POST['menuorder'];
$status			=	$_POST['status'];


$sqlmenu	=	mssql_query("
				UPDATE menu SET
				idutama			= '$idutama',
				namamenu 		= '$namamenu',
				filemenu 		= '$filemenu',
				menuprogram 	= '$menuprogram',
				menupendahulu 	= '$menupendahulu',
				menuorder 		= '$menuorder',
				aktif 			= '$status'
				WHERE idmenu	= '$idmenu'
				");
//if($sqlmenu){
//alert succes or error ada didalam ajax nya
//}else{}
}
//---------------------------------------------------- DELETE MENU ---------------------------------------
elseif($getact == 'delmenu'){

$idmenu		=	$_GET['id_delmenu'];

$sqlmenu	=	mssql_query("DELETE FROM menu WHERE idmenu	= '".$idmenu."'");

	if($sqlmenu){
		header("location:../main.php?mid=menu&alert=1");
	}else{
		header("location:../main.php?mid=menu&alert=2");
	}
}
//===============================================================================================================

//---------------------------------------------------- INSERT GROUP ---------------------------------------
elseif($postact == 'addgroup'){

$groupmenu			=	$_POST['groupmenu'];
$groupdeskripsi		=	$_POST['groupdeskripsi'];

$insertMenu	=	mssql_query("INSERT INTO groupbsam(groupmenu,
													groupdeskripsi)VALUES('$groupmenu',
																			'$groupdeskripsi')");

}

//---------------------------------------------------- UPDATE GROUP ---------------------------------------

elseif($postact == 'editgroup'){

$id					=	$_POST['id'];
$groupdeskripsi		=	$_POST['groupdeskripsi'];

$insertMenu	=	mssql_query("UPDATE groupbsam SET groupdeskripsi = '$groupdeskripsi' 
												WHERE idgroupbsam ='$id'");


}

//---------------------------------------------------- DELETE GROUP ---------------------------------------

elseif($getact == 'delgroup'){
$id		=	$_GET['id'];

$deletemenu	=	mssql_query("DELETE FROM groupbsam WHERE idgroupbsam = '$id'");

 if($deletemenu){
	header("location:../main.php?mid=groupbrins&alert=1");
 }else{
	header("location:../main.php?mid=groupbrins&alert=2");
 }
}
//==============================================================================================================

//---------------------------------------------------- INSERT USER ---------------------------------------
elseif($postact == 'adduser'){

$groupmenu			=	$_POST['groupmenu'];
$iduser				=	$_POST['iduser'];
$exiduser			=	explode("-",$iduser);

$insertMenu	=	mssql_query("INSERT INTO usermenu(groupmenu,
													iduser)VALUES('$groupmenu',
																	'$exiduser[0]')");

}

//---------------------------------------------------- EDIT USER ---------------------------------------

elseif($postact == 'edituser'){

$groupmenu			=	$_POST['groupmenu'];
$iduser				=	$_POST['iduser'];
$exiduser			=	explode("-",$iduser);

$updateUsermenu	=	mssql_query("UPDATE usermenu SET groupmenu = '$_POST[groupmenu]'
													WHERE iduser  = '$exiduser[0]'");

}


//---------------------------------------------------- DELETE USER ---------------------------------------

elseif($getact == 'deluser'){

$groupmenu		=	$_GET['groupmenu'];
$id				=	$_GET['id'];

$deleteUsermenu	=	mssql_query("DELETE FROM usermenu WHERE iduser  = '$id' AND groupmenu ='$groupmenu'");

	if($deleteUsermenu){
		header("location:../main.php?mid=usermenu&alert=1");
	 }else{
		header("location:../main.php?mid=usermenu&alert=2");
	 }

}


//---------------------------------------------------- INSERT GROUP MENU ---------------------------------------

elseif(isset($_POST['updateGroupMenu'])){
$groupmenu			=	$_POST['groupmenu'];
$idmenu				=	$_POST['idmenu'];
$jumlah				=	count($_POST['jml']);

$deleteGroupmenu	=	mssql_query("DELETE FROM groupmenu WHERE groupmenu = '$groupmenu'");

for($i = 1;$i <= $jumlah;$i++){
	if(!empty($_POST['idmenu_'.$i])){
	$selectMenuPendahulu = mssql_query("SELECT menuPendahulu FROM menu WHERE idmenu ='".$_POST['idmenu_'.$i]."'");
	$smp        = mssql_fetch_assoc($selectMenuPendahulu);
				//idmenu dulu
				$cekGroupMenu	=	mssql_query("SELECT * FROM groupmenu WHERE idmenu='$smp[menuPendahulu]' AND groupmenu = '$groupmenu'");
				$cekGm			=	mssql_num_rows($cekGroupMenu);
				if($cekGm != 0){
					$sqlgmm	=	"SELECT * FROM groupmenu WHERE idmenu='".$_POST['idmenu_'.$i]."' AND groupmenu = '$groupmenu'";
					$selectGmm	=	mssql_query($sqlgmm);
					$cekGmm		=	mssql_num_rows($selectGmm);
					
					if($cekGmm  != 0){
						//tidak ada aksi
					}else{
					
						//echo $_POST['idmenu_'.$i].'<br>';
						$insertMenu	=	mssql_query("
						INSERT INTO groupmenu(groupmenu,idmenu)
						VALUES(
						'$groupmenu','".$_POST['idmenu_'.$i]."'
						)");
					}
				}else{
				
				$insertMenu1	=	mssql_query("
				INSERT INTO groupmenu(groupmenu,idmenu)
				VALUES(
				'$groupmenu','$smp[menuPendahulu]'
				)");
				
				$insertMenu	=	mssql_query("
				INSERT INTO groupmenu(groupmenu,idmenu)
				VALUES(
				'$groupmenu','".$_POST['idmenu_'.$i]."'
				)");
				
				}
}
}
 if($insertMenu){
	header("location:../main.php?mid=groupmenu&alert=1");
 }else{
	header("location:../main.php?mid=groupmenu&alert=2");
 }
}
?>
