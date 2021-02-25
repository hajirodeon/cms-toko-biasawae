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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "paket_d.php";
$judul = "Paket D (Rp. 1jt sampai 5jt)";
$judulku = "[PREMIUM]. $judul";
$judulx = $judul;








//isi *START
ob_start();




//js


echo '<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">



<p>
Paket D (Rp. 1jt sampai 5jt), adalah layanan kastumisasi. 
Bila pada sistem CMS-TOKO-BIASAWAE, 
perlu adanya banyak perubahan agar sesuai keinginan.  
</p>



<hr>


<p>
Informasi lebih lanjut :
<br>
Agus Muhajir
<br>
SMS/WA/TELEGRAM : 081-829-88-54
<br>
FB : hajirodeon
<br>
http://github.com/hajirodeon
</p>


</div>
</div>
</div>
</div>
</div>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>