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
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "jual_item.php";
$judul = "Penjualan per Item";
$judulku = "[LAPORAN]. $judul";
$judulx = $judul;
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$brgkd = nosql($_REQUEST['brgkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


//focus
//nek sih null
if (empty($xbln1))
	{
	$diload = "document.formx.xbln1.focus();";
	}
else if (empty($xthn1))
	{
	$diload = "document.formx.xthn1.focus();";
	}







//isi *START
ob_start();


//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT member_order.*, member_order_detail.*, m_item.*, m_item.nama AS mbnm ".
				"FROM member_order, member_order_detail, m_item ".
				"WHERE member_order.kd = member_order_detail.nota_kd ".
				"AND member_order_detail.item_kd = m_item.kd ".
				"AND m_item.kd = '$brgkd' ".
				"AND round(DATE_FORMAT(member_order.tgl_diterima, '%m')) = '$xbln1' ".
				"AND round(DATE_FORMAT(member_order.tgl_diterima, '%Y')) = '$xthn1' ".
				"ORDER BY member_order.tgl_diterima ASC";

$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?brgkd=$brgkd&xbln1=$xbln1&xthn1=$xthn1";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);

//nilai data
$brg_kode = nosql($data['kode']);
$brg_nm = balikin($data['mbnm']);




//require
require("../../template/js/jumpmenu.js");
require("../../template/js/swap.js");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form method="post" action="'.$filenya.'" name="formx">

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warna02.'">
<td>
<p>
<strong>Bulan : </strong>';
echo "<select name=\"xbln1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$xbln1.'" selected>'.$arrbln[$xbln1].'</option>';

for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$filenya.'?xbln1='.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>';

echo "<select name=\"xthn1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$xthn1.'" selected>'.$xthn1.'</option>';


for ($k=$tahun-3;$k<=$tahun;$k++)
	{
	$x_thn = $k;;
	echo '<option value="'.$filenya.'?xbln1='.$xbln1.'&xthn1='.$x_thn.'">'.$x_thn.'</option>';
	}


echo '</select>, 
</p>


<p>';
echo "<select name=\"item\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//itemnya
$qthnx = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"WHERE kd = '$brgkd'");
$rthnx = mysqli_fetch_assoc($qthnx);
$item_nama = balikin($rthnx['nama']);


echo '<option value="'.$brgkd.'" selected>'.$item_nama.'</option>';

//query
$qthn = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"ORDER BY nama ASC");
$rthn = mysqli_fetch_assoc($qthn);

do
	{
	$x_kd = nosql($rthn['kd']);
	$x_thn = balikin($rthn['nama']);
	
	
	echo '<option value="'.$filenya.'?xbln1='.$xbln1.'&xthn1='.$xthn1.'&brgkd='.$x_kd.'">'.$x_thn.'</option>';
	}
while ($rthn = mysqli_fetch_assoc($qthn));

echo '</select>
</p>

</td>
</tr>
</table>';


//cek
if ((empty($xbln1)) OR (empty($xthn1)))
	{
	echo '<font color="red"><h4>Per Bulan Apa...?</h4></font>';
	}
else if (empty($brgkd))
	{
	echo '<font color="red"><h4>ITEM BELUM DIPILIH...!!</h4></font>';
	}
else
	{
	if ($count != 0)
		{
		echo '<p>
		Kode Barang : <strong>'.$brg_kode.'</strong>,
		<br>
		Nama Barang : <strong>'.$brg_nm.'</strong>
		</p>';
		echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100"><strong><font color="'.$warnatext.'">Tanggal</font></strong></td>
		<td width="300"><strong><font color="'.$warnatext.'">Member</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
		</tr>';

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

			$nomer = $nomer + 1;
			$y_kd = nosql($data['kd']);
			$y_tgl = $data['tgl_diterima'];
			$y_pelanggan = balikin($data['member_nama']);
			$y_qty = nosql($data['barang_qty']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$y_tgl.'</td>
			<td>'.$y_pelanggan.'</td>
			<td>'.$y_qty.'</td>
	        </tr>';
			}
		while ($data = mysqli_fetch_assoc($result));

		echo '</table>

		<table width="700" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<font color="red"><strong>TIDAK ADA HISTORY.</strong></font>';
		}
	}

echo '</form>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>