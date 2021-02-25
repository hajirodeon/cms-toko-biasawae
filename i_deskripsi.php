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
 
 

//detail
$qkud = mysqli_query($koneksi, "SELECT * FROM m_profil");
$rkud = mysqli_fetch_assoc($qkud);
$kud_nama = balikin($rkud['nama']);
$kud_tagline = balikin($rkud['tagline']);
$kud_header = balikin($rkud['filex_header']);
$kud_logo = balikin($rkud['filex_logo']);
$kud_telp = balikin($rkud['telp']);



echo "<img src='$sumber/filebox/toko/$kud_header' width='100%' height='150'>
<br>
<br>

<img src='$sumber/filebox/toko/$kud_logo' width='50' height='50' align='left' vspace='5' hspace='5'>
<h1>
$kud_nama
</h1>
<i>$kud_tagline</i>. [Telepon : $kud_telp]";
?>