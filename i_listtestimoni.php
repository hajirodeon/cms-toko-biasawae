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
 
 

//daftar testimoni
$qku = mysql_query("SELECT * FROM member_testimoni ".
						"ORDER BY postdate DESC LIMIT 0,50");
$rku = mysql_fetch_assoc($qku);


do 
	{
	$e_postdate = balikin($rku['postdate']);
	$nkualitas = nosql($rku['nilai_kualitas_no']);
	$nmanfaat = nosql($rku['nilai_manfaat_no']);
	$e_isi = balikin($rku['isi']);
	$e_itemkd = nosql($rku['item_kd']);
	$e_nama = balikin($rku['item_nama']);
	$e_mbnama = balikin($rku['member_nama']);
	$e_url_cantik = balikin($rku['url_cantik']);
	$url_cantik = trim(seo_friendly_url($e_nama));
	
	
	//detail
	$qyuk = mysql_query("SELECT * FROM m_item ".
							"WHERE kd = '$e_itemkd'");
	$ryuk = mysql_fetch_assoc($qyuk);
	$yuk_filex1 = balikin($ryuk['filex1']);

	echo "<b>$e_mbnama :</b>
	<p>
	$e_isi
	</p>";
	
	
	

	for ($k=1;$k<=$nkualitas;$k++)
		{
		echo '<img src="template/img/bintang.png" width="16">';
		}
	
	$xkualitas = $arrkualitas[$nkualitas];
	echo ' [Kualitas : '.$xkualitas.']
	<br>';
	
	
	for ($k=1;$k<=$nmanfaat;$k++)
		{
		echo '<img src="template/img/bintang.png" width="16">';
		}
	
	$xmanfaat = $arrmanfaat[$nmanfaat];
	echo ' [Manfaat : '.$xmanfaat.']
	<br>



	<br>
	<p>
	<i>
	['.$e_postdate.'].
	</i>
	</p>
	<table width="100%" border="0">
	<tr>
	<td width="60">
	<a href="'.$sumber.'/item.php?'.$url_cantik.'&itemkd='.$e_itemkd.'" title="'.$e_nama.'">
	<p>
	<img src="'.$sumber.'/filebox/item/'.$e_itemkd.'/'.$yuk_filex1.'" width="50" height="50">
	</p>
	</a>
	
	</td>
	
	<td>
	<a href="'.$sumber.'/item.php?'.$url_cantik.'&itemkd='.$e_itemkd.'" title="'.$e_nama.'">
	<p>'.$e_nama.'</p>
	</a>
	</td>
	</tr>
	</table>
	<hr>';

	}
while ($rku = mysql_fetch_assoc($qku));
?>