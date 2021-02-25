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
$tpl = LoadTpl("template/$temaku/cp_member_profil.php");



nocache;

//nilai
$filenya = "member_profil.php";
$filenya_ke = $sumber;
$judul = "Profil Diri";
$judulku = $judul;












//isi *START
ob_start();


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_member_menu.php");

//isi
$member_menu = ob_get_contents();
ob_end_clean();






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
	
	



//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$e_nama = cegah($_POST['e_nama']);
	$e_telp = cegah($_POST['e_telp']);
	$e_email = cegah($_POST['e_email']);
	$e_web = cegah($_POST['e_web']);
		
	$e_tmp_lahir = cegah($_POST['e_tmp_lahir']);
	$e_tgl_lahir = cegah($_POST['e_tgl_lahir']);
	
	$e_tgl_lahir1 = balikin($e_tgl_lahir);
	$tglku = explode("/", $e_tgl_lahir1);
	$e_tgl = trim($tglku[0]);
	$e_bulan = trim($tglku[1]);
	$e_tahun = trim($tglku[2]);
	$e_tgl_lahir = "$e_tahun:$e_bulan:$e_tgl";
	

	$e_kelamin = cegah($_POST['e_kelamin']);
	$provinsi1 = nosql($_POST['provinsi']);
	$kabupaten1 = nosql($_POST['kabupaten']);
	$kecamatan1 = nosql($_POST['kecamatan']);
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM provinsi ".
						"WHERE id_prov = '$provinsi1'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	
	//jika ada
	if (!empty($tku))
		{
		$provinsi = cegah($rku['nama']);
		}
	else
		{
		$provinsi = $provinsi1;
		}

	
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
						"WHERE id_kab = '$kabupaten1'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	
	//jika ada
	if (!empty($tku))
		{
		$kabupaten = cegah($rku['nama']);
		}
	else
		{
		$kabupaten = $kabupaten1;
		}
	
	
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
						"WHERE id_kec = '$kecamatan1'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	
	//jika ada
	if (!empty($tku))
		{
		$kecamatan = cegah($rku['nama']);
		}
	else
		{
		$kecamatan = $kecamatan1;
		}

	
	
	
	$e_kelurahan = cegah($_POST['e_kelurahan']);
	$e_alamat = cegah($_POST['e_alamat']);
	$e_kodepos = cegah($_POST['e_kodepos']);
	
	//empty
	if ((empty($e_telp)) OR (empty($provinsi)) OR (empty($kabupaten)) OR (empty($kecamatan)) OR (empty($e_alamat)))
		{
		//re-direct
		$pesan = "INPUT TIDAK LENGKAP";
		pekem($pesan, $filenya);
		exit();	
		} 
	else
		{
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
		mysqli_query($koneksi, "UPDATE m_member SET nama = '$e_nama', ".
						"tmp_lahir = '$e_tmp_lahir', ".
						"tgl_lahir = '$e_tgl_lahir', ".
						"kelamin = '$e_kelamin', ".
						"telp = '$e_telp', ".
						"web = '$e_web', ".
						"postdate = '$today', ".
						"propinsi = '$provinsi', ".
						"kabupaten = '$kabupaten', ".
						"kecamatan = '$kecamatan', ".
						"kelurahan = '$e_kelurahan', ".
						"alamat = '$e_alamat', ".
						"kodepos = '$e_kodepos', ".
						"latx = '$latitude', ".
						"laty = '$longitude' ".
						"WHERE kd = '$kd6_session'");


		//re-direct
		xloc($filenya);
		exit();
		}
	
	}
	










