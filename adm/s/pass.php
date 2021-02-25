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
$filenya = "pass.php";
$judul = "[SETTING]. Ganti Password";
$judulku = "$judul";






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
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
		$q = mysqli_query($koneksi, "SELECT * FROM adminx ".
							"WHERE kd = '$kd16_session' ".
							"AND usernamex = '$username16_session' ".
							"AND passwordx = '$passlama'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek
		if ($total != 0)
			{
			//perintah SQL
			mysqli_query($koneksi, "UPDATE adminx SET passwordx = '$passbaru' ".
							"WHERE kd = '$kd16_session' ".
							"AND usernamex = '$username16_session'");


			//auto-kembali
			$pesan = "PASSWORD BERHASIL DIGANTI.";
			$ke = "../index.php";
			pekem($pesan, $ke);
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




echo '<div class="row">
<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">
          	
<div class="col-md-8">





<form action="'.$filenya.'" method="post" name="formx">
<p>
Password Lama : 
<br>
<input name="passlama" type="password" size="15" class="btn btn-warning">
</p>

<p>
Password Baru : 
<br>
<input name="passbaru" type="password" size="15" class="btn btn-warning">
</p>

<p>
RE-Password Baru : 
<br>
<input name="passbaru2" type="password" size="15" class="btn btn-warning">
</p>

<p>
<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
<input name="btnBTL" type="reset" value="BATAL" class="btn btn-primary">
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