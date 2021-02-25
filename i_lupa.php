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
	




$filenyax = "i_lupa.php";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$e_nama = cegah($_GET['e_nama']);
	$e_email = cegah($_GET['e_email']);
		
	$e_tmp_lahir = cegah($_GET['e_tmp_lahir']);
	$e_tgl_lahir = cegah($_GET['e_tgl_lahir']);
	
	$e_tgl_lahir1 = balikin($e_tgl_lahir);
	$tglku = explode("/", $e_tgl_lahir1);
	$e_tgl = trim($tglku[0]);
	$e_bulan = trim($tglku[1]);
	$e_tahun = trim($tglku[2]);
	$e_tgl_lahir = "$e_tahun-$e_bulan-$e_tgl";
	

	$e_kelamin = cegah($_GET['e_kelamin']);


	$e_user = balikin($e_email);

	
	//empty
	if ((empty($e_nama)) OR (empty($e_email)) OR (empty($e_tmp_lahir)))
		{
		echo '<h3>INPUT TIDAK LENGKAP</h3>';	
		} 
	else
		{
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM m_member ".
							"WHERE nama = '$e_nama' ".
							"AND usernamex = '$e_email' ".
							"AND tmp_lahir = '$e_tmp_lahir' ".
							"AND tgl_lahir = '$e_tgl_lahir' ".
							"AND kelamin = '$e_kelamin'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);
		$kd = nosql($row['kd']);

		//ada 
		if (!empty($total))
			{
			//set database
			$e_pass = substr($x,0,5);
			$e_passx = md5($e_pass);
			
			
			//update database
			mysqli_query($koneksi, "UPDATE m_member SET passwordx = '$e_passx' ".
							"WHERE kd = '$kd'");
			

			
			echo "<h3>PASSWORD BERHASIL DIPULIHKAN...</h3>
			
			<p>
			Silahkan Login
			<br> 
			Username : <b>$e_user</b>
			</p>
			
			<p>
			Password : <b>$e_pass</b> 
			</p>";
			
			
			exit();
			}
		else
			{
			//re-direct
			echo "Data Tidak Cocok... HARAP DIULANGI...!!!";
			
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
					url: "<?php echo $filenyax;?>?aksi=simpan",
					type:$(this).attr("method"),
					data:$(this).serialize(),
					success:function(data){					
						$("#ihasil").html(data);
						}
					});
				return false;
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
	E-Mail / Username :
	<br> 
	<input name="e_email" id="e_email" type="text" size="20" value="'.$e_email.'" class="btn btn-info">
	</p>




			
	<p>
	<input name="btnKRM" id="btnKRM" type="submit" class="btn btn-danger" value="PULIHKAN >>">
	</p>

	</td>
	

	</tr>
	</table>
	
	</form>';
	

	exit();
	}


exit();
?>