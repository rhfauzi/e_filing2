<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div style='margin:5px 0 0 30px;'>
        <img src="images/brinsave-text.png" width="200px">
        
    </div>
    
</div>
<!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
            <li >
                <?php 
            echo "<i>".$nm_pegawai."</i>| ";
                ?>
            </li>
            <li>
                <?php 
            echo $unitkerja."| ";
                ?>
            </li>
            <li>
                <?php 
            echo "<b>".$groupdesc."</b>";
                ?>
            </li>
                    <!-- <ul class="dropdown-menu dropdown-alerts">
                        <?php

                        // // $Quedata = "SELECT TOP 10 * FROM arsip WHERE tgl_masuk BETWEEN convert(date,getdate()) AND convert(date,getdate() -7) ORDER by id_arsip desc"; 
                        // $Quedata = "SELECT TOP 3 * FROM arsip ORDER by id_arsip desc";
                        // $SqlData = mssql_num_rows(mssql_query($Quedata));

                        // if($SqlData > 0){

                        // echo "
                        // <li>
                        //     <a href='#'>
                        //         <div>
                        //             <i class='fa fa-file-archive-o fa-fw' style='color:#4dd802;'></i>
                        //             <font style='color:#c40c00;'> ".$SqlData."</font><i style='color:#0093ff;'> Data Arsip Baru </i>
                        //             <span class='pull-right text-muted small'></span>
                        //         </div>
                        //     </a>
                        // </li>";
                        // }

                        // //Query menggunakan waktu

                        // // $Quedata2 = "SELECT * from
                        // //             (
                        // //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        // //             FROM mskategori 
                        // //             order by id_kategori desc
                        // //             ) as x where x.tgl between convert(varchar,getdate(),105) and convert(varchar,getdate()-7,105) 
                        // //             and x.data_status = 'N'";

                        // $Quedata2 = "SELECT * from
                        //             (
                        //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        //             FROM mskategori 
                        //             order by id_kategori desc
                        //             ) as x where x.data_status = 'N'";

                        // $SqlData2 = mssql_num_rows(mssql_query($Quedata2));


                        // if($level == '3' || $level == '4' || $level == '5'){
                        //     echo "
                        //     <li>
                        //         <a href='#'>
                        //             <div>
                        //                 <i class='fa fa-th-large fa-fw' style='color:#00ffa2;'></i>
                        //                 <font style='color:#c40c00;'> ".$SqlData2."</font><i style='color:#0093ff;'> Data Kategori Baru Belum Approve </i>
                        //                 <span class='pull-right text-muted small'></span>
                        //             </div>
                        //         </a>
                        //     </li>";
                        // }


                        // //Query menggunakan waktu

                        // // $Quedata4 = "SELECT * from
                        // //             (
                        // //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        // //             FROM msrak 
                        // //             order by id_rak desc
                        // //             ) as x where x.tgl between convert(varchar,getdate(),105) and convert(varchar,getdate()-7,105) 
                        // //             and x.data_status = 'N'";

                        //  $Quedata4 = "SELECT * from
                        //             (
                        //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        //             FROM msrak 
                        //             order by id_rak desc
                        //             ) as x where x.data_status = 'N'";

                        // $SqlData4 = mssql_num_rows(mssql_query($Quedata4));


                        // if($level == '3' || $level == '4' || $level == '5'){
                        //     echo "
                        //     <li>
                        //         <a href='#'>
                        //             <div>
                        //                 <i class='fa fa-tasks fa-fw' style='color:#0078dd;'></i>
                        //                 <font style='color:#c40c00;'> ".$SqlData4." </font><i style='color:#0093ff;'>Data Rak Baru Belum Approve</i>
                        //                 <span class='pull-right text-muted small'></span>
                        //             </div>
                        //         </a>
                        //     </li>";
                        // }

                        // //Query menggunakan waktu

                        // // $Quedata5 = "SELECT * from
                        // //             (
                        // //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        // //             FROM msbox 
                        // //             order by id_box desc
                        // //             ) as x where x.tgl between convert(varchar,getdate(),105) and convert(varchar,getdate()-7,105) 
                        // //             and x.data_status = 'N'";

                        // $Quedata5 = "SELECT * from
                        //             (
                        //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        //             FROM msbox 
                        //             order by id_box desc
                        //             ) as x where x.data_status = 'N'";

                        // $SqlData5 = mssql_num_rows(mssql_query($Quedata5));


                        // if($level == '3' || $level == '4' || $level == '5'){
                        //     echo "
                        //     <li>
                        //         <a href='#'>
                        //             <div>
                        //                 <i class='fa fa-archive fa-fw' style='color:#ffa200;'></i>
                        //                 <font style='color:#c40c00;'> ".$SqlData5." </font><i style='color:#0093ff;'>Data Box Baru Belum Approve</i>
                        //                 <span class='pull-right text-muted small'></span>
                        //             </div>
                        //         </a>
                        //     </li>";
                        // }

                        // //Query menggunakan waktu

                        // // $Quedata6 = "SELECT * from
                        // //             (
                        // //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        // //             FROM mslokasi 
                        // //             order by id_lokasi desc
                        // //             ) as x where x.tgl between convert(varchar,getdate(),105) and convert(varchar,getdate()-7,105) 
                        // //             and x.data_status = 'N'";

                        //  $Quedata6 = "SELECT * from
                        //             (
                        //             SELECT top 3 *,rtrim(LEFT(input_date,CHARINDEX(' |',input_date))) as tgl
                        //             FROM mslokasi 
                        //             order by id_lokasi desc
                        //             ) as x where x.data_status = 'N'";

                        // $SqlData6 = mssql_num_rows(mssql_query($Quedata6));


                        // if($level == '3' || $level == '4' || $level == '5'){
                        //     echo "
                        //     <li>
                        //         <a href='#'>
                        //             <div>
                        //                 <i class='fa fa-university fa-fw' style='color:#d4f100;'></i>
                        //                 <font style='color:#c40c00;'> ".$SqlData6."</font> <i style='color:#0093ff;'>Data Lokasi Baru Belum Approve</i>
                        //                 <span class='pull-right text-muted small'></span>
                        //             </div>
                        //         </a>
                        //     </li>";
                        // }
                        ?>
                    <!-- </ul> -->
                    <!-- /.dropdown-alerts -->
                <!-- </li> -->
                <!-- /.dropdown -->
            <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li> -->
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li> -->
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
    </ul>

