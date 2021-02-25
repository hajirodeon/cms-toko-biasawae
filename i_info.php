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
 
 

//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_info ".
						"ORDER BY postdate DESC LIMIT 0,5");
$rtyk = mysqli_fetch_assoc($qtyk);


do 
	{
	$nomer = $nomer + 1;
	$e_kd = nosql($rtyk['kd']);
	$e_postdate = balikin($rtyk['postdate']);
	$e_nama = balikin($rtyk['judul']);
	$url_cantik = trim(seo_friendly_url($e_nama));
	


	echo '<div align="left">
	<a href="'.$sumber.'/info.php?'.$url_cantik.'&artkd='.$e_kd.'" title="'.$e_nama.'">
	<p>'.$e_nama.'</p>
	</a>
	</div>';

	}
while ($rtyk = mysqli_fetch_assoc($qtyk));


?>