<?php
/*
 ****************************************************************** 
 * CMS-TOKO-BIASAWAE v1.0 (code : Daun Muda). 2018
 ******************************************************************
 * Dikembangkan oleh : Agus Muhajir                               *
 * http://github.com/hajirodeon                                   * 
 * http://hajirodeon.wordpress.com                                *
 * http://facebook.com/hajirodeon                                 *
 * sms/wa/telegram : 081-829-88-54                                *
 * email : hajirodeon@gmail.com                                   *
 * ****************************************************************
 */
 
 

session_start();



//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("template/$temaku/cp_config.php");
$tpl = LoadTpl("template/$temaku/reg.php");

	


nocache;

//nilai
$filenya = "reg.php";
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);
$judul = "Menjadi Member";
$judulku = $judul;
$ke = "$sumber/$filenya";

			







//isi *START
ob_start();


require("i_statistik.php");

//isi
$istatistik = ob_get_contents();
ob_end_clean();











//isi *START
ob_start();


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();


require("template/js/number.js");


?>



<script language='javascript'>
//membuat document jquery
$(document).ready(function(){



$("#ilogin").load("i_reg.php?aksi=form");


});

</script>




<?php
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5">
<tr>
<td valign="top">


<div id="ilogin">
<img src="template/img/progress-bar.gif" width="100" height="16">
</div>

<hr>

<div id="iproses" style="display:none">
<img src="template/img/progress-bar.gif" width="100" height="16">
</div>


<div id="ihasil"></div>			

	
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi
$isi = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();


require("i_member_menu.php");

//isi
$member_menu = ob_get_contents();
ob_end_clean();







require("inc/niltpl.php");


exit();
?>