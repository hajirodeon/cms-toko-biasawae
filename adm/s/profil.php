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
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/admin.html");


nocache;

//nilai
$filenya = "profil.php";
$judul = "[SETTING]. Profil Toko";
$judulku = "$judul";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$e_nama = cegah($_POST["e_nama"]);
	$e_tagline = cegah($_POST["e_tagline"]);
	$e_telp = cegah($_POST["e_telp"]);
	$e_email = cegah($_POST["e_email"]);
	$e_web = cegah($_POST["e_web"]);
	$e_provinsi = cegah($_POST["provinsi"]);
	$e_kabupaten = cegah($_POST["kabupaten"]);
	$e_kecamatan = cegah($_POST["kecamatan"]);
	$e_kelurahan = cegah($_POST["e_kelurahan"]);
	$e_alamat = cegah($_POST["e_alamat"]);
	$e_kodepos = cegah($_POST["e_kodepos"]);
	

	//cek
	//nek null
	if ((empty($e_nama)) OR (empty($e_tagline)) OR (empty($e_telp)) OR (empty($e_email)) OR (empty($e_web)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}

	else
		{
		//perintah SQL
		mysqli_query($koneksi, "UPDATE m_profil SET nama = '$e_nama', ".
						"tagline = '$e_tagline', ".
						"telp = '$e_telp', ".
						"email = '$e_email', ".
						"web = '$e_web', ".
						"propinsi = '$e_provinsi', ".
						"kabupaten = '$e_kabupaten', ".
						"kecamatan = '$e_kecamatan', ".
						"kelurahan = '$e_kelurahan', ".
						"alamat = '$e_alamat', ".
						"kodepos = '$e_kodepos'");


		//auto-kembali
		xloc($filenya);
		exit();
		}
	}
	
	
	
	
	
	
	
	
	


//simpan logo + header
if ($_POST['btnSMP2'])
	{
	//ambil nilai
	$filex_namex = strtolower($_FILES['filex_foto']['name']);
	$filex_namex2 = strtolower($_FILES['filex_foto2']['name']);


	//nek null
	if ((empty($filex_namex)) OR (empty($filex_namex2)))
		{
		//re-direct
		$pesan = "Input Kosong. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);
	
		if ($ext_filex == ".jpg")
			{
			//mengkopi file
			$namabaru1 = "logo.jpg";
			$foldernya = "../../filebox/toko";
			chmod($foldernya,0777);
			copy($_FILES['filex_foto']['tmp_name'],"../../filebox/toko/$namabaru1");

			
			//mengkopi file
			$namabaru2 = "header.jpg";
			$foldernya = "../../filebox/toko";
			chmod($foldernya,0777);
			copy($_FILES['filex_foto2']['tmp_name'],"../../filebox/toko/$namabaru2");
			
			//perintah SQL
			mysqli_query($koneksi, "UPDATE m_profil SET filex_logo = '$namabaru1', ".
							"filex_header = '$namabaru2'");


			//re-direct
			xloc($filenya);
			exit();
			}

		else
			{
			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}

		}

	}













//simpan
if ($_POST['btnSMP3'])
	{
	//ambil nilai
	$e_title = cegah($_POST["e_title"]);
	$e_keyword = cegah($_POST["e_keyword"]);
	$e_description = cegah($_POST["e_description"]);


	//cek
	//nek null
	if ((empty($e_title)) OR (empty($e_keyword)) OR (empty($e_description)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}

	else
		{
		//perintah SQL
		mysqli_query($koneksi, "UPDATE m_profil SET judul = '$e_title', ".
						"keyword = '$e_keyword', ".
						"deskripsi = '$e_description'");


		//auto-kembali
		xloc($filenya);
		exit();
		}
	}
	

	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();


?>



<script language='javascript'>
//membuat document jquery
$(document).ready(function(){
	
	$('#provinsi').change(function() { 
	     var provinsi = $(this).val(); 
	     $.ajax({
	            type: 'POST', 
	          url: 'i_alamat.php', 
	         data: 'id_provinsi=' + provinsi, 
	         success: function(response) { 
	              $('#kabupaten').html(response);
	            }
	       });
	    });
	 
	
	
	
	$('#kabupaten').change(function() { 
	     var kabupaten = $(this).val(); 
	     $.ajax({
	            type: 'POST', 
	          url: 'i_alamat.php', 
	         data: 'id_kabupaten=' + kabupaten, 
	         success: function(response) { 
	              $('#kecamatan').html(response);
	            }
	       });
	    });



		
});

</script>
	
<?php


echo '<div class="row">



<div class="col-md-8">
<div class="box">

<div class="box-body">
<div class="row">';


     	
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">

<div class="col-md-5">';


//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_profil");
$rku = mysqli_fetch_assoc($qku);
$ku_nama = balikin($rku['nama']);
$ku_tagline = balikin($rku['tagline']);
$ku_telp = balikin($rku['telp']);
$ku_email = balikin($rku['email']);
$ku_web = balikin($rku['web']);
$ku_propinsix = balikin($rku['propinsi']);
$ku_kabupatenx = balikin($rku['kabupaten']);
$ku_kecamatanx = balikin($rku['kecamatan']);
$ku_kelurahan = balikin($rku['kelurahan']);


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




$ku_alamat = balikin($rku['alamat']);
$ku_kodepos = balikin($rku['kodepos']);


$ku_logo = balikin($rku['filex_logo']);
$ku_header = balikin($rku['filex_header']);

$ku_judul = balikin($rku['judul']);
$ku_keyword = balikin($rku['keyword']);
$ku_deskripsi = balikin($rku['deskripsi']);


echo '<p>
Nama Toko : 
<br>
<input name="e_nama" type="text" size="15" value="'.$ku_nama.'" class="btn btn-warning">
</p>

<p>
TagLine / Semboyan : 
<br>
<input name="e_tagline" type="text" size="30" value="'.$ku_tagline.'" class="btn btn-warning">
</p>


<p>
Telepon : 
<br>
<input name="e_telp" type="text" size="15" value="'.$ku_telp.'" class="btn btn-warning">
</p>


<p>
E-Mail : 
<br>
<input name="e_email" type="text" size="20" value="'.$ku_email.'" class="btn btn-warning">
</p>

<p>
Web : 
<br>
<input name="e_web" type="text" size="30" value="'.$ku_web.'" class="btn btn-warning">
</p>





</div>



<div class="col-md-4">


<p>
Propinsi : 
<br>';
//Dapatkan semua 
$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
						"ORDER BY nama ASC");
