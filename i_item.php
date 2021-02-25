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
	




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$notakd = cegah($_GET['notakd']);
	$sesikd = cegah($_GET['sesikd']);
	$itemkd = cegah($_GET['itemkd']);
	$jmlku = cegah($_GET['jmlku']);


	//detail item
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_item ".
							"WHERE kd = '$itemkd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$item_nama = cegah($rcc['nama']);
	$item_berat = cegah($rcc['berat']);
	$item_harga = cegah($rcc['harga']);
	$item_kondisi = cegah($rcc['kondisi']);
	$item_jml = cegah($rcc['jml']);
	$item_filex = cegah($rcc['filex1']);
	
	
	//subtotal
	$item_subtotal = $item_harga * $jmlku;
	$item_subtotal_berat = $item_berat * $jmlku;
	
	
	

	//cek nota terakhir, yang masih kosong
	$qcc = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE member_kd = '$sesikd' ".
							"AND kd = '$notakd' ".
							"ORDER BY postdate DESC");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	
	//jika null
	if (empty($tcc))
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO member_order(kd, member_kd, postdate) VALUES ".
						"('$notakd', '$sesikd', '$today')");
		}
	
	
	



	
	
	//cek item
	$qcek = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
							"WHERE member_kd = '$sesikd' ".
							"AND nota_kd = '$notakd' ".
							"AND item_kd = '$itemkd'");
	$rcek = mysqli_fetch_assoc($qcek);
	$tcek = mysqli_num_rows($qcek);
	
	//jika null, insert
	if (empty($tcek))
		{
		//masukin detail
		mysqli_query($koneksi, "INSERT INTO member_order_detail(kd, member_kd, member_nama, nota_kd, item_kd, item_nama, ".
						"item_filex1, item_berat, item_harga, item_kondisi, ".
						"jumlah, subtotal, subtotal_berat, postdate) VALUES ".
						"('$x', '$sesikd', '$sesinama', '$notakd', '$itemkd', '$item_nama', ".
						"'$item_filex', '$item_berat', '$item_harga', '$item_kondisi', ".
						"'$jmlku', '$item_subtotal', '$item_subtotal_berat', '$today')");
		}
	else
		{
		//update jumlah...
		mysqli_query($koneksi, "UPDATE member_order_detail SET jumlah = jumlah + '$jmlku', ".
						"subtotal = '$item_subtotal', ".
						"subtotal_berat = '$item_subtotal_berat', ".
						"postdate = '$today' ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd' ".
						"AND item_kd = '$itemkd'");
		}
	
	
	
	
	//kurangi stock
	$stock_sisa = round($item_jml - $jmlku);
	
	//update
	mysqli_query($koneksi, "UPDATE m_item SET jml = '$stock_sisa' ".
					"WHERE kd = '$itemkd'");

	?>


	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){

			window.location.href = "member_troli.php";

	
	});
	
	</script>
	

	<?php
	exit();
	}
















//jika simpan diskusi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpandiskusi'))
	{
	//ambil nilai
	$sesikd = cegah($_SESSION['sesikd']);
	$sesinama = cegah($_SESSION['sesinama']);
	$itemkd = cegah($_GET['itemkd']);
	$e_diskusi = cegah($_GET['e_diskusi']);

	

	//detail e
	$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
							"WHERE kd = '$itemkd'");
	$rtyk = mysqli_fetch_assoc($qtyk);
	$e_nama = balikin($rtyk['nama']);
	
	
	$kodeku = "diskuya$itemkd$jam";

	//jika null
	if (empty($_SESSION[$kodeku]))
		{
		//buat sesi
		$_SESSION[$kodeku] = "$itemkd$e_diskusi$jam";
		


		//insert
		mysqli_query($koneksi, "INSERT INTO member_diskusi(kd, member_kd, member_nama, item_kd, item_nama, isi, postdate) VALUES ".
						"('$x', '$sesikd', '$sesinama', '$itemkd', '$e_nama', '$e_diskusi', '$today')");

		}
	


	exit();
	}


