//ganti password
//simpan
if ($_POST['btnSMP2'])
	{
	//ambil nilai
	$passlama = md5(nosql($_POST["passlama"]));
	$passbaru = md5(nosql($_POST["passbaru"]));
	$passbaru2 = md5(nosql($_POST["passbaru2"]));

	//cek
	//nek null
	if ((empty($passlama)) OR (empty($passbaru)) OR (empty($passbaru2)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}

	//nek pass baru gak sama
	else if ($passbaru != $passbaru2)
		{
		//re-direct
		$pesan = "Password Baru Tidak Sama. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM m_member ".
							"WHERE kd = '$kd6_session' ".
							"AND usernamex = '$username6_session' ".
							"AND passwordx = '$passlama'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek
		if ($total != 0)
			{
			//perintah SQL
			mysqli_query($koneksi, "UPDATE m_member SET passwordx = '$passbaru' ".
							"WHERE kd = '$kd6_session' ".
							"AND usernamex = '$username6_session'");


			//auto-kembali
			$pesan = "PASSWORD BERHASIL DIGANTI.";
			pekem($pesan, $filenya);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "PASSWORD LAMA TIDAK COCOK. HARAP DIULANGI...!!!";
			pekem($pesan, $filenya);
			exit();
			}
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









//isi *START
ob_start();


require("template/js/number.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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







    $('#e_tgl_lahir').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
    })
    
    
		
});

</script>
	
	
	
<style>


