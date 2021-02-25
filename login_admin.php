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
$tpl = LoadTpl("template/$temaku/login_admin.php");



nocache;

//nilai
$filenya = "login_admin.php";
$filenya_ke = $sumber;
$judul = "LOGIN ADMIN";
$judulku = $judul;







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}




//ok
if ($_POST['btnOK'])
	{
	//ambil nilai
	$username = nosql($_POST["usernamex"]);
	$password = md5(nosql($_POST["passwordx"]));

	//cek null
	if ((empty($username)) OR (empty($password)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM adminx ".
							"WHERE usernamex = '$username' ".
							"AND passwordx = '$password'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek login
		if ($total != 0)
			{
			session_start();

			//bikin session
			$_SESSION['kd16_session'] = nosql($row['kd']);
			$_SESSION['username16_session'] = $username;
			$_SESSION['pass16_session'] = $password;
			$_SESSION['adm_session'] = "Administrator";
			$_SESSION['hajirobe_session'] = $hajirobe;


			//re-direct
			$ke = "adm/index.php";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			pekem($pesan, $filenya);
			exit();
			}
		//...................................................................................................

		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////












//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5">
<tr>
<td valign="top">


<form action="'.$filenya.'" method="post" name="formx">

<p>
<img src="'.$sumber.'/template/img/support.png" width="24" height="24" border="0">
</p>



<p>
Username :
<br>
<input name="usernamex" type="text" size="15" class="btn btn-info">
</p>

<p>
Password :
<br>
<input name="passwordx" type="password" size="15" class="btn btn-info">
</p>


<p>
<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;" class="btn btn-danger">
</p>

</form>



</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>





<?php
//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
