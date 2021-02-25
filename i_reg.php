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
	




$filenyax = "i_reg.php";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$e_nama = cegah($_GET['e_nama']);
	$e_telp = cegah($_GET['e_telp']);
	$e_email = cegah($_GET['e_email']);
	$e_email2 = balikin($e_email);
	$e_web = cegah($_GET['e_web']);
		
	$e_tmp_lahir = cegah($_GET['e_tmp_lahir']);
	$e_tgl_lahir = cegah($_GET['e_tgl_lahir']);
	
	$e_tgl_lahir1 = balikin($e_tgl_lahir);
	$tglku = explode("/", $e_tgl_lahir1);
	$e_tgl = trim($tglku[0]);
	$e_bulan = trim($tglku[1]);
	$e_tahun = trim($tglku[2]);
	$e_tgl_lahir = "$e_tahun:$e_bulan:$e_tgl";
	

	$e_kelamin = cegah($_GET['e_kelamin']);
	$provinsi = cegah($_GET['provinsi']);
	$kabupaten = cegah($_GET['kabupaten']);
	$kecamatan = cegah($_GET['kecamatan']);
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM provinsi ".
						"WHERE id_prov = '$provinsi'");
	$rku = mysqli_fetch_assoc($qku);
	$provinsi = cegah($rku['nama']);
	
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
						"WHERE id_kab = '$kabupaten'");
	$rku = mysqli_fetch_assoc($qku);
	$kabupaten = cegah($rku['nama']);
	
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
						"WHERE id_kec = '$kecamatan'");
	$rku = mysqli_fetch_assoc($qku);
	$kecamatan = cegah($rku['nama']);

	
	$e_kelurahan = cegah($_GET['e_kelurahan']);
	$e_alamat = cegah($_GET['e_alamat']);
	$e_kodepos = cegah($_GET['e_kodepos']);
	
	$e_user = $e_email;
	$e_user2 = balikin($e_email);
	$e_pass = substr($x,0,5);
	$e_passx = md5($e_pass);

	
	//empty
	if ((empty($e_nama)) OR (empty($e_email)) OR (empty($e_telp)) OR (empty($e_telp)) OR (empty($provinsi)) OR (empty($kabupaten)) OR (empty($kecamatan)))
		{
		echo '<h3>INPUT TIDAK LENGKAP</h3>';	
		} 
	else
		{
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM m_member ".
							"WHERE usernamex = '$e_user'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek 
		if (empty($total))
			{
			//insert
			mysqli_query($koneksi, "INSERT INTO m_member(kd, usernamex, passwordx, nama, tmp_lahir, tgl_lahir, ".
							"kelamin, telp, email, web, postdate, ".
							"propinsi, kabupaten, kecamatan, kelurahan, alamat, kodepos) VALUES ".
							"('$x', '$e_user', '$e_passx', '$e_nama', '$e_tmp_lahir', '$e_tgl_lahir', ".
							"'$e_kelamin', '$e_telp', '$e_email', '$e_web', '$today', ".
							"'$provinsi', '$kabupaten', '$kecamatan', '$e_kelurahan', '$e_alamat', '$e_kodepos')");
			
			
			echo "<h3>BERHASIL REGISTER</h3>
			
			<p>
			Silahkan Login
			<br> 
			Username : <b>$e_user2</b>
			</p>
			
			<p>
			Password : <b>$e_pass</b> 
			</p>";




//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_profil");
$rku = mysqli_fetch_assoc($qku);
$ku_nama = balikin($rku['nama']);
$ku_email = balikin($rku['email']);
$ku_web = balikin($rku['web']);


$nilkuya2 = "BERHASIL REGISTER


Silahkan Login, $sumber

Username : $e_user2

Password : $e_passx




$ku_web";
			
			
			
ini_set( 'display_errors', 0 );
error_reporting( E_ALL );
$from = $ku_email;
$to = $e_email2;
$subject = "BERHASIL REGISTER di $ku_nama";
$message = $nilkuya2;

$headers = "From:" . $from;
mail($to,$subject,$message, $headers);



			
			
			exit();
			}
		else
			{
			//re-direct
			echo "Alamat E-Mail Sudah Pernah Digunakan... HARAP DIULANGI...!!!";
			
			exit();
			}


		}	

	
	exit();
	}



