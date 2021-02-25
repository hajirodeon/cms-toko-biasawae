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

require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
	




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$sesikd = cegah($_SESSION['sesikd']);
	$notakd = cegah($_SESSION['notakd']);
	$e_nama = cegah($_GET['e_nama']);
	$e_telp = cegah($_GET['e_telp']);
	$f_kelurahan = cegah($_GET['f_kelurahan']);
	$f_alamat = cegah($_GET['f_alamat']);
	$f_kodepos = cegah($_GET['f_kodepos']);
	$f_catatan = cegah($_GET['f_catatan']);





	//ketahui 
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE member_kd = '$sesikd' ".
							"AND kd = '$notakd'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	$kecamatan = balikin($rku['penerima_kecamatan']);
	$kabupaten = balikin($rku['penerima_kabupaten']);
	$propinsi = balikin($rku['penerima_propinsi']);

	

	$e_alamat = "$f_alamat, $f_kelurahan, $kecamatan, $kabupaten, $propinsi";




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








	//update ...
	mysqli_query($koneksi, "UPDATE member_order SET penerima_nama = '$e_nama', ".
					"penerima_telp = '$e_telp', ".
					"penerima_kelurahan = '$f_kelurahan', ".
					"penerima_alamat = '$f_alamat', ".
					"penerima_kodepos = '$f_kodepos', ".
					"catatan = '$f_catatan', ".
					"latx = '$latitude', ".
					"laty = '$longitude', ".
					"tgl_booking = '$today', ". 
					"postdate = '$today' ".
					"WHERE kd = '$notakd'");

					
	?>
	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
			window.location.href = "member_selesai.php?notakd=<?php echo $notakd;?>&s=selesai";
	});
	
	</script>


	<?php
					

	exit();
	}










	
exit();
?>