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
$tpl = LoadTpl("template/$temaku/cp_depan.php");



nocache;

//nilai
$filenya = "index.php";
$filenya_ke = $sumber;
$judul = "Selamat Datang di Toko $toko_nama";
$judulku = $judul;
$ke = $sumber;



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


require("i_deskripsi.php");

//isi
$ideskripsi = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();


require("i_headline.php");

//isi
$iheadline = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();


require("i_terlaris.php");

//isi
$iterlaris = ob_get_contents();
ob_end_clean();













//isi *START
ob_start();


require("i_terbaru.php");

//isi
$iterbaru = ob_get_contents();
ob_end_clean();




















//isi *START
ob_start();


require("i_listdiskusi.php");


//isi
$ilistdiskusi = ob_get_contents();
ob_end_clean();

















//isi *START
ob_start();


require("i_listtestimoni.php");


//isi
$ilisttestimoni = ob_get_contents();
ob_end_clean();




















//isi *START
ob_start();


require("i_listproduk.php");


//isi
$ilistproduk = ob_get_contents();
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