 <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="main.php"><i class="fa fa-dashboard fa-fw"></i>&nbsp;Dashboard</a>
            </li>
            <?php

            $defindex = "main.php?";
            $defparam = "mid=";
            $sesi     = $_SESSION['iduser'];
            // $sesi     = '408';
            $edc        = new encdec();

            $superadmin = mssql_fetch_assoc(mssql_query("SELECT * FROM usermenu WHERE iduser = '".$sesi."'"));

            if($superadmin['groupmenu'] == '1'){

            $select_link = mssql_query("SELECT c.idmenu,
                                                c.menuprogram,
                                                c.namamenu,
                                                c.icon
                                                FROM usermenu a,groupmenu b,menu c
                                                WHERE c.idutama = '1' 
                                                AND a.groupmenu=b.groupmenu 
                                                AND b.idmenu=c.idmenu
                                                AND b.idmenu <= 5 
                                                AND a.iduser='$sesi'
                                                AND c.aktif = 'Y' 
                                                ORDER BY c.menuorder ASC");
                    while($link = mssql_fetch_assoc($select_link)){ 
                    echo "<li>
                            <a href='#'>".$link['icon']." &nbsp;".$link['namamenu']."<span class='fa arrow'></span></a>
                                <ul class='nav nav-second-level' id=".$link['idmenu'].">";
                                    $select_sub_link = mssql_query("SELECT 
                                                                    c.idmenu,
                                                                    c.menuprogram,
                                                                    c.namamenu,
                                                                    c.icon
                                                                    FROM usermenu a,groupmenu b,menu c
                                                                    WHERE c.idutama = '2' 
                                                                    AND a.groupmenu=b.groupmenu 
                                                                    AND b.idmenu=c.idmenu 
                                                                    AND c.menupendahulu = '1'
                                                                    AND a.iduser='".$sesi."'
                                                                    AND c.aktif = 'Y' 
                                                                    ORDER BY c.menuorder ASC"); //sub link
                                    while($sub_link = mssql_fetch_assoc($select_sub_link)){
                                        $urlSub = $defparam.trim($sub_link['menuprogram']);
                                        $urlEncSub = $edc->encrypt($urlSub,true);

                                    echo "<li>
                                            <a href=".$defindex.$urlEncSub.">
                                            <img src=images/".$sub_link['icon']." width=28px height=28px>
                                            &nbsp;&nbsp;&nbsp;".$sub_link['namamenu']."
                                            </a>
                                          </li>";
                                    }
                                echo "</ul>";
                    echo "</li>";
                }
            }

            $select_link = mssql_query("SELECT 
                                        c.idmenu,
                                        c.menuprogram,
                                        c.namamenu,
                                        c.icon
                                        FROM usermenu a,groupmenu b,menu c
                                        WHERE c.idutama = '1' 
                                        AND a.groupmenu=b.groupmenu 
                                        AND b.idmenu=c.idmenu
                                        AND b.idmenu > 5 
                                        AND a.iduser='".$sesi."'
                                        AND c.aktif = 'Y' 
                                        ORDER BY c.menuorder DESC");
                while($link = mssql_fetch_assoc($select_link)){ 

                    echo "<li>
                            <a href='#'>".$link['icon']." &nbsp;".$link['namamenu']."<span class='fa arrow'></span></a>";
                                echo "<ul class='nav nav-second-level'>";
                                    $select_sub_link = mssql_query("SELECT 
                                                                        c.idmenu,
                                                                        c.menuprogram,
                                                                        c.namamenu,
                                                                        c.icon
                                                                        FROM usermenu a,groupmenu b,menu c
                                                                        WHERE c.idutama = '2' 
                                                                        AND a.groupmenu=b.groupmenu 
                                                                        AND b.idmenu=c.idmenu 
                                                                        AND c.menupendahulu = '".$link['idmenu']."'
                                                                        AND a.iduser='".$sesi."'
                                                                        AND c.aktif = 'Y' 
                                                                        ORDER BY c.menuorder ASC"); //sub link
                                while($sub_link = mssql_fetch_assoc($select_sub_link)){
                                    $urlSub = $defparam.trim($sub_link['menuprogram']);
                                    $urlEncSub = $edc->encrypt($urlSub,true);
                                echo '<li>
                                        <a href='.$defindex. $urlEncSub.'>
                                        <img src=images/'.$sub_link['icon'].' width=28px height=28px>&nbsp;&nbsp;&nbsp;'.$sub_link['namamenu'].'
                                        </a>
                                      </li>';
                                }
                        echo '</ul>';
                    echo '</li>';
                }
            ?>
            <li>
                <a href="logout.php"><i class="fa fa-share-square"></i>&nbsp;Logout </a>
            </li>
        </ul>
    </div><!--/.sidebar-->
</div>
                   
