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
$tpl = LoadTpl("template/$temaku/cp_member_history.php");



nocache;

//nilai
$filenya = "member_history.php";
$judul = "History Transaksi";
$judulku = $judul;
$sesikd = nosql($_SESSION['kd6_session']);
$sesinama = cegah($_SESSION['nama6_session']);
$s = nosql($_REQUEST['s']);
$notakd = nosql($_REQUEST['notakd']);




//proses /////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan testimoni
if ($_POST['btnKRMx'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$total = nosql($_POST['total']);
	$notakd = nosql($_POST['notakd']);




	//ambil semua
	for ($i=1; $i<=$total;$i++)
		{
		//ambil nilai
		$xyz = md5("$x$i");
		
		$yuk = "kdku";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);
		
		$yuk = "f_isi";
		$yuhu = "$yuk$i";
		$f_isi = cegah($_POST["$yuhu"]);
		
		$yuk = "ikualitas";
		$yuhu = "$yuk$i";
		$ikualitasno = cegah($_POST["$yuhu"]);
		
		$yuk = "imanfaat";
		$yuhu = "$yuk$i";
		$imanfaatno = cegah($_POST["$yuhu"]);
	
	
	
			
		//nota
		$qtyk = mysqli_query($koneksi, "SELECT * FROM member_order ".
								"WHERE kd = '$notakd'");
		$rtyk = mysqli_fetch_assoc($qtyk);
		$notakode = cegah($rtyk['nota_kode']);
	
	
	
	
	
			
		//item
		$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
								"WHERE kd = '$kd'");
		$rtyk = mysqli_fetch_assoc($qtyk);
		$e_nama = cegah($rtyk['nama']);
		
	
		$ikualitas = $arrkualitas[$ikualitasno];
		$imanfaat = $arrmanfaat[$imanfaatno];

			
	
		//cek
		$qcc = mysqli_query($koneksi, "SELECT * FROM member_testimoni ".
								"WHERE member_kd = '$sesikd' ".
								"AND nota_kd = '$notakd' ".
								"AND item_kd = '$kd'");
		$tcc = mysqli_num_rows($qcc);
		
		//jika null, insert
		if (empty($tcc))
			{
			//insert
			mysqli_query($koneksi, "INSERT INTO member_testimoni(kd, member_kd, member_nama, ".
							"nota_kd, nota_kode, item_kd, item_nama, isi, ".
							"nilai_kualitas_no, nilai_manfaat_no, ".
							"nilai_kualitas, nilai_manfaat, postdate) VALUES ".
							"('$xyz', '$sesikd', '$sesinama', ".
							"'$notakd', '$notakode', '$kd', '$e_nama', '$f_isi', ".
							"'$ikualitasno', '$imanfaatno', ".
							"'$ikualitas', '$imanfaat','$today')");
			}
		else
			{
			//update
			mysqli_query($koneksi, "UPDATE member_testimoni SET isi = '$f_isi', ".
							"nilai_kualitas_no = '$ikualitasno', ".
							"nilai_manfaat_no = '$imanfaatno', ".
							"nilai_kualitas = '$ikualitas', ".
							"nilai_manfaat = '$imanfaat', ".
							"postdate = '$today' ".
							"WHERE member_kd = '$sesikd' ".
							"AND nota_kd = '$notakd' ".
							"AND item_kd = '$kd'");
			}
	
	

		}

	
	
	
	//re-direct
	$ke = "$filenya?s=detail&notakd=$notakd&#simpanya";
	xloc($ke);
	exit();
	}










