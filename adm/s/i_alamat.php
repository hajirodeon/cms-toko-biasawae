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
 
 

 
 
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");



$id_provinsi  = cegah($_POST['id_provinsi']);
$id_kabupaten  = cegah($_POST['id_kabupaten']);


if(isset($_POST["id_provinsi"]) && !empty($_POST["id_provinsi"]))
	{
	$qku = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
							"WHERE id_prov = '$id_provinsi' ".
  							"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);

	do
		{
		$ku_idkab = nosql($rku['id_kab']);
		$ku_nama = balikin($rku['nama']);
		$ku_nama2 = cegah($rku['nama']);
		

		echo '<option value="'.$ku_idkab.'">'.$ku_nama.'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	exit();
  	}




if(isset($_POST["id_kabupaten"]) && !empty($_POST["id_kabupaten"]))
	{
	$qku = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
							"WHERE id_kab = '$id_kabupaten' ".
  							"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);

	do
		{
		$ku_idkec = nosql($rku['id_kec']);
		$ku_nama = balikin($rku['nama']);
		$ku_nama2 = cegah($rku['nama']);

		echo '<option value="'.$ku_idkec.'">'.$ku_nama.'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	exit();
  	}








exit();
?>