$row = mysqli_fetch_assoc($query);


echo '<select name="provinsi" id="provinsi" class="btn btn-warning">
<option value="'.$ku_propinsix.'" selected>'.$ku_propinsi.'</option>';

do
	{
	$r_idprov = nosql($row['id_prov']);
	$r_nama = balikin($row['nama']);
	 
    echo '<option value="'.$r_idprov.'">'.$r_nama.'</option>';
	}
while ($row = mysqli_fetch_assoc($query));

echo '</select>
</p>


<p>
Kabupaten / Kota :
<br>
<select name="kabupaten" id="kabupaten" class="btn btn-warning">
<option value="'.$ku_kabupatenx.'" selected>'.$ku_kabupaten.'</option>
</select>
</p>

<p>
Kecamatan :
<br>
<select name="kecamatan" id="kecamatan" class="btn btn-warning">
<option value="'.$ku_kecamatanx.'" selected>'.$ku_kecamatan.'</option>
</select>
</p>



<p>
Kelurahan : 
<br>
<input name="e_kelurahan" type="text" size="15" value="'.$ku_kelurahan.'" class="btn btn-warning">
</p>



<p>
Alamat : 
<br>
<input name="e_alamat" type="text" size="30" value="'.$ku_alamat.'" class="btn btn-warning">
</p>




<p>
Kode Pos : 
<br>
<input name="e_kodepos" type="text" size="5" value="'.$ku_kodepos.'" class="btn btn-warning">
</p>

</div>


</div>


<hr>

<p>
<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
</p>
</form>




</div>
</div>










<div class="box">

<div class="box-body">
<div class="row">
          	
<div class="col-md-12">';



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

<?php
echo '


</div>
</div>
</div>
</div>
</div>














<div class="col-md-4">
<div class="box">

<div class="box-body">
<div class="row">
          	
<div class="col-md-8">


<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx2">
<p>
Image Logo : 
<br>';


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
<br>
<br>
<input name="filex_foto" type="file" size="15" class="btn btn-warning">
</p>


<hr>



<p>
Image Header : 
<br>';


//nek null foto
if (empty($ku_header))
	{
	$nil_foto2 = "$sumber/template/img/bg-black.png";
	}
else
	{
	$nil_foto2 = "$sumber/filebox/toko/$ku_header";
	}

echo '<img src="'.$nil_foto2.'" width="300" height="50" border="5">
<br>
<br>
<input name="filex_foto2" type="file" size="15" class="btn btn-warning">
</p>





<p>
<input name="btnSMP2" type="submit" value="UPLOAD" class="btn btn-danger">
</p>
</form>





</div>
</div>
</div>
</div>



<div class="box">

<div class="box-body">
<div class="row">
          	
<div class="col-md-8">


<form action="'.$filenya.'" method="post" name="formx3">
<p>
Title : 
<br>
<input name="e_title" type="text" size="30" value="'.$ku_judul.'" class="btn btn-warning">
</p>


<p>
Keyword : 
<br>
<input name="e_keyword" type="text" size="30" value="'.$ku_keyword.'" class="btn btn-warning">
</p>


<p>
Description : 
<br>
<input name="e_description" type="text" size="30" value="'.$ku_deskripsi.'" class="btn btn-warning">
</p>


<p>
<input name="btnSMP3" type="submit" value="SIMPAN" class="btn btn-danger">
</p>
</form>





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

//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>