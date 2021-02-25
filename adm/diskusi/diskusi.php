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
$filenya = "diskusi.php";
$judul = "DISKUSI";
$judulku = "$judul";
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






//simpan balasan
if ($_POST['btnSMP'])
	{
	//nilai
	$kd = cegah($_POST['kd']);
	$s = cegah($_POST['s']);
	$e_balasan = cegah($_POST['e_balasan']);


	//cek
	if (empty($e_balasan))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?s=balas&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//simpan
		mysqli_query($koneksi, "UPDATE member_diskusi SET balasan = '$e_balasan', ".
						"balasan_postdate = '$today' ".
						"WHERE kd = '$kd'");
		
		//re-direct
		xloc($filenya);
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








//ke daftar 
if ($_POST['btnDF'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
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


//jika balas
if ($s == "balas")
	{
	//detail
	$qkuy = mysqli_query($koneksi, "SELECT * FROM member_diskusi ".
							"WHERE kd = '$kd'");
	$rkuy = mysqli_fetch_assoc($qkuy);
	$i_postdate = balikin($rkuy['postdate']);
	$i_item_nama = balikin($rkuy['item_nama']);
	$i_isi = balikin($rkuy['isi']);
	$i_member_nama = balikin($rkuy['member_nama']);
	$i_balasan = balikin($rkuy['balasan']);
	$i_balasan_postdate = balikin($rkuy['balasan_postdate']);


	echo '<p>
	Postdate : <b>'.$i_postdate.'</b>
	</p>
	
	<p>
	Item : <b>'.$i_item_nama.'</b>
	</p>
	
	<p>
	Isi : <b>'.$i_isi.'</b>
	</p>
	
	
	<p>
	Balasan :
	<br>
	<input name="e_balasan" type="text" value="'.$i_balasan.'" size="50" class="btn btn-warning">
	</p>
	
	<p>
	<input name="btnSMP" type="submit" class="btn btn-danger" value="SIMPAN BALASAN">
	<input name="btnBTL" type="submit" class="btn btn-primary" value="BATAL">
	</p>';
	}
	
else
	{
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
	
			$sqlcount = "SELECT * FROM member_diskusi ".
							"WHERE member_nama LIKE '%$kunci%' ".
							"OR item_nama LIKE '%$kunci%' ".
							"OR isi LIKE '%$kunci%' ".
							"ORDER BY postdate DESC";
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
	
			$sqlcount = "SELECT * FROM member_diskusi ".
							"ORDER BY postdate DESC";
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
					<th>POSTDATE</th>
			        <th>ISI DISKUSI</th>
			        <th>ITEM</th>
			        <th>MEMBER</th>
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
				$i_item_nama = balikin($data['item_nama']);
				$i_isi = balikin($data['isi']);
				$i_member_nama = balikin($data['member_nama']);
				$i_postdate = balikin($data['postdate']);
				$i_balasan = balikin($data['balasan']);
				$i_balasan_postdate = balikin($data['balasan_postdate']);
	
				//jika dibalas
				if (!empty($i_balasan))
					{
					$i_ket = '[Postdate : '.$i_balasan_postdate.'].';
					}
				else
					{
					$i_ket = "";
					}
	
	
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$i_postdate.'</td>
				<td>
				'.$i_isi.'
				<hr>
				<i><font color="orange">'.$i_balasan.'</font></i>
				<br>
				[<a href="'.$filenya.'?s=balas&kd='.$kd.'">BALAS</a>]. 
				<br>
				'.$i_ket.' 
				</td>
				<td>'.$i_item_nama.'</td>
				<td>'.$i_member_nama.'</td>
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