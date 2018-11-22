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
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/admin.html");


nocache;

//nilai
$filenya = "tema.php";
$judul = "[SETTING]. Tema";
$judulku = "$judul";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();



echo '<div class="row">



<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">';


     	
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">

<div class="col-md-10">

<h3>

Banyak pilihan Tema Template, Silahkan bisa ambil layanan versi premium.
</h3>


					
</div>

</form>



</div>
</div>
</div>

</div>';


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");

//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>