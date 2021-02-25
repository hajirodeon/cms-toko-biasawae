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
$tpl = LoadTpl("template/$temaku/cp_cari.php");



nocache;

//nilai
$filenya = "cari.php";
$filenya_ke = $sumber;
$judul = "Hasil Pencarian";
$judulku = $judul;
$kunci = cegah($_REQUEST['kunci']);
$ke = "$sumber/$filenya?kunci=$kunci";





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


echo '<h3>Pencarian : '.$kunci.'</h3>';
echo '<div class="row">';


//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"WHERE nama LIKE '%$kunci%' ".
						"OR isi LIKE '%$kunci%' ".
						"ORDER BY postdate DESC");
$rtyk = mysqli_fetch_assoc($qtyk);
$ttyk = mysqli_num_rows($qtyk);

//jika ada
if (!empty($ttyk))
	{
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
		
		
	
	
	
		echo '<div class="col-md-6">';
	
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
		<br>
		
	
		</div>';
	
		}
	while ($rtyk = mysqli_fetch_assoc($qtyk));
	}

	
else
	{
	echo '<div class="col-md-6">

	<h3>
	<font color="red">
	Item Tidak Ditemukan...
	</font>
	</h3>
	
	</div>';
	}


echo '</div>';




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