//jika telah diterima
if ($_POST['btnKRMx2'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$total = nosql($_POST['total']);
	$notakd = nosql($_POST['notakd']);


	//ketahui 
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE kd = '$notakd'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	$alamat = balikin($rku['penerima_alamat']);
	$kelurahan = balikin($rku['penerima_kelurahan']);
	$kecamatan = balikin($rku['penerima_kecamatan']);
	$kabupaten = balikin($rku['penerima_kabupaten']);
	$propinsi = balikin($rku['penerima_propinsi']);

	

	$e_alamat = "$alamat, $kelurahan, $kecamatan, $kabupaten, $propinsi";




	//dapatkan lokasi koordinat...................................................................
	$address = urlencode($e_alamat);

	$url = "https://maps.google.com/maps/api/geocode/json?key=$keyku&address=$address";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
	$responseJson = curl_exec($ch);
	curl_close($ch);
	
	$response = json_decode($responseJson);
	
	if ($response->status == 'OK') 
		{
	    $latitude = $response->results[0]->geometry->location->lat;
	    $longitude = $response->results[0]->geometry->location->lng;
		} 









	//update
	mysqli_query($koneksi, "UPDATE member_order SET latx = '$latitude', ".
					"laty = '$longitude', ".
					"tgl_diterima = '$today' ".
					"WHERE kd = '$notakd'");








	//set terjual
	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
						"WHERE nota_kd = '$notakd' ".
						"ORDER BY item_nama ASC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);
	
	do 
		{
		$r_kd = nosql($row['kd']);
		$r_itemkd = nosql($row['item_kd']);
		$r_qty = nosql($row['jumlah']);

				
		//update terjual 
		mysqli_query($koneksi, "UPDATE m_item SET jml_terjual = jml_terjual + '$r_qty' ".
						"WHERE kd = '$r_itemkd'");
		}
	while ($row = mysqli_fetch_assoc($q));






	
	
	//re-direct
	$ke = "$filenya?s=detail&notakd=$notakd&#simpanya2";
	xloc($ke);
	exit();
	}










//jika daftar
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}

//proses /////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();


require("i_headline2.php");

//isi
$iheadline = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_random.php");

//isi
$irandom = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_member_menu.php");



//jika null
if (empty($kd6_session))
	{
	//re-direct
	$ke = "$sumber/login.php";
	xloc($ke);
	exit();	
	}
	

//isi
$member_menu = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();








echo '<form name="formx" id="formx" action="'.$filenya.'" enctype="multipart/form-data" method="post">
<input name="notakd" type="hidden" value="'.$notakd.'">
<input name="s" type="hidden" value="'.$s.'">';


