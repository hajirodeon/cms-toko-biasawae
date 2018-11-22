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
$filenya = "tolak.php";
$judul = "[PESANAN] Tolak";
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

$limit = 1;


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
						"WHERE konfirmasi = 'false' ".
						"AND tgl_proses <> '0000-00-00' ".
						"AND (member_nama LIKE '%$kunci%' ".
						"OR tgl_booking LIKE '%$kunci%' ".
						"OR nota_kode LIKE '%$kunci%' ".
						"OR jasakirim LIKE '%$kunci%' ".
						"OR kodeunik LIKE '%$kunci%' ".
						"OR penerima_nama LIKE '%$kunci%' ".
						"OR penerima_telp LIKE '%$kunci%' ".
						"OR penerima_alamat LIKE '%$kunci%' ".
						"OR penerima_kelurahan LIKE '%$kunci%' ".
						"OR penerima_kecamatan LIKE '%$kunci%' ".
						"OR penerima_kabupaten LIKE '%$kunci%' ".
						"OR penerima_propinsi LIKE '%$kunci%' ".
						"OR penerima_kodepos LIKE '%$kunci%' ".
						"OR catatan LIKE '%$kunci%') ".
						"ORDER BY tgl_booking DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}


	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'false' ".
						"AND tgl_proses <> '0000-00-00' ".
						"ORDER BY tgl_booking DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	if ($count != 0)
		{
		//view data				  
		echo '<br>
		<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				<tr bgcolor="'.$warnaheader.'">
				<th>TGL BOOKING</th>
		        <th>MEMBER</th>
		        <th>NOTA KODE</th>
		        <th>ITEM</th>
		        <th>JUMLAH ITEM</th>
		        <th>JUMLAH QTY</th>
		        <th>JUMLAH BERAT</th>
		        <th>JASA KIRIM</th>
		        <th>KODE UNIK</th>
		        <th>TOTAL</th>
		        <th>NAMA PENERIMA</th>
		        <th>ALAMAT</th>
		        <th>KELURAHAN</th>
		        <th>KECAMATAN</th>
		        <th>KABUPATEN</th>
		        <th>PROVINSI</th>
		        <th>KODE POS</th>
		        <th>CATATAN</th>
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
			$i_booking = balikin($data['tgl_booking']);
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
			echo '<td>'.$i_booking.'</td>
			<td>'.$i_member_nama.'</td>
			<td>'.$i_nota.'</td>
			<td>';
			

			//query
			$q = mysql_query("SELECT * FROM member_order_detail ".
								"WHERE member_kd = '$i_member_kd' ".
								"AND nota_kd = '$kd' ".
								"ORDER BY item_nama ASC");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);
		

			echo '<table class="table" border="1">
					<tr bgcolor="'.$warnaheader.'">
		          <td>FOTO</td>
		          <td>NAMA</td>
		          <td>KONDISI</td>
		          <td>BERAT</td>
		          <td>JUMLAH</td>
		        </tr>';
		
		
		
				do 
					{
					$r_kd = nosql($row['kd']);
					$r_itemkd = nosql($row['item_kd']);
					$r_nama = balikin($row['item_nama']);
					$r_kondisi = balikin($row['item_kondisi']);
					$r_berat = balikin($row['item_berat']);
					$r_filex = balikin($row['item_filex1']);
					$r_harga = nosql($row['item_harga']);
					$r_qty = nosql($row['jumlah']);
					$r_subtotal = nosql($row['subtotal']);
						
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
			
							
						//stock yang ada
						$qtyk = mysql_query("SELECT * FROM m_item ".
												"WHERE kd = '$r_itemkd'");
						$rtyk = mysql_fetch_assoc($qtyk);
						$e_jml = nosql($rtyk['jml']);
						
				
						echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
						echo '<td width="150">
						<img src="'.$sumber.'/filebox/item/'.$r_itemkd.'/'.$r_filex.'" width="150">
						</td>
						<td width="300">'.$r_nama.'</td>
						<td width="100">'.$r_kondisi.'</td>
						<td width="100">'.$r_berat.' gram</td>
						<td width="50">'.$r_qty.'</td>
				        </tr>';
						}
					while ($row = mysql_fetch_assoc($q));
			
					echo '</table>';


			echo '</td>
			<td>'.$i_jml_jenis.'</td>
			<td>'.$i_jml_qty.'</td>
			<td>'.$i_jml_berat.' Gram</td>
			<td>'.$i_jasakirim.'</td>
			<td>'.$i_kodeunik.'</td>
			<td>'.xduit2($i_total).'</td>
			<td>'.$i_p_nama.'</td>
			<td>'.$i_p_alamat.'</td>
			<td>'.$i_p_kelurahan.'</td>
			<td>'.$i_p_kecamatan.'</td>
			<td>'.$i_p_kabupaten.'</td>
			<td>'.$i_p_propinsi.'</td>
			<td>'.$i_p_kodepos.'</td>
			<td>'.$i_catatan.'</td>
	    	</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

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