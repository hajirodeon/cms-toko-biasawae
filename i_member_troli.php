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
	$sesikd = cegah($_GET['sesikd']);
	$itemkd = cegah($_GET['itemkd']);
	$detailkd = cegah($_GET['detailkd']);
	$jmlku = cegah($_GET['jmlku']);

	//detail e
	$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
							"WHERE kd = '$itemkd'");
	$rtyk = mysqli_fetch_assoc($qtyk);
	$e_nama = balikin($rtyk['nama']);
	$e_isi = balikin($rtyk['isi']);
	$e_berat = nosql($rtyk['berat']);
	$e_harga = nosql($rtyk['harga']);
	$e_jml = nosql($rtyk['jml']);


	//ketahui detail sebelumnya...
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
							"WHERE kd = '$detailkd'");
	$rku = mysqli_fetch_assoc($qku);
	$ku_jml = nosql($rku['jumlah']);



	//netralkan dulu, stock...
	mysqli_query($koneksi, "UPDATE m_item SET jml = jml + '$ku_jml' ".
					"WHERE kd = '$itemkd'");







	//hitung subtotal lagi...
	$e_subtotal = $jmlku * $e_harga;
	$e_subtotal_berat = $jmlku * $e_berat;


	//update jumlah...
	mysqli_query($koneksi, "UPDATE member_order_detail SET jumlah = '$jmlku', ".
					"subtotal = '$e_subtotal', ".
					"subtotal_berat = '$e_subtotal_berat', ".
					"postdate = '$today' ".
					"WHERE member_kd = '$sesikd' ".
					"AND kd = '$detailkd'");

	


	//kurangi stock
	mysqli_query($koneksi, "UPDATE m_item SET jml = jml - '$jmlku' ".
					"WHERE kd = '$itemkd'");


	exit();
	}








//jika hapus
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'hapus'))
	{
	//ambil nilai
	$sesikd = cegah($_GET['sesikd']);
	$detailkd = cegah($_GET['detailkd']);



	//ketahui detail sebelumnya...
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
							"WHERE kd = '$detailkd'");
	$rku = mysqli_fetch_assoc($qku);
	$ku_itemkd = nosql($rku['item_kd']);
	$ku_jml = nosql($rku['jumlah']);
	
	//detail e
	$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
							"WHERE kd = '$ku_itemkd'");
	$rtyk = mysqli_fetch_assoc($qtyk);
	$e_jml = nosql($rtyk['jml']);

	


	//netralkan dulu, stock...
	mysqli_query($koneksi, "UPDATE m_item SET jml = jml + '$ku_jml' ".
					"WHERE kd = '$itemkd'");







	//hapus
	mysqli_query($koneksi, "DELETE FROM member_order_detail ".
							"WHERE kd = '$detailkd'");

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











//jika subtotal
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'subtotal'))
	{
	//ambil nilai
	$sesikd = cegah($_GET['sesikd']);
	$detailkd = cegah($_GET['detailkd']);



	//ketahui detail sebelumnya...
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
							"WHERE kd = '$detailkd'");
	$rku = mysqli_fetch_assoc($qku);
	$ku_subtotal = nosql($rku['subtotal']);

	echo xduit2($ku_subtotal);


	exit();
	}








//jika total
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'total'))
	{
	//ambil nilai
	$notakd = cegah($_GET['notakd']);
	$sesikd = cegah($_GET['sesikd']);




	//ketahui detail sebelumnya...
	$qku = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total ".
							"FROM member_order_detail ".
							"WHERE member_kd = '$sesikd' ".
							"AND nota_kd = '$notakd'");
	$rku = mysqli_fetch_assoc($qku);
	$ku_subtotal = nosql($rku['total']);
	$nilku =  xduit2($ku_subtotal);




	//update
	mysqli_query($koneksi, "UPDATE member_order SET subtotal = '$ku_subtotal' ".
					"WHERE member_kd = '$sesikd' ".
					"AND kd = '$notakd'");

	echo "<b>$nilku</b>";


	exit();
	}










//jika rincian
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'rincian'))
	{
	//ambil nilai
	$sesikd = cegah($_GET['sesikd']);
	$notakd = cegah($_SESSION['notakd']);





	//ketahui detail sebelumnya...
	$qku = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
							"WHERE member_kd = '$sesikd' ".
							"AND nota_kd = '$notakd'");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);





	//ketahui detail sebelumnya...
	$qku = mysqli_query($koneksi, "SELECT SUM(subtotal_berat) AS total_berat, ".
							"SUM(jumlah) AS total_qty ".
							"FROM member_order_detail ".
							"WHERE member_kd = '$sesikd' ".
							"AND nota_kd = '$notakd'");
	$rku = mysqli_fetch_assoc($qku);
	$ku_total_berat = nosql($rku['total_berat']);
	$ku_total_qty = nosql($rku['total_qty']);
	$ku_total_jenis = $tku;

	echo "[Jumlah Jenis Item : <b>$ku_total_jenis</b>]. 
	[Jumlah Qty Item : <b>$ku_total_qty</b>].
	[Jumlah Berat : <b>$ku_total_berat Gram</b>].";


	//update
	mysqli_query($koneksi, "UPDATE member_order SET barang_jml_jenis = '$ku_total_jenis', ".
					"barang_qty = '$ku_total_qty', ".
					"barang_berat = '$ku_total_berat' ".
					"WHERE member_kd = '$sesikd' ".
					"AND kd = '$notakd'");



	exit();
	}










	
exit();
?>