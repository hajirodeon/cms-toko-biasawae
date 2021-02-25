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
$filenya = "jasa_kirim.php";
$judul = "[SETTING]. Jasa Kirim";
$judulku = "$judul";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	for($ongko=1;$ongko<=$limit;$ongko++)
		{
		$xkd = "kd";
		$xkd1 = "$xkd$ongko";
		$xkdx = nosql($_POST["$xkd1"]);
		
		$xtk = "tk";
		$xtk1 = "$xtk$ongko";
		$xtkx = nosql($_POST["$xtk1"]);



		//sesuaikan
		mysqli_query($koneksi, "UPDATE m_jasa_kirim SET status = '$xtkx', ".
						"postdate = '$today' ".
						"WHERE kd = '$xkdx'");
		}


	//re-direct
	xloc($ke);
	exit();
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



//daftar
$qku = mysqli_query($koneksi, "SELECT * FROM m_jasa_kirim ".
					"ORDER BY round(kode) ASC");
$rku = mysqli_fetch_assoc($qku);




//require
require("../../template/js/swap.js");


?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="table-responsive">          
  <table class="table" border="1">
    <thead>
				
		<tr bgcolor="'.$warnaheader.'">
		<td><strong><font color="'.$warnatext.'">NAMA JASA KIRIM</font></strong></td>
		<td width="10" align="center"><strong><font color="'.$warnatext.'">STATUS</font></strong></td>
		</tr>
		
	    </thead>
	    <tbody>';
		
		do
			{
			$nomer = $nomer + 1;
		
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
		
		
		
			$kd = nosql($rku['kd']);
			$kode = balikin($rku['kode']);
			$nama = balikin($rku['nama']);
			$status = balikin($rku['status']);
			
			if ($status == "true")
				{
				$status_ket = "AKTIF";
				$warna = "orange";
				}
				
			else if ($status == "false")
				{
				$status_ket = "";
				}
		
		
		
		
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onkeyup=\"this.bgColor='$warnaover';\" onkeydown=\"this.bgColor='$warna';\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nama.'</td>
			<td align="center">
			
			<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<select name="tk'.$nomer.'" class="btn btn-info">
			<option value="'.$status.'" selected>'.$status_ket.'</option>
			<option value="true">AKTIF</option>
			<option value="false">Tidak Aktif</option>
			</select>
		
			</td>
		    </tr>';
			}
		while ($rku = mysqli_fetch_assoc($qku));
		

echo '</tbody>
</table>
</div>

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