//jika form diskusi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'formdiskusi'))
	{
	//ambil nilai
	$itemkd = cegah($_GET['itemkd']);
	$sesikd = cegah($_GET['sesikd']);
	
	$_SESSION['sesikd'] = $sesikd; 
	?>

	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){



		$("#btnKRM21").on('click', function(){
			
			$("#formx21").submit(function(){
				$.ajax({
					url: "i_item.php?aksi=simpandiskusi&itemkd=<?php echo $itemkd;?>",
					type:$(this).attr("method"),
					data:$(this).serialize(),
					success:function(data){					
						$("#iproses").html(data);
						$("#ilistdiskusi").load("i_item.php?aksi=listdiskusi&sesikd=<?php echo $kd6_session;?>&itemkd=<?php echo $itemkd;?>");

						}
					});
				return false;
			});
		
		
		});	

	
	

			
	});
	
	</script>
		

	<?php
	if (!empty($sesikd))
		{
		echo '<form name="formx21" id="formx21">
	
		<p>
		<textarea cols="30" name="e_diskusi" id="e_diskusi" rows="3" class="btn btn-info"></textarea>
		</p>
	
		<p>
		<input name="btnKRM21" id="btnKRM21" type="submit" class="btn btn-danger" value="KIRIM >>">
		</p>
		
		</form>';
		}


	
	exit();
	}














//jika list diskusi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'listdiskusi'))
	{
	//ambil nilai
	$itemkd = cegah($_GET['itemkd']);
	$sesikd = cegah($_GET['sesikd']);
	

	//list
	$qku = mysqli_query($koneksi, "SELECT * FROM member_diskusi ".
						"WHERE item_kd = '$itemkd' ".
						"ORDER BY postdate DESC LIMIT 0,100");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	
	//jika ada
	if (!empty($tku))
		{
		do
			{
			//nilai
			$i_isi = balikin($rku['isi']);
			$i_nama = balikin($rku['member_nama']);
			$i_balasan = balikin($rku['balasan']);
			$i_postdate = balikin($rku['postdate']);
			
			
			echo '<table border="0" width="100%">
			<tr valign="top">
			<td>
			<i>
			'.$i_isi.'
			<br>
			['.$i_nama.']. ['.$i_postdate.'].
			</i>
			
			</td>
			</tr>
			</table>
			
			<table border="0" width="100%">
			<tr valign="top">
			<td width="50">
			&nbsp;
			</td>
			
			<td>
			<font color="red">'.$i_balasan.'</font>
			</td>
			</tr>
			</table>
			<hr>';
			}
		while ($rku = mysqli_fetch_assoc($qku));
		}

	
	exit();
	}










//jika list testimoni
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'listtestimoni'))
	{
	//ambil nilai
	$itemkd = cegah($_GET['itemkd']);
	$sesikd = cegah($_GET['sesikd']);
	

	//list
	$qku = mysqli_query($koneksi, "SELECT * FROM member_testimoni ".
						"WHERE item_kd = '$itemkd' ".
						"ORDER BY postdate DESC LIMIT 0,100");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);
	
	//jika ada
	if (!empty($tku))
		{
		do
			{
			//nilai
			$i_isi = balikin($rku['isi']);
			$i_kualitas_no = nosql($rku['nilai_kualitas_no']);
			$i_manfaat_no = nosql($rku['nilai_manfaat_no']);
			$i_kualitas = balikin($rku['nilai_kualitas']);
			$i_manfaat = balikin($rku['nilai_manfaat']);
			$i_nama = balikin($rku['member_nama']);
			$i_postdate = balikin($rku['postdate']);
			
			
			echo '<table border="0" width="100%">
			<tr valign="top">
			<td>
			<i>
			'.$i_isi.'
			<br>';
			
			for ($k=1;$k<=$i_kualitas_no;$k++)
				{
				echo '<img src="template/img/bintang.png" width="16">';
				}
			
			
			echo ' [Kualitas : '.$i_kualitas.'].
			<br>';
			
			
			for ($k=1;$k<=$i_manfaat_no;$k++)
				{
				echo '<img src="template/img/bintang.png" width="16">';
				}
			
			echo ' [Manfaat : '.$i_manfaat.'].
			<br>
			<br>
			
			['.$i_nama.']. ['.$i_postdate.'].
			</i>
			
			</td>
			</tr>
			</table>
			<hr>';
			}
		while ($rku = mysqli_fetch_assoc($qku));
		}

	
	exit();
	}








	
exit();
?>