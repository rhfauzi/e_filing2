use E_FILING;
INSERT INTO menu(idmenu, idutama, namamenu, menuprogram, menupendahulu, filemenu, icon, menuorder, aktif) 
VALUES (67, 2, 'Upload Documents', 'upload_file', 29, 'pages/uploadscan_form.php', 'arsip.png', 5, 'Y');

INSERT INTO groupmenu (groupmenu, idmenu) VALUES (1, 67),(2, 67),(3,67),(4,67),(5,67),(6,67),(7,67),(8,67);

ALTER TABLE ARSIP_SCAN ADD fileSource Int NULL;
ALTER TABLE ARSIP_SCAN ADD saveHardcopy Int NULL;
ALTER TABLE ARSIP ADD saveHardcopy Int NULL;

update msstatus set style='style=color:#000000'  where id_status=5