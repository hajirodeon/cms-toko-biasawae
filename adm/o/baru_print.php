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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$kd = nosql($_REQUEST['kd']);


$diload = "window.print();";




//isi *START
ob_start();





//ketahui 
$qku = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE kd = '$kd'");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);
$ku_tgl_dikirim = balikin($rku['tgl_dikirim']);
$ku_tgl_diterima = balikin($rku['tgl_diterima']);
$ku_jasakirim = balikin($rku['jasakirim']);
$ku_nota_kode = balikin($rku['nota_kode']);
$ku_tgl_booking = balikin($rku['tgl_booking']);
$ku_barang_jml_jenis = nosql($rku['barang_jml_jenis']);
$ku_barang_qty = nosql($rku['barang_qty']);
$ku_barang_berat = nosql($rku['barang_berat']);
$ku_subtotal = nosql($rku['subtotal']);
$ku_kodeunik = nosql($rku['kodeunik']);
$ku_total = nosql($rku['total']);
$ku_penerima_nama = balikin($rku['penerima_nama']);
$ku_penerima_telp = balikin($rku['penerima_telp']);
$ku_penerima_propinsi = balikin($rku['penerima_propinsi']);
$ku_penerima_kabupaten = balikin($rku['penerima_kabupaten']);
$ku_penerima_kecamatan = balikin($rku['penerima_kecamatan']);
$ku_penerima_kelurahan = balikin($rku['penerima_kelurahan']);
$ku_penerima_alamat = balikin($rku['penerima_alamat']);
$ku_penerima_kodepos = balikin($rku['penerima_kodepos']);
$ku_penerima_catatan = balikin($rku['catatan']);




echo '<table width="100%" border="0">
<tr valign="top">
<td>
<h3>
Nomor Nota :
<br>
<b>'.$ku_nota_kode.'</b>
</h3>

<h3>
Tanggal Order :
<br>
<b>'.$ku_tgl_booking.'</b>
</h3>



<h3>
Jumlah Jenis Item : 
<br>
<b>'.$ku_barang_jml_jenis.'</b>
</h3>


<h3>
Jumlah Qty Item : 
<br>
<b>'.$ku_barang_qty.'</b>
</h3>

<h3>
Berat dalam Paket : 
<br>
<b>'.$ku_barang_berat.' Gram</b>
</h3>


<h3>
Kode Unik : 
<br>
<b>'.$ku_kodeunik.'</b>
</h3>

<h3>
Jasa Kirim : 
<br>
<b>'.$ku_jasakirim.'</b>
</h3>

</td>
</tr>
</table>
	
	
<hr>


<h3>
Penerima Paket :
</h3>
<hr>


<table width="100%" border="0">
<tr valign="top">
<td>

<p>
Nama :
<br>
'.$ku_penerima_nama.'
</p>

<p>
Telepon :
<br> 
'.$ku_penerima_telp.'
</p>

<p>
Alamat : 
<br>
'.$ku_penerima_alamat.'
</p>

<p>
Kelurahan :
<br> 
'.$ku_penerima_kelurahan.'
</p>
	
		
<p>
Kecamatan :
<br>
'.$ku_penerima_kecamatan.'
</select>
</p>

<p>
Kabupaten / Kota :
<br>
'.$ku_penerima_kabupaten.'
</p>

<p>
Propinsi : 
<br>
'.$ku_penerima_propinsi.'

</p>
	


<p>
Kode Pos :
<br> 
'.$ku_penerima_kodepos.'
</p>

<p>
Catatan untuk Penjual :
<br>
'.$ku_penerima_catatan.'
</p>




</td>



</tr>
</table>




<table class="table" border="1">';



//query
$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
					"WHERE nota_kd = '$kd' ".
					"ORDER BY item_nama ASC");
$row = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);

do 
	{
	$r_no = $r_no + 1;
	$r_kd = nosql($row['kd']);
	$r_itemkd = nosql($row['item_kd']);
	$r_nama = balikin($row['item_nama']);
	$r_kondisi = balikin($row['item_kondisi']);
	$r_berat = balikin($row['item_berat']);
	$r_filex = balikin($row['item_filex1']);
	$r_harga = nosql($row['item_harga']);
	$r_qty = nosql($row['jumlah']);
	$r_subtotal = nosql($row['subtotal']);
		

	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td width="300">
	<p>
	<img src="'.$sumber.'/filebox/item/'.$r_itemkd.'/'.$r_filex.'" width="100">
	</p>
	<p>
	'.$r_nama.'
	</p>
	<p>
	['.$r_kondisi.']. 
	['.$r_berat.' gram].
	[Jumlah : '.$r_qty.']
	</p>
	
	</td>
    </tr>';
	}
while ($row = mysqli_fetch_assoc($q));

echo '</table>';
	  
	  
	


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>