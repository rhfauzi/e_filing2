
<script>
$(document).ready(function() {

	// var API_URL = "http://137.116.136.82/api" //azure
	var API_URL = "http://192.168.13.37:8888/documentservice/public/api" //localhost

	async function loginAPI() {
		return new Promise(function(resolve, reject) {
			$.ajax({
				type: "POST",
				beforeSend: function(request) {
					request.setRequestHeader("Accept", "application/json");
				},
				url: API_URL + "/login",
				data: {
					email: "admin@admin.com",
					password: "password"
				},
				success: function (data) {
					resolve(data)
				},
				error: function (err) {
					reject(err)
				}
			})
	  })
	}

	async function mergeDocuments(files) {
		return new Promise(function(resolve, reject) {
			var	nm_documents = $("#nm_documents").val()
			var	no_document  = $("#no_document").val()
			
	    	var form_data = new FormData()
			form_data.append("filename", nm_documents)

			$.each(files, function(i, file) {
			   form_data.append('original_files[]', file)
			})

			$.ajax({
				type: "POST",
				url: API_URL + "/document-merges",
				data: form_data,
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					resolve(data)
				},
				error: function (err) {
					reject(err)
				}
			})
	  })
	}

	async function doOCR(token, file) {
		return new Promise(function(resolve, reject) {
	    	var form_data = new FormData()
			form_data.append('original_file', file)

			$.ajax({
				type: "POST",
				beforeSend: function(request) {
					request.setRequestHeader("Authorization", "Bearer " + token)
				},
				url: API_URL + "/document-ocrs",
				data: form_data,
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					resolve(data)
				},
				error: function (err) {
					reject(err)
				}
			})
	  })
	}

	async function saveData(result, total_pages) {
		return new Promise(function(resolve, reject) {
			var	nm_documents=	$("#nm_documents").val();
			var	unit_kerja  =	$("#unit_kerja").val();
			var	no_document =	$("#no_document").val();
			var	tahun       =	$("#tahun").val();
			var	fileups     =	$("#fileups").val();
			var chk_hardcopy  =   $("input[name='chk_hardcopy']:checked").val();
	    	var fileSource  =   1;
		  	var	filename     =	$("#textups").first().text();
			var	kd_kategori  =	$("#kd_kategori").val();

			var form_data = new FormData()
			form_data.append('act', 'uploadscan1')
			form_data.append('nm_documents', nm_documents)
			form_data.append('unit_kerja', unit_kerja)
			form_data.append('no_document', no_document)
			form_data.append('tahun', tahun)
			form_data.append('chk_hardcopy', chk_hardcopy)
			form_data.append('file_content', result)
			form_data.append('file_source', fileSource)
			form_data.append('filename', filename)
			form_data.append('total_pages', total_pages)
			form_data.append('kd_kategori', kd_kategori)

			$.ajax({
				type: "POST",
				url: "execute/exc_uploadscan.php",
				data: form_data,
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					resolve(data)
				},
				error: function (err) {
					reject(err)
				}
			})
		})
	}

	function downloadMergedFile(url) {
		// fetch(url, {
		// 	headers: {
	  //       'Content-Type': 'application/json; charset=utf-8',
		// 			'Access-Control-Allow-Origin': '*'
	  //   }
		// }).then(response => response.blob())
		// .then(response => {
		//     const blob = new Blob([response], {type: 'application/pdf'})
		//     console.log(blob)
		// })

		$.ajax({
			beforeSend: function(request) {
				request.setRequestHeader("Access-Control-Allow-Origin", "*")
			},
		  url: url,
		  success: function(data) {
		    var blob = new Blob([data])
				console.log(blob);
		  }
		})
	}

	$("#simpan").click(function(){
		var files = $("#fileups")[0].files;
		var i = 0;
		var lg = files.length;
		var fileSize = 0;

		for (var i = 0; i < lg; i++) {
			fileSize = fileSize + files[i].size;
		}

		if (fileSize > 500000000) {
			alert('File size is greater than 500MB');
			$("#textups").css("display", "hidden");
		} else {
			var	nm_documents=	$("#nm_documents").val();
			var	no_document =	$("#no_document").val();
			var	tahun       =	$("#tahun").val();
			var	fileups     =	$("#fileups").val();
			var chk_hardcopy=   $("input[name='chk_hardcopy']:checked").val();
			var cekfile=   document.getElementById("fileups").files.length;
			var	kd_kategori     =	$("#kd_kategori").val();

			if(nm_documents == ''){
				window.alert('Mohon untuk mengisi Nama Document terlebih dahulu');
				$("#nm_documents").focus();
			}else if(kd_kategori == 0){
				window.alert('Mohon memilih Kategori terlebih dahulu');
				$("#kd_kategori").focus();
			}else if(cekfile == 0){
				window.alert('Mohon memilih File Document yang akan di Upload terlebih dahulu');
				$("#fileups").focus();
			}else{
				if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

					$(".loader").fadeIn()
					mergeDocuments($('#fileups')[0].files).then(function(data) {
						// console.log(data.data.ocr_result);
						// console.log(data);
						
						saveData(data.data.ocr_result, data.data.result_file.total_pages).then(function(data) {
							$('.loader').css({
								'text-align': 'center',
								'padding-top': $( window ).height() / 2,
								'background': 'rgb(249, 249, 249)'
							})
							// $(".loader").html('<h2 style="color: green">Upload Data Berhasil</h2>')
							setTimeout(function() {
								
							}, 5000)
							$(".loader").fadeOut()

							$("#nm_documents").val("");
							$("#no_document").val("");
							$("#tahun").val("");
							$("#chk_hardcopy").val("");
							$("#fileups").val("");

							if(chk_hardcopy == 0){
								<?php
									$url    = "mid=listarsip&alert=1&ket=disimpan";
									$urlEnc = $edc->encrypt($url,true);
								?>
								window.location = 'main.php?<?php echo $urlEnc ?>'
							}else{
								<?php
									$url    = "mid=alocated&alert=1&ket=disimpan";
									$urlEnc = $edc->encrypt($url,true);
								?>
								window.location = 'main.php?<?php echo $urlEnc ?>'
							}

							// window.location = 'main.php?<?php echo $urlEnc ?>'
						}).catch(function(err) {
							// console.log(err)
							$(".loader").fadeOut()
						})
					}).catch(function(err) {
						console.log(err)
					})

					// loginAPI().then(function(data) {
					//   let token = data.access_token
					// 	// token = "6|gpXnkMsWo8emWWkyYHieIGM2mpAIjQu853ylS6Rp"
					//
					//
					//
					// 	if ($('#fileups')[0].files.length > 1) {
					//
					// 	}else {
					// 		doOCR(token, $('#fileups')[0].files[0]).then(function(data) {
					//
					// 		}).catch(function(err) {
					// 			console.log(err)
					// 		})
					// 	}
					// }).catch(function(err) {
					//   console.log(err)
					// })
				}
			}	
		}
	});

});//end jquery document
</script>

