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
$tpl = LoadTpl("template/$temaku/cp_member_konfirmasi.php");



nocache;

//nilai
$filenya = "member_konfirmasi.php";
$judul = "Konfirmasi Transfer";
$judulku = $judul;
$sesikd = nosql($_SESSION['kd6_session']);





//proses /////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP2'])
	{
	//ambil nilai
	$notakdx = nosql($_POST['notakdx']);
	$e_tgl1 = balikin($_POST['e_tgl1']);
	$filex_namex = strtolower($_FILES['filex_foto']['name']);

	$pecahku = explode("/", $e_tgl1);
	$pecah1 = trim($pecahku[0]);
	$pecah2 = trim($pecahku[1]);
	$pecah3 = trim($pecahku[2]);
	$e_tgl_bayar = "$pecah3:$pecah2:$pecah1";



	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Kosong. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);
	
		if ($ext_filex == ".jpg")
			{
			//mengkopi file
			$namabaru1 = "$notakdx.jpg";
			$foldernya = "filebox/konfirmasi";
			chmod($foldernya,0777);
			copy($_FILES['filex_foto']['tmp_name'],"filebox/konfirmasi/$namabaru1");

			//perintah SQL
			mysqli_query($koneksi, "UPDATE member_order SET tgl_bayar = '$e_tgl_bayar', ".
							"filex_bayar = '$namabaru1', ".
							"konfirmasi = 'true' ".
							"WHERE member_kd = '$sesikd' ".
							"AND kd = '$notakdx'");


			//re-direct
			xloc($filenya);
			exit();
			}

		else
			{
			//salah
			$pesan = "Bukan File Image .jpg . Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}

		}

	}
//proses /////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();


require("i_headline2.php");

//isi
$iheadline = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_random.php");

//isi
$irandom = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_member_menu.php");



//jika null
if (empty($kd6_session))
	{
	//re-direct
	$ke = "$sumber/login.php";
	xloc($ke);
	exit();	
	}
	

//isi
$member_menu = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();









echo '<form name="formx" id="formx" action="'.$filenya.'" enctype="multipart/form-data" method="post">';

$notakd = nosql($_REQUEST['notakd']);

//jika konfirmasi
if (!empty($notakd))
	{
	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND kd = '$notakd'");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);
	
	if (!empty($total))
		{
		$r_kd = nosql($row['kd']);
		$r_tgl_booking = balikin($row['tgl_booking']);
		$r_nota_kode = balikin($row['nota_kode']);
		$r_jml_jenis = nosql($row['barang_jml_jenis']);
		$r_qty = nosql($row['barang_qty']);
		$r_berat = nosql($row['barang_berat']);
		$r_total = nosql($row['total']);

		?>
	
		<script language='javascript'>
		//membuat document jquery
		$(document).ready(function(){

	        $('#e_tgl1').datepicker({
	            format: 'dd/mm/yyyy',
	            todayHighlight: true,
	            autoclose: true,
	        })
	        
	        
				
		});
		
		</script>
			
	
		<?php


		echo '<table width="100%" border="0">
		<tr valign="top">
		<td width="300">      
	    <p>
		Tgl. Order : 
		<br>
		<b>'.$r_tgl_booking.'</b>
		</p>
		
		<p>
		Nomor Nota :
		<br>
		<b>'.$r_nota_kode.'</b>
		</p>
		
		<p>
		Jumlah Jenis Item :
		<br>
		<b>'.$r_jml_jenis.'</b>
		
		</p>
		
		<p>
		Jumlah Qty Item :
		<br>
		<b>'.$r_qty.'</b>
		</p>
		
		<p>
		Berat :
		<br>
		<b>'.$r_berat.' Gram</b>
		</p>
		
		<p>
		Total :
		<br>
		<b>'.xduit2($r_total).'</b>
		</p>
		
		
		</td>
		
		<td>
		<p>
		Tanggal Transfer :
		<br>
			
		<input name="e_tgl1" id="e_tgl1" type="text" size="10" value="'.$e_tgl_bayar.'" class="btn btn-info">
		
		</p>
		
		<p>
		File .jpg Bukti Transfer :
		<br>
		<input name="filex_foto" type="file" size="15" class="btn btn-info">		 		
		</p>
		
		<p>
		<input name="notakdx" type="hidden" value="'.$notakd.'">
		<input name="btnSMP2" type="submit" value="UPLOAD & KIRIM" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="BATAL" class="btn btn-warning">
		</p>
		
		</td>
		
		</tr>
		</table>';

		}	

	}

else
	{
	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND penerima_nama <> '' ".
						"AND konfirmasi = 'false' ".
						"ORDER BY postdate DESC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);
	
	if (!empty($total))
		{
		?>
		
		
		  
		  <script>
		  	$(document).ready(function() {
		    $('#table-responsive').dataTable( {
		        "scrollX": true
		    } );
		} );
		  </script>
		  
		<?php
	
	
		echo '<div class="table-responsive">          
			  <table class="table" border="1">
			    <thead>
				<tr bgcolor="'.$warnaheader.'">
	          <th>TGL TRANSAKSI</th>
	          <th>NOTA</th>
	          <th>JML JENIS ITEM</th>
	          <th>QTY ITEM</th>
	          <th>BERAT</th>
	          <th>TOTAL</th>
	          <th>KONFIRMASI</th>
	        </tr>
			    </thead>
			    <tbody>';
	
	
	
		do 
			{
			$r_kd = nosql($row['kd']);
			$r_tgl_booking = balikin($row['tgl_booking']);
			$r_nota_kode = balikin($row['nota_kode']);
			$r_jml_jenis = nosql($row['barang_jml_jenis']);
			$r_qty = nosql($row['barang_qty']);
			$r_berat = nosql($row['barang_berat']);
			$r_total = nosql($row['total']);
				
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
	
	
				
		
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$r_tgl_booking.'</td>
				<td>'.$r_nota_kode.'</td>
				<td>'.$r_jml_jenis.'</td>
				<td>'.$r_qty.'</td>
				<td>'.$r_berat.' Gram</td>
				<td>'.xduit2($r_total).'</td>
				<td>
				[<a href="'.$filenya.'?notakd='.$r_kd.'">KONFIRMASI</a>]
				</td>
		        </tr>';
				}
			while ($row = mysqli_fetch_assoc($q));
	
			echo '</tbody>
			  </table>
			  </div>';
			}
			
		else
			{
			echo "<font color=red>
			<h3>BELUM ADA DATA TRANSAKSI</h3>
			</font>";
			}		
	
	
	
		echo '</td>
		</tr>
		</table>';
		}
	
	
echo '</form>';




//isi
$isi = ob_get_contents();
ob_end_clean();










require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>