/* Default mode */
.tabbable-line > .nav-tabs {
  border: none;
  margin: 0px;
}
.tabbable-line > .nav-tabs > li {
  margin-right: 2px;
}
.tabbable-line > .nav-tabs > li > a {
  border: 0;
  margin-right: 0;
  color: #737373;
}
.tabbable-line > .nav-tabs > li > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
  border-bottom: 4px solid #fbcdcf;
}
.tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
  border: 0;
  background: none !important;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
  margin-top: 0px;
}
.tabbable-line > .nav-tabs > li.active {
  border-bottom: 4px solid #f3565d;
  position: relative;
}
.tabbable-line > .nav-tabs > li.active > a {
  border: 0;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.active > a > i {
  color: #404040;
}
.tabbable-line > .tab-content {
  margin-top: -3px;
  background-color: #fff;
  border: 0;
  border-top: 1px solid #eee;
  padding: 15px 0;
}
.portlet .tabbable-line > .tab-content {
  padding-bottom: 0;
}

/* Below tabs mode */

.tabbable-line.tabs-below > .nav-tabs > li {
  border-top: 4px solid transparent;
}
.tabbable-line.tabs-below > .nav-tabs > li > a {
  margin-top: 0;
}
.tabbable-line.tabs-below > .nav-tabs > li:hover {
  border-bottom: 0;
  border-top: 4px solid #fbcdcf;
}
.tabbable-line.tabs-below > .nav-tabs > li.active {
  margin-bottom: -2px;
  border-bottom: 0;
  border-top: 4px solid #f3565d;
}
.tabbable-line.tabs-below > .tab-content {
  margin-top: -10px;
  border-top: 0;
  border-bottom: 1px solid #eee;
  padding-bottom: 15px;
}




</style>



<?php
echo '<div class="container">
    <div class="row">
		<div class="col-md-8">

			<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_default_1" data-toggle="tab">
							PROFIL DIRI </a>
						</li>
						<li>
							<a href="#tab_default_2" data-toggle="tab">
							GANTI PASSWORD </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_default_1">';
							

							echo '<table width="100%" border="0" cellpadding="5" cellspacing="5">
							<tr valign="top">
							<td width="400">

							<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">';

							
							
							//detail
							$qku = mysqli_query($koneksi, "SELECT * FROM m_member ".
													"WHERE kd = '$kd6_session'");
							$rku = mysqli_fetch_assoc($qku);
							$ku_nama = balikin($rku['nama']);
							$ku_tagline = balikin($rku['tagline']);
							$ku_telp = balikin($rku['telp']);
							$ku_email = balikin($rku['email']);
							$ku_web = balikin($rku['web']);
							$ku_kelamin = nosql($rku['kelamin']);
							$ku_tmp_lahir = balikin($rku['tmp_lahir']);
							$ku_tgl_lahir = $rku['tgl_lahir'];
							
							//pecah
							$tglku = explode("-", $ku_tgl_lahir);
							$tglku_tahun = trim($tglku[0]);
							$tglku_bulan = trim($tglku[1]);
							$tglku_tanggal = trim($tglku[2]);
							$ku_tgl_lahir = "$tglku_tanggal/$tglku_bulan/$tglku_tahun";
							
							
							
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
							Nama : 
							<br>
							<input name="e_nama" type="text" size="15" value="'.$ku_nama.'" class="btn btn-info">
							</p>
							
							
							<p>
							Tempat, Tanggal Lahir : 
							<br>
							<input name="e_tmp_lahir" id="e_tmp_lahir" type="text" size="20" value="'.$ku_tmp_lahir.'" class="btn btn-info">, 
								
								
							<input name="e_tgl_lahir" id="e_tgl_lahir" type="text" size="10" value="'.$ku_tgl_lahir.'" class="btn btn-info">
							</p>
							
							
							
							
							
							<p>
							Jenis Kelamin : 
							<br>
								<select name="e_kelamin" id="e_kelamin" class="btn btn-info">
									<option value="'.$ku_kelamin.'" selected>'.$ku_kelamin.'</option>
									<option value="L">Laki - Laki</option>
									<option value="P">Perempuan</option>
								</select>
							
							</p>
							
							
							
							
							<p>
							Telepon : 
							<br>
							<input name="e_telp" type="text" size="15" value="'.$ku_telp.'" class="btn btn-info">
							</p>
							
							
							<p>
							E-Mail / Username : 
							<br>
							<input name="e_email" type="text" size="20" value="'.$ku_email.'" class="btn btn-default" readonly>
							</p>
							
							<p>
							Web : 
							<br>
							<input name="e_web" type="text" size="30" value="'.$ku_web.'" class="btn btn-info">
							</p>
							
							
							</td>
							
							
							
							<td>
							
							
							<p>
							Propinsi : 
							<br>';
							//Dapatkan semua 
							$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
													"ORDER BY nama ASC");
							$row = mysqli_fetch_assoc($query);
							
							
							echo '<select name="provinsi" id="provinsi" class="btn btn-info">
							<option value="'.$ku_propinsix.'" selected>'.$ku_propinsix.'</option>';
							
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
							<select name="kabupaten" id="kabupaten" class="btn btn-info">
							<option value="'.$ku_kabupatenx.'" selected>'.$ku_kabupatenx.'</option>
							</select>
							</p>
							
							<p>
							Kecamatan :
							<br>
							<select name="kecamatan" id="kecamatan" class="btn btn-info">
							<option value="'.$ku_kecamatanx.'" selected>'.$ku_kecamatanx.'</option>
							</select>
							</p>
							
							
							
							<p>
							Kelurahan : 
							<br>
							<input name="e_kelurahan" type="text" size="15" value="'.$ku_kelurahan.'" class="btn btn-info">
							</p>
							
							
							
							<p>
							Alamat : 
							<br>
							<input name="e_alamat" type="text" size="30" value="'.$ku_alamat.'" class="btn btn-info">
							</p>
							
							
							
							
							<p>
							Kode Pos : 
							<br>
							<input name="e_kodepos" type="text" size="5" value="'.$ku_kodepos.'" onKeyPress="return numbersonly(this, event)" class="btn btn-info">
							</p>
							
							
							
							<hr>
							
							<p>
							<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
							</p>
							
							
							</td>
							</tr>
							</table>
							
							</form>';
							
							
							
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
							echo '</td>
							</tr>
							</table>
							





						</div>
						
						
						
						
						
						<div class="tab-pane" id="tab_default_2">

							<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx2">
							

								<p>
								Password Lama : 
								<br>
								<input name="passlama" type="password" size="15" class="btn btn-info">
								</p>
								
								<p>
								Password Baru : 
								<br>
								<input name="passbaru" type="password" size="15" class="btn btn-info">
								</p>
								
								<p>
								RE-Password Baru : 
								<br>
								<input name="passbaru2" type="password" size="15" class="btn btn-info">
								</p>
								
								<p>
								<input name="btnSMP2" type="submit" value="SIMPAN" class="btn btn-danger">
								<input name="btnBTL2" type="reset" value="BATAL" class="btn btn-primary">
								</p>
																



							</form>


						</div>




					</div>
				</div>
			</div>

		</div>
	</div>
</div>';


//isi
$isi = ob_get_contents();
ob_end_clean();












require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