<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------
if($param1 == 'alert')
{
	if($isiParam1 == '1'){
		$url = "mid=$isiParam2";
		$urlEnc = $edc->encrypt($url,true);
		// $urlEnc = $url;

        echo "
        <script>
        alert('SUCCESS !, Data berhasil disimpan');
        window.location.href='main.php?$urlEnc';
        </script>
        ";
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>DENIED !</strong> mohon maaf, Data gagal disimpan mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------

$nodoc = "U".date("mdYHis");
?>

<h3>Form Upload Document</h3>
<div style="float:right;">
</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Upload Document</i></div><br>


<div class="panel panel-default">
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<form name="form_scan" method="post" action="pages/uploadscan_pengalokasian.php" enctype='multipart/form-data'>
<input type='hidden' name="uploadscan_form" value="yes">
<table width="100%" border="0px">
	<tr>
		<td width="20%">Nama Document</td>
		<td width="30%">
		    <input type='text' id='nm_documents'  name="nm_documents"  class="form-control ukuran10">
		</td>
		<td width="40%" colspan="2" rowspan="9">
            <div class="box-multi-upload">
                <label>Upload File</label>
                <input type='file' id='fileups'  name="fileups[]" multiple="multiple"  class="form-control" accept="application/pdf">
                <div id="textups" style="display: none;"></div>
				<label id="currentSize" class="text">Current Size 0 MB</label><br/>
                <label class="text">Maximum Size 500 MB</label>
            </div>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Kategori</td>
		<td>
			<select id='kd_kategori' name="kd_kategori" class="form-control ukuran10">
				<option value='0'>~ Pilih Kategori ~</option>
				<option value='Biasa'>Biasa</option>
				<option value='Rahasia'>Rahasia</option>
			</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Unit Kerja</td>
		<td>
			<!-- <select id='unit_kerja' name="unit_kerja" class="form-control ukuran10">
			<option value='0'>~ Pilih Unit Kerja ~</option>
			<?php
			// $sqllok = mssql_query("SELECT kodeUnit,Unitkerja FROM MSUKER");
			// while($reslok = mssql_fetch_assoc($sqllok)){
			// 	echo"
			// 		<option value='".$reslok['kodeUnit']."'>".$reslok['Unitkerja']."</option>
			// 	";
			// }
			?>
			</select> -->
			<input type="hidden" name="unit_kerja" id='unit_kerja' class="form-control ukuran10" value="<?php echo $kodeunit;?>">
			<input type="text" name="desc_unit_kerja" class="form-control ukuran10" value="<?php echo $unitkerja;?>" readonly>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>No Document</td>
		<td>
		    <input type='text' id='no_document'  name="no_document"  class="form-control ukuran10" value="<?php echo $nodoc; ?>" readonly>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Tanggal</td>
		<td>
		    <!-- <input type='text' id='tahun'  name="tahun"  class="form-control ukuran10"> -->
			<input id="tahun" name="tahun" type="text" class="form-control">
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Simpan HardCopy</td>
		<td>
            <label class='ckbox' style="width: 45%">
                <input type='radio' name='chk_hardcopy' id='chk_hardcopy' class='ck' value='1'>
                <span class='checkmark'>Ya</span>
            </label>
            <label class='ckbox' style="width: 45%">
                <input type='radio' name='chk_hardcopy' id='chk_hardcopy' class='ck' value='0' checked>
                <span class='checkmark'>Tidak</span>
            </label>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<!-- <tr><td height="10px" colspan="3"><input type="submit" value="Submit"></td></tr> -->
	<tr>
		<td height="10px" colspan="3">
			<button type="button" id='simpan' class='btn btn-primary' style='width:100%;'>
				Simpan
			</button>
		</td>
	</tr>
</table>
<!-- </form> -->
<br>
</div>
</div>
</div>
</div>

<script type="text/javascript">
  $( function() {
    $( "#tahun" ).datepicker({
    dateFormat: "yy-mm-dd"
  });
  } );

  $('#fileups').bind('change', function() {
		$('#textups').text('')
		var files = this.files;
		var i = 0;
		var lg = files.length;
		var items = files;
		var fileSize = 0;

		if (lg > 0) {
			for (var x = 0; x < lg; x++) {
				fileSize = fileSize + items[x].size;
			}
			if (fileSize > 500000000) {
				alert('File size is greater than 500MB');
				$("#textups").css("display", "hidden");
			} else {
				for ($i=0; i < files.length; i++) {
					var filename = files[i].name + "<br />";
					$("#textups").css("display", "block");
					$("#textups").append(filename);
				}
			}
		}

		$('#currentSize').text('Current Size ' + (fileSize / 1000000) + ' MB')

  });
</script>
