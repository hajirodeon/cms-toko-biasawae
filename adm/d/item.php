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
$filenya = "item.php";
$judul = "[MASTER] Data Item";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$kategori = cegah($_REQUEST['kategori']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($_POST['btnBR'])
	{
	//nilai
	$ke = "$filenya?s=baru&kd=$x";
	
	
	//re-direct
	xloc($ke);
	exit();
	}






//nek cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['e_kunci']);
	
	$ke = "$filenya?kunci=$kunci";
	
	
	//re-direct
	xloc($ke);
	exit();
	}









//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$page = nosql($_POST['page']);
	$e_kd = nosql($_POST['e_kd']);
	$e_kode = cegah($_POST['e_kode']);
	$e_nama = cegah($_POST['e_nama']);
	$e_isi = cegah($_POST['e_isi']);
	$e_harga = cegah($_POST['e_harga']);
	$e_berat = cegah($_POST['e_berat']);
	$e_kondisi = cegah($_POST['e_kondisi']);
	$e_jml = cegah($_POST['e_jml']);
	$e_jml_min = cegah($_POST['e_jml_min']);
	$e_kategori = cegah($_POST['e_kategori']);
	
	
	$filex_namex = strtolower($_FILES['filex_foto']['name']);
	$filex_namex2 = strtolower($_FILES['filex_foto2']['name']);
	$filex_namex3 = strtolower($_FILES['filex_foto3']['name']);
	$filex_namex4 = strtolower($_FILES['filex_foto4']['name']);
	$filex_namex5 = strtolower($_FILES['filex_foto5']['name']);

	//bikin url cantik
	$url_cantik = trim(seo_friendly_url($e_nama));
	
	


	//nek null
	if ((empty($e_kode)) OR (empty($e_nama)) OR (empty($e_isi)) OR (empty($e_harga)) OR (empty($e_berat)) OR (empty($e_jml)))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$e_kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);
		$ext_filex2 = substr($filex_namex2, -4);
		$ext_filex3 = substr($filex_namex3, -4);
		$ext_filex4 = substr($filex_namex4, -4);
		$ext_filex5 = substr($filex_namex5, -4);


		if (($ext_filex == ".jpg") OR ($ext_filex2 == ".jpg") OR ($ext_filex3 == ".jpg") OR ($ext_filex4 == ".jpg") OR ($ext_filex5 == ".jpg"))
			{
			//mengkopi file
			$namabaru = "$e_kd-1.jpg";
			$namabaru2 = "$e_kd-2.jpg";
			$namabaru3 = "$e_kd-3.jpg";
			$namabaru4 = "$e_kd-4.jpg";
			$namabaru5 = "$e_kd-5.jpg";
			$foldernya = "../../filebox/item/$e_kd/";
			
			
			//buat folder...
			if (!file_exists('../../filebox/item/'.$e_kd.'')) {
			    mkdir('../../filebox/item/'.$e_kd.'', 0777, true);
				}
		
					

			chmod($foldernya,0777);
			copy($_FILES['filex_foto']['tmp_name'],"../../filebox/item/$e_kd/$namabaru");
			copy($_FILES['filex_foto2']['tmp_name'],"../../filebox/item/$e_kd/$namabaru2");
			copy($_FILES['filex_foto3']['tmp_name'],"../../filebox/item/$e_kd/$namabaru3");
			copy($_FILES['filex_foto4']['tmp_name'],"../../filebox/item/$e_kd/$namabaru4");
			copy($_FILES['filex_foto5']['tmp_name'],"../../filebox/item/$e_kd/$namabaru5");

		

			
			//jika baru
			if ($s == "baru")
				{
				//cek
				$qcc = mysqli_query($koneksi, "SELECT * FROM m_item ".
										"WHERE kode = '$e_kode' ".
										"OR nama = '$e_nama'");
				$rcc = mysqli_fetch_assoc($qcc);
				$tcc = mysqli_num_rows($qcc);
				
				//nek ada
				if ($tcc != 0)
					{
					//re-direct
					$pesan = "Sudah Ada. Silahkan Ganti Yang Lain...!!";
					pekem($pesan,$ke);
					exit();
					}
				else
					{
					//insert
					mysqli_query($koneksi, "INSERT INTO m_item(kd, kode, nama, isi, harga, ".
									"berat, kondisi, jml, jml_min, kategori, ".
									"filex1, filex2, filex3, filex4, filex5, url_cantik, postdate) VALUES ".
									"('$e_kd', '$e_kode', '$e_nama', '$e_isi', '$e_harga', ".
									"'$e_berat', '$e_kondisi', '$e_jml', '$e_jml_min', '$e_kategori', ".
									"'$namabaru', '$namabaru2', '$namabaru3', '$namabaru4', '$namabaru5', '$url_cantik', '$today')");


					//re-direct
					xloc($filenya);
					exit();
					}
				}
				
				
					
					
			//jika update
			if ($s == "edit")
				{
				mysqli_query($koneksi, "UPDATE m_item SET kode = '$e_kode', ".
								"nama = '$e_nama', ".
								"isi = '$e_isi', ".
								"harga = '$e_harga', ".
								"berat = '$e_berat', ".
								"kondisi = '$e_kondisi', ".
								"jml = '$e_jml', ".
								"jml_min = '$e_jml_min', ".
								"kategori = '$e_kategori', ".
								"filex1 = '$namabaru', ".
								"filex2 = '$namabaru2', ".
								"filex3 = '$namabaru3', ".
								"filex4 = '$namabaru4', ".
								"filex5 = '$namabaru5', ".
								"url_cantik = '$url_cantik', ".
								"postdate = '$today' ".
								"WHERE kd = '$kd'");
	
	
				//re-direct
				xloc($filenya);
				exit();
				}
	
					
					
			}
		else
			{
			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			$ke = "$filenya?s=$s&kd=$e_kd";
			pekem($pesan,$ke);
			exit();
			}

		}
	}

	
	
	

