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
$filenya = "pembayaran.php";
$judul = "[SETTING]. Cara Pembayaran";
$judulku = "$judul";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$e_isi = cegah2($_POST["editor1"]);



	//nek null
	if (empty($e_isi))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}

	else
		{
		//perintah SQL
		mysqli_query($koneksi, "UPDATE m_pembayaran SET isi = '$e_isi', ".
						"postdate = '$today'");


		//auto-kembali
		xloc($filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();



echo '<div class="row">



<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">';


     	
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">

<div class="col-md-10">';


//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_pembayaran");
$rku = mysqli_fetch_assoc($qku);
$ku_judul = balikin($rku['judul']);
$ku_isi = balikin($rku['isi']);




echo '<p>


<textarea id="editor1" name="editor1" rows="10" cols="100%">
'.$ku_isi.'
</textarea>
        
</p>

<p>
<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
</p>
         
					
</div>

</form>



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