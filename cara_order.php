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
$tpl = LoadTpl("template/$temaku/cp_cara_order.php");



nocache;

//nilai
$filenya = "cara_order.php";
$filenya_ke = $sumber;
$judul = "Cara Order";
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



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_order");
$rku = mysqli_fetch_assoc($qku);
$ku_judul = balikin($rku['judul']);
$ku_isi = balikin($rku['isi']);



echo '<table width="100%" border="0" cellpadding="5" cellspacing="5">
<tr>
<td>


'.$ku_isi.'



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
