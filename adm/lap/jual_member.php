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
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "jual_member.php";
$judul = "[LAPORAN] Penjualan per Member";
$judulku = $judul;
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);

$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//cek
	if (empty($kunci))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?kunci=$kunci";
		xloc($ke);
		exit();
		}
	}




//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();




//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/number.js");
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
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="kd" type="hidden" value="'.$kd.'">
<input name="s" type="hidden" value="'.$s.'">';


echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>

<input name="kunci" type="text" value="'.$kunci.'" size="20" class="btn btn-warning">
<input name="btnCARI" type="submit" class="btn btn-danger" value="CARI >>">
<input name="btnRST" type="submit" class="btn btn-info" value="RESET">
</td>
</tr>
</table>';


//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (empty($s))
	{
	//kunci
	if (!empty($kunci))
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_proses <> '0000-00-00' ".
						"AND tgl_kirim <> '0000-00-00' ".
						"AND tgl_diterima <> '0000-00-00' ".
						"AND member_nama LIKE '%$kunci%' ".
						"ORDER BY tgl_booking DESC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}


	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_proses <> '0000-00-00' ".
						"AND tgl_kirim <> '0000-00-00' ".
						"AND tgl_diterima <> '0000-00-00' ".
						"ORDER BY tgl_booking DESC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	if ($count != 0)
		{
		//view data				  
		echo '<br>
		<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				<tr bgcolor="'.$warnaheader.'">
		        <th>MEMBER</th>
				<th>TGL DITERIMA</th>
				<th>TGL KIRIM</th>
				<th>TGL PROSES</th>
				<th>TGL BOOKING</th>
		        <th>NOTA KODE</th>
		        <th>JUMLAH ITEM</th>
		        <th>JUMLAH QTY</th>
		        <th>JUMLAH BERAT</th>
		        <th>JASA KIRIM</th>
		        <th>KODE UNIK</th>
		        <th>TOTAL</th>
		      </tr>
		    </thead>
		    <tbody>';



		do
			{
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

			//nilai
			$nomer = $nomer + 1;
			$kd = nosql($data['kd']);
			$i_member_kd = nosql($data['member_kd']);
			$i_member_nama = balikin($data['member_nama']);
			$i_nota = balikin($data['nota_kode']);
			$i_jml_jenis = balikin($data['barang_jml_jenis']);
			$i_jml_qty = balikin($data['barang_qty']);
			$i_jml_berat = balikin($data['barang_berat']);
			$i_isi = balikin($data['isi']);
			$i_member_nama = balikin($data['member_nama']);
			$i_tgl_booking = balikin($data['tgl_booking']);
			$i_tgl_proses = balikin($data['tgl_proses']);
			$i_tgl_diterima = balikin($data['tgl_diterima']);
			$i_tgl_kirim = balikin($data['tgl_kirim']);
			$i_tgl_bayar = balikin($data['tgl_bayar']);
			$i_jasakirim = balikin($data['jasakirim']);
			$i_kodeunik = balikin($data['kodeunik']);
			$i_total = balikin($data['total']);
			$i_p_nama = balikin($data['penerima_nama']);
			$i_p_alamat = balikin($data['penerima_alamat']);
			$i_p_kelurahan = balikin($data['penerima_kelurahan']);
			$i_p_kecamatan = balikin($data['penerima_kecamatan']);
			$i_p_kabupaten = balikin($data['penerima_kabupaten']);
			$i_p_propinsi = balikin($data['penerima_propinsi']);
			$i_p_kodepos = balikin($data['penerima_kodepos']);
			$i_catatan = balikin($data['catatan']);
			$i_filex_bayar = balikin($data['filex_bayar']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_member_nama.'</td>
			<td>'.$i_tgl_diterima.'</td>
			<td>'.$i_tgl_kirim.'</td>
			<td>'.$i_tgl_proses.'</td>
			<td>'.$i_tgl_booking.'</td>
			<td>'.$i_nota.'</td>
			<td>'.$i_jml_jenis.'</td>
			<td>'.$i_jml_qty.'</td>
			<td>'.$i_jml_berat.' Gram</td>
			<td>'.$i_jasakirim.'</td>
			<td>'.$i_kodeunik.'</td>
			<td>'.xduit2($i_total).'</td>
	    	</tr>';
			}
		while ($data = mysqli_fetch_assoc($result));

		echo '</tbody>
		  </table>
		  </div>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA.</strong>
		</font>
		</p>';
		}
	}




echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>