//jika form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'form'))
	{
	?>

	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){



		$("#btnKRM").on('click', function(){
			
			$("#formx2").submit(function(){
				$.ajax({
					url: "i_reg.php?aksi=simpan",
					type:$(this).attr("method"),
					data:$(this).serialize(),
					success:function(data){					
						$("#ihasil").html(data);
						}
					});
				return false;
			});
		
		
		});	

	
	
				
		
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
		

	<?php
	echo '<form name="formx2" id="formx2">
	
	<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr bgcolor="white" valign="top">
	<td>
	

	<p>
	Nama :
	<br>
	<input name="e_nama" id="e_nama" type="text" size="30" value="'.$e_nama.'" class="btn btn-info">
	</p>

	<p>
	Tempat, Tanggal Lahir : 
	<br>
	<input name="e_tmp_lahir" id="e_tmp_lahir" type="text" size="20" value="'.$e_tmp_lahir.'" class="btn btn-info">, 
	
	
	<input name="e_tgl_lahir" id="e_tgl_lahir" type="text" size="10" value="'.$e_tgl_lahir.'" class="btn btn-info">
	</p>

	<p>
	Jenis Kelamin : 
		<br>
		<select name="e_kelamin" id="e_kelamin" class="btn btn-info">
		<option value="'.$e_kelamin.'" selected>'.$e_kelamin.'</option>
		<option value="L">Laki - Laki</option>
		<option value="P">Perempuan</option>
		</select>
		
	</p>



	<p>
	Telepon :
	<br> 
	<input name="e_telp" id="e_telp" type="text" size="20" value="'.$e_telp.'" class="btn btn-info">
	</p>



	
	<p>
	E-Mail / Username :
	<br> 
	<input name="e_email" id="e_email" type="text" size="20" value="'.$e_email.'" class="btn btn-info">
	</p>


	
	<p>
	Web :
	<br> 
	<input name="e_web" id="e_web" type="text" size="20" value="'.$e_email.'" class="btn btn-info">
	</p>



	</td>
	
	<td width="400">

	<p>
	Propinsi : 
	<br>';			
	//Dapatkan semua 
	$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
							"ORDER BY nama ASC");
	$row = mysqli_fetch_assoc($query);
	?>
	
	<select name="provinsi" id="provinsi" class="btn btn-info">
	<option value="<?php echo $e_propinsi;?>">- <?php echo $e_propinsi;?> -</option>
	        <?php
	            do
	            	{
	            	$r_idprov = nosql($row['id_prov']);
					$r_nama = balikin($row['nama']);
					 
	                echo '<option value="'.$r_idprov.'">'.$r_nama.'</option>';
					}
				while ($row = mysqli_fetch_assoc($query));
	        ?>
	</select>
	</p>
	
	
	<p>
	Kabupaten / Kota :
	<br>
	<select name="kabupaten" id="kabupaten" class="btn btn-info">
	<option value="<?php echo $e_kabupaten;?>">- <?php echo $e_kabupaten;?> -</option>
	</select>
	</p>
		
	<p>
	Kecamatan :
	<br>
	<select name="kecamatan" id="kecamatan" class="btn btn-info">
	<option value="<?php echo $e_kecamatan;?>">- <?php echo $e_kecamatan;?> -</option>
	</select>
	</p>



	<p>
	Kelurahan :
	<br> 
	<input name="e_kelurahan" id="e_kelurahan" type="text" size="20" value="<?php echo $e_kelurahan;?>" class="btn btn-info">
	</p>
	
	<p>
	Alamat : 
	<br>
	<textarea cols="50" name="e_alamat" id="e_alamat" rows="5" class="btn btn-info"><?php echo $e_alamat;?></textarea>
	</p>
	
	<p>
	Kode Pos :
	<br> 
	<input name="e_kodepos" id="e_kodepos" type="text" size="5" value="<?php echo $e_kodepos;?>" onKeyPress="return numbersonly(this, event)" class="btn btn-info">
	</p>



			
	<p>
	<input name="btnKRM" id="btnKRM" type="submit" class="btn btn-danger" value="DAFTAR >>">
	</p>

	</td>
	

	</tr>
	</table>
	
	</form>
	
	<?php
	
	exit();
	}


exit();
?>