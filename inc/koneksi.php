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
 
 

//KONEKSI ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$koneksi = mysqli_connect($xhostname, $xusername, $xpassword, $xdatabase);


// Check connection
if (mysqli_connect_errno()) {
  echo "Koneksi ERROR: " . mysqli_connect_error();
  exit();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//set default tema original
$temaku = "tema1";



//detail
$qkux = mysqli_query($koneksi, "SELECT * FROM m_profil");
$rkux = mysqli_fetch_assoc($qkux);
$toko_nama = balikin($rkux['nama']);
$toko_keyword = balikin($rkux['keyword']);
$toko_deskripsi = balikin($rkux['deskripsi']);





$author = $toko_nama;
$description = $toko_deskripsi;
$url = $sumber;
$keywords = $toko_keyword;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>