//jika detail
if ($s == "detail")
	{
	$notakd = nosql($_REQUEST['notakd']);
	



	//ketahui nota terakhir, yang belum dibayar
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE member_kd = '$sesikd' ".
							"AND kd = '$notakd'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	$ku_tgl_dikirim = balikin($rku['tgl_dikirim']);
	$ku_tgl_diterima = balikin($rku['tgl_diterima']);
	$ku_jasakirim = balikin($rku['jasakirim']);
	$ku_jasakirim_noresi = balikin($rku['jasakirim_noresi']);
	$ku_nota_kode = balikin($rku['nota_kode']);
	$ku_tgl_booking = balikin($rku['tgl_booking']);
	$ku_barang_jml_jenis = nosql($rku['barang_jml_jenis']);
	$ku_barang_qty = nosql($rku['barang_qty']);
	$ku_barang_berat = nosql($rku['barang_berat']);
	$ku_subtotal = nosql($rku['subtotal']);
	$ku_kodeunik = nosql($rku['kodeunik']);
	$ku_total = nosql($rku['total']);
	$ku_penerima_nama = balikin($rku['penerima_nama']);
	$ku_penerima_telp = balikin($rku['penerima_telp']);
	$ku_penerima_propinsi = balikin($rku['penerima_propinsi']);
	$ku_penerima_kabupaten = balikin($rku['penerima_kabupaten']);
	$ku_penerima_kecamatan = balikin($rku['penerima_kecamatan']);
	$ku_penerima_kelurahan = balikin($rku['penerima_kelurahan']);
	$ku_penerima_alamat = balikin($rku['penerima_alamat']);
	$ku_penerima_kodepos = balikin($rku['penerima_kodepos']);
	$ku_penerima_catatan = balikin($rku['catatan']);



	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd' ".
						"ORDER BY item_nama ASC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);
		

	echo '<input name="btnBTL" type="submit" value="DAFTAR TRANSAKSI" class="btn btn-danger">
	<hr>
	
	<a name="simpanya2"></a>
		
	<table width="100%" border="0">
	<tr valign="top">
	<td>
	<h3>
	Nomor Nota :
	<br>
	<b>'.$ku_nota_kode.'</b>
	</h3>
	
	<h3>
	Tanggal Order :
	<br>
	<b>'.$ku_tgl_booking.'</b>
	</h3>
	
	<h3>
	Total Transfer :
	<br>
	<b>
	'.xduit2($ku_total).'
	</b>	
	</h3>
	
	
	<h3>
	Jumlah Jenis Item : 
	<br>
	<b>'.$ku_barang_jml_jenis.'</b>
	</h3>
	
	</td>
	
	<td>
	
	<h3>
	Jumlah Qty Item : 
	<br>
	<b>'.$ku_barang_qty.'</b>
	</h3>
	
	<h3>
	Berat dalam Paket : 
	<br>
	<b>'.$ku_barang_berat.' Gram</b>
	</h3>
	
	
	<h3>
	Kode Unik : 
	<br>
	<b>'.$ku_kodeunik.'</b>
	</h3>
	
	<h3>
	Jasa Kirim : 
	<br>
	<b>'.$ku_jasakirim.'</b>
	</h3>
	
	<h3>
	NoResi Jasa Kirim : 
	<br>
	<b>'.$ku_jasakirim_noresi.'</b>
	</h3>
	
	</td>
	</tr>
	</table>
		
		
	<hr>


		<h3>
		Penerima Paket :
		</h3>
		<hr>
		
		
		<table width="100%" border="0">
		<tr valign="top">
		<td>
	
		<p>
		Nama :
		<br>
		'.$ku_penerima_nama.'
		</p>
	
		<p>
		Telepon :
		<br> 
		'.$ku_penerima_telp.'
		</p>
		
	
		<p>
		Propinsi : 
		<br>
		'.$ku_penerima_propinsi.'

		</p>
			
		
		<p>
		Kabupaten / Kota :
		<br>
		'.$ku_penerima_kabupaten.'
		</p>
				
		<p>
		Kecamatan :
		<br>
		'.$ku_penerima_kecamatan.'
		</select>
		</p>
	

		</td>
	
		<td>
	
	
		<p>
		Kelurahan :
		<br> 
		'.$ku_penerima_kelurahan.'
		</p>
			
		<p>
		Alamat : 
		<br>
		'.$ku_penerima_alamat.'
		</p>
		
		<p>
		Kode Pos :
		<br> 
		'.$ku_penerima_kodepos.'
		</p>

		<p>
		Catatan untuk Penjual :
		<br>
		'.$ku_penerima_catatan.'
		</p>
		
		
		
		
		</td>
	

		
		</tr>
		</table>';
	?>

	

	  
	  <script>
	  	$(document).ready(function() {
	    $('#table-responsive').dataTable( {
	        "scrollX": true
	    } );
	} );
	  </script>
	  
	<?php
	echo '<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
			<tr bgcolor="'.$warnaheader.'">
          <th>FOTO</th>
          <th>NAMA</th>
          <th>KONDISI</th>
          <th>BERAT</th>
          <th>HARGA</th>
          <th>JUMLAH</th>
          <th>SUBTOTAL</th>
        </tr>
		    </thead>
		    <tbody>';



	do 
		{
		$r_no = $r_no + 1;
		$r_kd = nosql($row['kd']);
		$r_itemkd = nosql($row['item_kd']);
		$r_nama = balikin($row['item_nama']);
		$r_kondisi = balikin($row['item_kondisi']);
		$r_berat = balikin($row['item_berat']);
		$r_filex = balikin($row['item_filex1']);
		$r_harga = nosql($row['item_harga']);
		$r_qty = nosql($row['jumlah']);
		$r_subtotal = nosql($row['subtotal']);
			
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

				
			//stock yang ada
			$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
									"WHERE kd = '$r_itemkd'");
			$rtyk = mysqli_fetch_assoc($qtyk);
			$e_jml = nosql($rtyk['jml']);
			
	
	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td width="150">
			<img src="'.$sumber.'/filebox/item/'.$r_itemkd.'/'.$r_filex.'" width="150">
			</td>
			<td>
			'.$r_nama.'
			
			<hr>';
			
					
			//jika udah selesai, boleh nulis testimoni
			if ($ku_tgl_diterima <> '0000-00-00')
				{
				//cek
				$qcc = mysqli_query($koneksi, "SELECT * FROM member_testimoni ".
										"WHERE member_kd = '$sesikd' ".
										"AND nota_kd = '$notakd' ".
										"AND item_kd = '$r_itemkd'");
				$rcc = mysqli_fetch_assoc($qcc);
				$cc_isi = balikin($rcc['isi']);
				$cc_kualitas_no = nosql($rcc['nilai_kualitas_no']);
				$cc_manfaat_no = nosql($rcc['nilai_manfaat_no']);
				$cc_kualitas = balikin($rcc['nilai_kualitas']);
				$cc_manfaat = balikin($rcc['nilai_manfaat']);
				
				
				//jika null, kasi default
				if (empty($cc_kualitas_no))
					{
					$cc_kualitas_no = 5;
					$cc_kualitas = $arrkualitas[$cc_kualitas_no];
					}
					
				if (empty($cc_manfaat_no))
					{
					$cc_manfaat_no = 5;
					$cc_manfaat = $arrmanfaat[$cc_manfaat_no];
					}
					
				if (empty($cc_isi))
					{
					$cc_isi = "Luar Biasa. Sangat Bermanfaat...";
					}
				
				
				
				echo '<p>
				Silahkan isi Testimoni Kepuasan Produk dan Layanan Kami : 
				</p>
				
				<input name="kdku'.$r_no.'" id="kdku'.$r_no.'" type="hidden" value="'.$r_itemkd.'">
				
				<p>
				<textarea cols="50" name="f_isi'.$r_no.'" id="f_isi'.$r_no.'" rows="5" class="btn btn-info">'.$cc_isi.'</textarea>
				</p>
			
				<p>
				Kualitas : 
				<select name="ikualitas'.$r_no.'" id="ikualitas'.$r_no.'" class="btn btn-info">
					<option value="'.$cc_kualitas_no.'" selected>'.$cc_kualitas.'</option>
					<option value="1">Biasa</option>
					<option value="2">Lumayan</option>
					<option value="3">Baik</option>
					<option value="4">Bagus</option>
					<option value="5">Luar Biasa</option>
				</select>
				</p>
				
				<p>
				Manfaat :
				<select name="imanfaat'.$r_no.'" id="imanfaat'.$r_no.'" class="btn btn-info">
					<option value="'.$cc_manfaat_no.'" selected>'.$cc_manfaat.'</option>
					<option value="1">Tidak Berguna</option>
					<option value="2">Kadang Saja</option>
					<option value="3">Biasa Saja</option>
					<option value="4">Lumayan Membantu</option>
					<option value="5">Sangat Bermanfaat</option>
				</select>
	
				
				</p>';
				}
	

			
			echo '</td>
			<td>'.$r_kondisi.'</td>
			<td width="100" >'.$r_berat.' gram</td>
			<td width="150" align="right">'.xduit2($r_harga).'</td>
			<td width="50">'.$r_qty.'</td>
			<td width="150" align="right">'.xduit2($r_subtotal).'</td>
	        </tr>';
			}
		while ($row = mysqli_fetch_assoc($q));

		echo '</tbody>
		  </table>
		  </div>';
		  
		  
		
	//jika sudah dikirim
	if (($ku_tgl_dikirim <> '0000-00-00') AND ($ku_tgl_diterima == '0000-00-00'))
		{
		$notakd = nosql($_REQUEST['notakd']);
		
		echo '<input name="total" type="hidden" value="'.$total.'">
		<input name="notakd" type="hidden" value="'.$notakd.'">
		<input name="btnKRMx2" id="btnKRMx2" type="submit" class="btn btn-danger" value="PAKET SUDAH DITERIMA. TERIMA KASIH. >>">';
		}
	
	
	
	
	
	
	
	  
	//jika udah selesai, boleh nulis testimoni
	if ($ku_tgl_diterima <> '0000-00-00')
		{
		echo '<a name="simpanya"></a>
		  <input name="total" type="hidden" value="'.$total.'">
		<input name="notakd" type="hidden" value="'.$notakd.'">
		<input name="btnKRMx" id="btnKRMx" type="submit" class="btn btn-danger" value="SIMPAN >>">';
		}

		
	}
	
