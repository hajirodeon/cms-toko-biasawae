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
$filenya = "info.php";
$judul = "[MASTER] Data Info";
$judulku = "$judul  [$adm_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kdku = nosql($_REQUEST['kdku']);









//jika daftar
if($_POST['btnDF'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
	
	

//jika simpan
if($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kdku = nosql($_POST['kdku']);
	$e_judul = cegah($_POST['e_judul']);
	$e_isi = cegah2($_POST['editor1']);



	
	//nek null
	if (empty($e_judul))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=baru&kdku=$kdku";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ((empty($s)) OR ($s == "baru"))
			{
			$kdku = $x;
			
			//query
			mysqli_query($koneksi, "INSERT INTO m_info(kd, judul, isi, postdate) VALUES ".
							"('$kdku', '$e_judul', '$e_isi', '$today')");


								
			//re-direct
			$ke = "$filenya?s=edit&kdku=$kdku";
			xloc($ke);
			exit();
			}
		else 
			{
			//query
			mysqli_query($koneksi, "UPDATE m_info SET judul = '$e_judul', ".
							"isi = '$e_isi', ".
							"postdate = '$today' ".
							"WHERE kd = '$kdku'");


			//re-direct
			$ke = "$filenya?s=edit&kdku=$kdku";
			xloc($ke);
			exit();
			}
		}


	exit();
	}





//jika baru
if($_POST['btnBARU'])
	{
	//re-direct
	$ke = "$filenya?s=baru&kdku=$x";
	xloc($ke);
	exit();
	}







//jika hapus data
if($_POST['btnHPS'])
	{
	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_info ".
						"WHERE kd = '$kd'");
		}



	//re-direct
	xloc($filenya);
	exit();
	}



	




//isi *START
ob_start();

?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//js
require("../../template/js/jumpmenu.js");
require("../../template/js/swap.js");
require("../../template/js/checkall.js");




echo '<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">


<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>

<input name="kd" type="hidden" value="'.$kd.'">
<input name="kdku" id="kdku" type="hidden" value="'.$kdku.'">
<input name="s" type="hidden" value="'.$s.'">


<button name="btnBARU" id="btnBARU" type="submit" value="BUAT BARU" class="btn btn-danger">BUAT BARU</button>
<hr>
</td>
</tr>
</table>
</p>';




//jika edit
//tampilkan form
if (($s == 'baru') OR ($s == 'edit'))
	{
	//query
	$qx = mysqli_query($koneksi, "SELECT * FROM m_info ".
						"WHERE kd = '$kdku'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_judul = balikin($rowx['judul']);
	$e_isi = balikin2($rowx['isi']);
	$e_postdate = $rowx['postdate'];

	//pecah titik - titik
	//$e_isi2 = pathasli2($e_isi);
	$e_isi2 = $e_isi;
	
	
	echo '<h2>Entri Baru/Edit</h2>

		
	<p>
	Judul : 
	<br>
	<input name="e_judul" id="e_judul" type="text" value="'.$e_judul.'" size="50" class="btn btn-warning">
	</p>
	
	<p>
	Isi : 
	<br>
	
	<textarea id="editor1" name="editor1" rows="10" cols="80" class="btn btn-warning">
	'.$e_isi2.'
	</textarea>
	</p>
	<br>


	<p>
	<button name="btnSMP" id="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">SIMPAN</button>
	<button name="btnDF" id="btnDF" type="submit" value="BATAL" class="btn btn-info">BATAL</button>
	</p>';
	}
else 
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_info ".
					"ORDER BY postdate DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);



	if ($count != 0)
		{
		//view data
		echo '<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="200"><strong><font color="'.$warnatext.'">Judul</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ISI</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Postdate</font></strong></td>
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

			//nilai
			$nomer = $nomer + 1;
			$i_kd = nosql($data['kd']);
			$i_judul = balikin($data['judul']);
			$i_isi = balikin($data['isi']);
			$i_postdate = $data['postdate'];




			//pecah titik - titik
			//$i_isi2 = pathasli2($i_isi);
			$i_isi2 = $i_isi;

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
    		</td>
			<td>
			<a href="'.$filenya.'?s=edit&kdku='.$i_kd.'" title="EDIT..."><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$i_judul.'</td>
			<td>'.$i_isi2.'</td>
			<td>'.$i_postdate.'</td>
    		</tr>';
			}
		while ($data = mysqli_fetch_assoc($result));

		echo '</tbody>
		  </table>
		  </div>


		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		
		<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
		<br>
		
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
		<input name="m" type="hidden" value="'.nosql($_REQUEST['m']).'">
		<input name="kdku" type="hidden" value="'.nosql($_REQUEST['kdku']).'">
		<input name="btnALL" type="button" value="SEMUA" class="btn btn-warning" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL" class="btn btn-info">
		<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
		</td>
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


</div>
</div>
</div>
</div>
</div>
</div>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>