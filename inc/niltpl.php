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
 
 

//nilai /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$konten = ParseVal($tpl, array ("judul" => $judul,
					"judulku" => $judulku,
					"sumber" => $sumber,
					"isi" => $isi,
					"toko_nama" => $toko_nama,
					"member_menu" => $member_menu,
					"ilistproduk" => $ilistproduk,
					"ilistdiskusi" => $ilistdiskusi,
					"ilisttestimoni" => $ilisttestimoni,
					"ikategori" => $ikategori,
					"irandom" => $irandom,
					"iheadline" => $iheadline,
					"iinfo" => $iinfo,
					"icariproduk" => $icariproduk,
					"iterbaru" => $iterbaru,
					"iterlaris" => $iterlaris,
					"ideskripsi" => $ideskripsi,
					"idaftarproduk" => $idaftarproduk,
					"istatistik" => $istatistik,
					"itestimoni" => $itestimoni,
					"ikontak" => $ikontak,
					"ipembayaran" => $ipembayaran,
					"diload" => $diload,
					"dikeydown" => $dikeydown,
					"i_hajirodeon_rss" => $i_hajirodeon_rss,
					"ke" => $ke,
					"url" => $url,
					"versi" => $versi,
					"author" => $author,
					"keywords" => $keywords,
					"description" => $description));

//tampilkan
echo $konten;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


exit();
?>