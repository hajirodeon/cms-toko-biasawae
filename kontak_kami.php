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
$tpl = LoadTpl("template/$temaku/cp_kontak_kami.php");



nocache;

//nilai
$filenya = "kontak_kami.php";
$filenya_ke = $sumber;
$judul = "Kontak Kami";
$judulku = $judul;
$ke = "$sumber/$filenya";







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


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();


require("i_statistik.php");

//isi
$istatistik = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_profil");
$rku = mysqli_fetch_assoc($qku);
$ku_nama = balikin($rku['nama']);
$ku_tagline = balikin($rku['tagline']);
$ku_telp = balikin($rku['telp']);
$ku_email = balikin($rku['email']);
$ku_web = balikin($rku['web']);
$ku_alamat = balikin($rku['alamat']);
$ku_kodepos = balikin($rku['kodepos']);
$ku_propinsix = balikin($rku['propinsi']);
$ku_kabupatenx = balikin($rku['kabupaten']);
$ku_kecamatanx = balikin($rku['kecamatan']);
$ku_kelurahan = balikin($rku['kelurahan']);

$ku_logo = balikin($rku['filex_logo']);


//detailkan...	
$qkux = mysqli_query($koneksi, "SELECT * FROM provinsi ".
						"WHERE id_prov = '$ku_propinsix'");
$rkux = mysqli_fetch_assoc($qkux);
$ku_propinsi = balikin($rkux['nama']);


//detailkan...	
$qkux = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
						"WHERE id_kab = '$ku_kabupatenx'");
$rkux = mysqli_fetch_assoc($qkux);
$ku_kabupaten = balikin($rkux['nama']);


//detailkan...	
$qkux = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
						"WHERE id_kec = '$ku_kecamatanx'");
$rkux = mysqli_fetch_assoc($qkux);
$ku_kecamatan = balikin($rkux['nama']);




echo '<table width="100%" border="0" cellpadding="5" cellspacing="5">
<tr valign="top">
<td width="60%">';


//nek null foto
if (empty($ku_logo))
	{
	$nil_foto = "$sumber/template/img/bg-black.png";
	}
else
	{
	$nil_foto = "$sumber/filebox/toko/$ku_logo";
	}

echo '<img src="'.$nil_foto.'" width="100" height="100" border="5">

<h3>
'.$ku_nama.'
</h3>

<p>
<b>Telepon :</b> 
<br>
'.$ku_telp.'
</p>


<p>
<b>E-Mail :</b> 
<br>
'.$ku_email.'
</p>

<p>
<b>Web :</b> 
<br>
'.$ku_web.'
</p>






<p>
<b>Alamat :</b> 
<br>

'.$ku_alamat.'

<br>
'.$ku_kelurahan.', 
'.$ku_kecamatan.', 
'.$ku_kabupaten.'

';
//Dapatkan semua 
$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
						"ORDER BY nama ASC");
$row = mysqli_fetch_assoc($query);


echo ''.$ku_propinsi.'
</p>


<p>
<b>Kode Pos :</b> 
'.$ku_kodepos.'
</p>




</td>


<td>';


//jadikan koordinat
$address = urlencode($ku_alamat);

$url = "https://maps.google.com/maps/api/geocode/json?key=$keyku&address=$address";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
$responseJson = curl_exec($ch);
curl_close($ch);

$response = json_decode($responseJson);

if ($response->status == 'OK') 
	{
	//koordinat dari alamat
    $latitude = $response->results[0]->geometry->location->lat;
    $longitude = $response->results[0]->geometry->location->lng;
	} 
else 
	{
	//kasi default, kota kendal jawa tengah
    $latitude = "-7.0265442";
    $longitude = "110.1879106"; 
	} 
?>



<style>
  #map {
    height: 100%;
  }
</style>

  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&&callback=initMap&key=<?php echo $keyku;?>"></script>





<style>
 #map-canvas {
        width: 100%;
        height: 400px;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script>
var map;
function initialize() {
        var myLatLng = {lat: <?php echo $latitude;?>, lng: <?php echo $longitude;?>};

        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          zoom: 10,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: '<?php echo $ku_nama;?>'
        });

}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <div id="map-canvas"></div>


</td>

</tr>
</table>






<?php
//isi
$isi = ob_get_contents();
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