//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$ke = $filenya;

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_item ".
						"WHERE kd = '$kd'");
		}


	//auto-kembali
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">



<p>
<input name="btnBR" type="submit" value="BUAT BARU" class="btn btn-danger">
<hr>
</p>';


if (($s == "baru") OR ($s == "edit"))
	{
	//edit
	$qx = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"WHERE kd = '$kd'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_kd = nosql($rowx['kd']);
	$e_kode = balikin($rowx['kode']);
	$e_nama = balikin($rowx['nama']);
	$e_isi = balikin($rowx['isi']);
	$e_harga = nosql($rowx['harga']);
	$e_berat = nosql($rowx['berat']);
	$e_kondisi = nosql($rowx['kondisi']);
	$e_jml = nosql($rowx['jml']);
	$e_jml_min = nosql($rowx['jml_min']);
	$e_kategori = balikin($rowx['kategori']);
	$e_filex1 = balikin($rowx['filex1']);
	$e_filex2 = balikin($rowx['filex2']);
	$e_filex3 = balikin($rowx['filex3']);
	$e_filex4 = balikin($rowx['filex4']);
	$e_filex5 = balikin($rowx['filex5']);



	//jika edit / baru
	//nek null foto
	if (empty($e_filex1))
		{
		$nil_foto = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto = "$sumber/filebox/item/$e_kd/$e_filex1";
		}
		
		
	//nek null foto
	if (empty($e_filex2))
		{
		$nil_foto2 = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto2 = "$sumber/filebox/item/$e_kd/$e_filex2";
		}
		
		
	//nek null foto
	if (empty($e_filex3))
		{
		$nil_foto3 = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto3 = "$sumber/filebox/item/$e_kd/$e_filex3";
		}
		
		
	//nek null foto
	if (empty($e_filex4))
		{
		$nil_foto4 = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto4 = "$sumber/filebox/item/$e_kd/$e_filex4";
		}
		
		
	//nek null foto
	if (empty($e_filex5))
		{
		$nil_foto5 = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto5 = "$sumber/filebox/item/$e_kd/$e_filex5";
		}
		
	
	echo '<table border="0" cellspacing="0" cellpadding="3" bgcolor="white">
	<tr valign="top">
	<td>
	
	<p>
	KODE : 
	<br>
	<input name="e_kode" type="text" size="10" value="'.$e_kode.'" class="btn btn-warning">
	</p>
	
	<p>
	NAMA : 
	<br>
	<input name="e_nama" type="text" size="30" value="'.$e_nama.'" class="btn btn-warning">
	</p>
	
	<p>
	DESKRIPSI ITEM : 
	<br>

	<textarea cols="50" name="e_isi" rows="10" wrap="yes" class="btn-warning">'.$e_isi.'</textarea>
	</p>
	
	
	
	<p>
	HARGA : 
	<br>
	Rp.<input name="e_harga" type="text" size="10" value="'.$e_harga.'" class="btn btn-warning">,-
	</p>
	
	<p>
	BERAT : 
	<br>
	<input name="e_berat" type="text" size="5" value="'.$e_berat.'" class="btn btn-warning"> gram
	</p>
	
	<p>
	KONDISI : 
	<br>
	<select name="e_kondisi" class="btn btn-warning">
	<option value="'.$e_kondisi.'" selected>'.$e_kondisi.'</option>
	<option value="BARU">BARU</option>
	<option value="BEKAS">BEKAS</option>
	</select>
	</p>
	
	<p>
	JUMLAH STOCK : 
	<br>
	<input name="e_jml" type="text" size="5" value="'.$e_jml.'" class="btn btn-warning">
	</p>
	
	
	<p>
	JUMLAH MINIMAL STOCK : 
	<br>
	<input name="e_jml_min" type="text" size="5" value="'.$e_jml_min.'" class="btn btn-warning">
	</p>
	
	<p>
	KATEGORI : 
	<br>';
	
	
	echo '<select name="e_kategori" class="btn btn-warning">
	<option value="'.$e_kategori.'" selected>'.$e_kategori.'</option>';
	
	//daftar kategori
	$qku = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
							"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);
	
	do
		{
		//nilai
		$ku_nama = balikin($rku['nama']);
		
		echo '<option value="'.$ku_nama.'">'.$ku_nama.'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	
	echo '</select>

	</p>
	
	
	
	</td>
	
	<td width="50"></td>
	<td>
	<p>
	<img src="'.$nil_foto.'" width="150" height="150" border="5">
	<br>
	<input name="filex_foto" type="file" size="15" class="btn btn-warning">
	</p>
	
	
	<p>
	<img src="'.$nil_foto2.'" width="150" height="150" border="5">
	<br>
	<input name="filex_foto2" type="file" size="15" class="btn btn-warning">
	</p>
	
	<p>
	<img src="'.$nil_foto3.'" width="150" height="150" border="5">
	<br>
	<input name="filex_foto3" type="file" size="15" class="btn btn-warning">
	</p>
	
	<p>
	<img src="'.$nil_foto4.'" width="150" height="150" border="5">
	<br>
	<input name="filex_foto4" type="file" size="15" class="btn btn-warning">
	</p>
	
	<p>
	<img src="'.$nil_foto5.'" width="150" height="150" border="5">
	<br>
	<input name="filex_foto5" type="file" size="15" class="btn btn-warning">
	</p>
	
	
	
	
	
	<input name="s" type="hidden" value="'.$s.'">
	<input name="e_kd" type="hidden" value="'.$kd.'">
	<input name="page" type="hidden" value="'.$page.'">

	</td>
	</tr>
	</table>
	
	
	<p>
	<hr>	
	<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
	<hr>
	</p>';
	}
	
	
else
	{
	//jika kunci cari
	if (!empty($kunci))
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
		
		$sqlcount = "SELECT * FROM m_item ".
						"WHERE nama LIKE '%$kunci%' ".
						"OR isi LIKE '%$kunci%' ".
						"ORDER BY kode ASC";
		$sqlresult = $sqlcount;
		
		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?kategori=$kategori&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	//jika ada kategori
	else if (!empty($kategori))
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
		
		$sqlcount = "SELECT * FROM m_item ".
						"WHERE kategori = '$kategori' ".
						"ORDER BY kode ASC";
		$sqlresult = $sqlcount;
		
		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?kategori=$kategori&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}
		
	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
		
		$sqlcount = "SELECT * FROM m_item ".
						"ORDER BY kode ASC";
		$sqlresult = $sqlcount;
		
		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?kategori=$kategori&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}
	
	
	
	
	//detail
	$e_kunci = balikin($kunci);
	
	echo '<div class="table-responsive">          
		  <table class="table">
		    <thead>
				
	<tr valign="top">
	<td>

	<p>
	<input name="e_kunci" type="text" size="30" value="'.$e_kunci.'" class="btn btn-warning">
	
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>



	</td>
	<td align="right">';
	
	echo "<select name=\"kategori\" class=\"btn btn-warning\" onChange=\"MM_jumpMenu('self',this,0)\">";
	echo '<option value="'.$kategori.'" selected>'.$kategori.'</option>';
	
	//daftar kategori
	$qku = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
							"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);
	
	do
		{
		//nilai
		$ku_nama = balikin($rku['nama']);
		$ku_nama2 = urlencode(cegah($rku['nama']));
		$ku_nama3 = cegah($rku['nama']);
		
		
		//ketahui jumlah
		$qyuk = mysqli_query($koneksi, "SELECT * FROM m_item ".
								"WHERE kategori = '$ku_nama3'");
		$tyuk = mysqli_num_rows($qyuk);

		echo'<option value="'.$filenya.'?kategori='.$ku_nama2.'">'.$ku_nama.' ['.$tyuk.']</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));


	echo '</select>


	</td>
	</tr>
	</tbody>
		  </table>
		  </div>
		  
		  
	
	<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td width="50"><strong><font color="'.$warnatext.'">KODE</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">HARGA</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">BERAT</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">JUMLAH STOCK</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">JUMLAH MINIMAL STOCK</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">FOTO</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">KATEGORI</font></strong></td>
	</tr>
	
		    </thead>
		    <tbody>';
	
	if ($count != 0)
		{
		do {
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}
	
			$nomer = $nomer + 1;
			$e_kd = nosql($data['kd']);
			$e_kode = balikin($data['kode']);
			$e_nama = balikin($data['nama']);
			$e_url_cantik = balikin($data['url_cantik']);
			$e_harga = nosql($data['harga']);
			$e_berat = nosql($data['berat']);
			$e_jml = nosql($data['jml']);
			$e_jml_min = nosql($data['jml']);
			$filex1 = balikin($data['filex1']);
			$filex2 = balikin($data['filex2']);
			$filex3 = balikin($data['filex3']);
			$filex4 = balikin($data['filex4']);
			$filex5 = balikin($data['filex5']);
			$e_kategori = balikin($data['kategori']);
	
			$url_cantik = trim(seo_friendly_url($e_nama));
			
			
			//bikin url cantik
			mysqli_query($koneksi, "UPDATE m_item SET url_cantik = '$url_cantik' ".
							"WHERE kd = '$e_kd'");
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$e_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$e_kd.'"><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$e_kode.'</td>
			<td>'.$e_nama.'</td>
			<td align="right">'.xduit2($e_harga).'</td>
			<td align="right">'.$e_berat.' Gram</td>
			<td>'.$e_jml.'</td>
			<td>'.$e_jml_min.'</td>
			<td>
			<p>
			<img src="'.$sumber.'/filebox/item/'.$e_kd.'/'.$filex1.'" width="150" height="150">
			</p>

			</td>
			<td>'.$e_kategori.'</td>
	        </tr>';
			}
		while ($data = mysqli_fetch_assoc($result));
		}
	
	
	echo '</tbody>
		  </table>
		  </div>
		  
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
	<input name="jml" type="hidden" value="'.$count.'">
	<br>
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	</tr>
	</table>';
	}
	

echo '</form>



</div>
</div>
</div>
</div>
</div>
</div>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//null-kan
xclose($koneksi);
exit();
?>