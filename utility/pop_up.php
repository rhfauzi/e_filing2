<div class="modal fade" id="myModal1" role="dialog">
<div class="modal-dialog" style="width: 800px">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan pemindahan Arsip</h4>
      <!-- <div style="float: right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Action</th>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
				
                     $query  =   mssql_query("SELECT * FROM mslokasi");
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $kd_lokasi  =   $data['kd_lokasi'];
                            $lokasi  	=   $data['lokasi'];
                            
                ?>
                    <td width="10%" align="center"><? echo $no; ?></td>
                    <td width="20%"><? echo $kd_lokasi ?></td>
                    <td width="55%"><? echo $lokasi; ?></td>
                    <td width="15%" align="center">
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_data1('<?php echo $kd_lokasi; ?>');ganti();">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_data1(a){
                               document.getElementById('kd_lokasi3').value=a;
                            } 
                        </script>                                      
                </tr>
                <?php
                    $no++;
                        }
                    }
                ?>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>



<div class="modal fade" id="myModal2" role="dialog">
<div class="modal-dialog" style="width: 800px">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan pemindahan Arsip</h4>
      <!-- <div style="float: right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Action</th>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
                
                     $query  =   mssql_query("SELECT * FROM mslokasi");
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $kd_lokasi  =   $data['kd_lokasi'];
                            $lokasi     =   $data['lokasi'];
                            
                ?>
                    <td width="10%" align="center"><? echo $no; ?></td>
                    <td width="20%"><? echo $kd_lokasi ?></td>
                    <td width="55%"><? echo $lokasi; ?></td>
                    <td width="15%" align="center">
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_data2('<?php echo $kd_lokasi; ?>');ganti1();">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_data2(a){
                               document.getElementById('kd_lokasi2').value=a;
                            } 

                            function ganti1(){
                                var kd_lokasi2 = $("#kd_lokasi2").val();
                                
                                $.ajax({
                                    url: "pages/procombox.php?act=rak3",
                                    data: "kd_lokasi=" + kd_lokasi2,
                                    success: function(data){
                                        // jika data sukses diambil dari server, tampilkan di <select id=kota>
                                        $("#kd_rak2").attr("disabled",false);
                                        $("#kd_rak2").html(data);
                                        //alert(data);
                                    }
                                });
                            }
                        </script>                                      
                </tr>
                <?php
                    $no++;
                        }
                    }
                ?>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>



<div class="modal fade" id="myModal3" role="dialog">
<div class="modal-dialog" style="width: 800px">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Pilih Lokasi tujuan pemindahan Arsip</h4>
      <!-- <div style="float: right;"><a href="#" data-dismiss="modal" onclick="pilih_kosong2()">Cancel</a></div> -->
    </div>
    <div class="modal-body">
       <table width="100%" class="datatable-1 table table-bordered table-striped display" id="dataTables-example">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Action</th>
                </tr>
                
            </thead>
            <tbody>
                
                <tr class="">
                <?php
                
                    $query  =   mssql_query("SELECT * FROM mslokasi");
                    $no=1;
                    if (mssql_num_rows($query)) {
                        while ($data    =   mssql_fetch_assoc($query)) {
                            $kd_lokasi  =   $data['kd_lokasi'];
                            $lokasi     =   $data['lokasi'];
                            
                ?>
                    <td width="10%" align="center"><? echo $no; ?></td>
                    <td width="20%"><? echo $kd_lokasi ?></td>
                    <td width="55%"><? echo $lokasi; ?></td>
                    <td width="15%" align="center">
                    <a href="#" data-dismiss="modal" 
                    onclick="pilih_data3('<?php echo $kd_lokasi; ?>');ganti2();">Pilih</a>
                    </td>
                       <script>                                                         
                            function pilih_data3(a){
                               document.getElementById('kd_lokasi').value=a;
                            } 

                            function ganti2(){
                                var kd_lokasi = $("#kd_lokasi").val();
                                
                                $.ajax({
                                    url: "pages/procombox.php?act=rak3",
                                    data: "kd_lokasi=" + kd_lokasi,
                                    success: function(data){
                                        // jika data sukses diambil dari server, tampilkan di <select id=kota>
                                        $("#kd_rak").attr("disabled",false);
                                        $("#kd_rak").html(data);
                                        $("#kd_box").val("");
                                        $("#kd_box").attr("disabled",true);
                                        //alert(data);
                                    }
                                });
                            }
                        </script>                                      
                </tr>
                <?php
                    $no++;
                        }
                    }
                ?>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>







