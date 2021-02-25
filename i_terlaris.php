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
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"ORDER BY round(jml_terjual) DESC LIMIT 0,20");
$rtyk = mysqli_fetch_assoc($qtyk);


do 
	{
	$nomer = $nomer + 1;
	$e_kd = nosql($rtyk['kd']);
	$e_nama = balikin($rtyk['nama']);
	$e_url_cantik = balikin($rtyk['url_cantik']);
	$e_harga = nosql($rtyk['harga']);
	$e_jml = nosql($rtyk['jml']);
	$filex1 = balikin($rtyk['filex1']);

	$url_cantik = trim(seo_friendly_url($e_nama));
	


	//update jumlah dilihat
	mysqli_query($koneksi, "UPDATE m_item SET jml_dilihat = jml_dilihat + 1 ".
					"WHERE kd = '$e_kd'");
	


	echo '<div align="center">
	<a href="'.$sumber.'/item.php?'.$url_cantik.'&itemkd='.$e_kd.'" title="'.$e_nama.'">
	<p>
	<img src="'.$sumber.'/filebox/item/'.$e_kd.'/'.$filex1.'" width="150" height="150">
	</p>
	<p>'.$e_nama.'</p>
	<p>
	'.xduit2($e_harga).'
	</p>
	
	<p>
	Sisa Stock : '.$e_jml.'
	</p>
	</a>
	</div>
	<hr>
	<br>
	<br>';

	}
while ($rtyk = mysqli_fetch_assoc($qtyk));
?>