else
	{
	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"AND konfirmasi = 'true' ".
						"ORDER BY postdate DESC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);
	
	if (!empty($total))
		{
		?>
	
	
	  
	  <script>
	  	$(document).ready(function() {
	    $('#table-responsive').dataTable( {
	        "scrollX": true
	    } );
	} );
	  </script>
	  
	<?php
	//total
	$q1 = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"ORDER BY postdate DESC");
	$row1 = mysqli_fetch_assoc($q1);
	$jml_total = mysqli_num_rows($q1);
		
		
		
	//belum konfirmasi
	$q1 = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"AND konfirmasi = 'false' ".
						"ORDER BY postdate DESC");
	$row1 = mysqli_fetch_assoc($q1);
	$jml_belum_konfirmasi = mysqli_num_rows($q1);
		
		
		
		
	
	//sudah konfirmasi
	$q1 = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"AND konfirmasi = 'true' ".
						"ORDER BY postdate DESC");
	$row1 = mysqli_fetch_assoc($q1);
	$jml_konfirmasi = mysqli_num_rows($q1);
	
	
	//telah dikirim
	$q1 = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"AND konfirmasi = 'true' ".
						"AND tgl_kirim <> '0000-00-00' ".
						"AND tgl_diterima = '0000-00-00' ".
						"ORDER BY postdate DESC");
	$row1 = mysqli_fetch_assoc($q1);
	$jml_dikirim = mysqli_num_rows($q1);
	
	
	//diterima
	$q1 = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"AND konfirmasi = 'true' ".
						"AND tgl_kirim <> '0000-00-00' ".
						"AND tgl_diterima <> '0000-00-00' ".
						"ORDER BY postdate DESC");
	$row1 = mysqli_fetch_assoc($q1);
	$jml_diterima = mysqli_num_rows($q1);

		
	
	echo '[Transaksi : <b>'.$jml_total.'</b>]. 
	[Belum Konfirmasi : <b>'.$jml_belum_konfirmasi.'</b>]. 
	[Konfirmasi : <b>'.$jml_konfirmasi.'</b>]. 
	[Dikirim : <b>'.$jml_dikirim.'</b>].  
	[Diterima : <b>'.$jml_diterima.'</b>]. 
	
	
	
	<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
			<tr bgcolor="'.$warnaheader.'">
	      <th>TGL TRANSAKSI</th>
	      <th>NOTA</th>
	      <th>JML JENIS ITEM</th>
	      <th>QTY ITEM</th>
	      <th>BERAT</th>
	      <th>TOTAL</th>
	      <th>KONFIRMASI</th>
	      <th>KIRIM</th>
	      <th>DITERIMA</th>
	      <th>#</th>
	    </tr>
		    </thead>
		    <tbody>';
	
	
	
	do 
		{
		$r_kd = nosql($row['kd']);
		$r_tgl_booking = balikin($row['tgl_booking']);
		$r_nota_kode = balikin($row['nota_kode']);
		$r_jml_jenis = nosql($row['barang_jml_jenis']);
		$r_qty = nosql($row['barang_qty']);
		$r_berat = nosql($row['barang_berat']);
		$r_total = nosql($row['total']);
		$r_konfirmasi = balikin($row['tgl_bayar']);
		$r_kirim = balikin($row['tgl_kirim']);
		$r_diterima = balikin($row['tgl_diterima']);
			
			
			
		if ($r_diterima <> '0000-00-00')
			{
			//update speed			
			$date1=date_create($r_konfirmasi);
			$date2=date_create($r_diterima);
			$diff=date_diff($date1,$date2);
			$jml_speed = $diff->format("%a");
	
			mysqli_query($koneksi, "UPDATE member_order SET jml_speed_kirim = '$jml_speed' ".
							"WHERE kd = '$r_kd'");
			}
		
		
		
		
		
		
		


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
	
	
	
		if ($r_konfirmasi == "0000-00-00")
			{
			$r_konfirmasi = "";
			}


		if ($r_kirim == "0000-00-00")
			{
			$r_kirim = "";
			}
			
			
		if ($r_diterima == "0000-00-00")
			{
			$r_diterima = "";
			}
			
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$r_tgl_booking.'</td>
			<td>'.$r_nota_kode.'</td>
			<td>'.$r_jml_jenis.'</td>
			<td>'.$r_qty.'</td>
			<td>'.$r_berat.' Gram</td>
			<td>'.xduit2($r_total).'</td>
			<td>'.$r_konfirmasi.'</td>
			<td>'.$r_kirim.'</td>
			<td>'.$r_diterima.'</td>
			<td>
			<p>
			[<a href="'.$filenya.'?s=detail&notakd='.$r_kd.'">DETAIL TRANSAKSI</a>]
			</p>
			</td>
	        </tr>';
			}
		while ($row = mysqli_fetch_assoc($q));
	
		echo '</tbody>
		  </table>
		  </div>';
		}
		
	else
		{
		echo "<font color=red>
		<h3>BELUM ADA DATA TRANSAKSI</h3>
		</font>";
		}		
	
	}

	
echo '</form>';




//isi
$isi = ob_get_contents();
ob_end_clean();










require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>