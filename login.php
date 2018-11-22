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
$tpl = LoadTpl("template/$temaku/login.php");



nocache;

//nilai
$filenya = "login.php";
$filenya_ke = $sumber;
$judul = "LOGIN USER";
$judulku = $judul;
$ke = "$sumber/$filenya";






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
	
	
	




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








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



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



?>



<script language='javascript'>
//membuat document jquery
$(document).ready(function(){



$("#ilogin").load("i_login.php?aksi=form");


});

</script>




<?php
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5">
<tr>
<td valign="top">

<div id="ilogin">
<img src="img/progress-bar.gif" width="100" height="16">
</div>

<div id="iloginresult"></div>
	
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>





<?php
//isi
$isi = ob_get_contents();
ob_end_clean();









//isi *START
ob_start();


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();


require("i_member_menu.php");

//isi
$member_menu = ob_get_contents();
ob_end_clean();







require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
