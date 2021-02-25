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
$filenya = "testimoni.php";
$judul = "TESTIMONI";
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
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>

<input name="kunci" type="text" value="'.$kunci.'" size="20" class="btn btn-warning">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
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

		$sqlcount = "SELECT * FROM member_testimoni ".
						"WHERE member_nama LIKE '%$kunci%' ".
						"OR item_nama LIKE '%$kunci%' ".
						"OR isi LIKE '%$kunci%' ".
						"OR nilai_kualitas LIKE '%$kunci%' ".
						"OR nilai_manfaat LIKE '%$kunci%' ".
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

		$sqlcount = "SELECT * FROM member_testimoni ".
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
		//rata2 nilai
		$qyuk = mysqli_query($koneksi, "SELECT AVG(nilai_kualitas_no) AS total ".
								"FROM member_testimoni");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_kualitas_no = round(nosql($ryuk['total']));
		
		
		
		//rata2 nilai
		$qyuk = mysqli_query($koneksi, "SELECT AVG(nilai_manfaat_no) AS total ".
								"FROM member_testimoni");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_manfaat_no = round(nosql($ryuk['total']));
		
		
		
				
			
		//view data				  
		echo '<br>
		<p>
		[Rata - Rata Kualitas :';
		
		for ($k=1;$k<=$yuk_kualitas_no;$k++)
			{
			echo '<img src="../../template/img/bintang.png" width="16">';
			}
		 
		 echo '<b>'.$arrkualitas[$yuk_kualitas_no].'</b>].
		 </p>
		  
		  
		 <p>
		[Rata - Rata Manfaat : ';
		
		for ($k=1;$k<=$yuk_manfaat_no;$k++)
			{
			echo '<img src="../../template/img/bintang.png" width="16">';
			}
		
		 echo '<b>'.$arrmanfaat[$yuk_manfaat_no].'</b>].
		</p>

		<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				<tr bgcolor="'.$warnaheader.'">
				<th>POSTDATE</th>
		        <th>ISI TESTIMONI</th>
		        <th>ITEM</th>
		        <th>KUALITAS</th>
		        <th>MANFAAT</th>
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
			$i_nilai_kualitas = balikin($data['nilai_kualitas']);
			$i_nilai_kualitas_no = balikin($data['nilai_kualitas_no']);
			$i_nilai_manfaat = balikin($data['nilai_manfaat']);
			$i_nilai_manfaat_no = balikin($data['nilai_manfaat_no']);
			$i_postdate = balikin($data['postdate']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_postdate.'</td>
			<td>'.$i_isi.'</td>
			<td>'.$i_item_nama.'</td>
			<td>';
			
			for ($k=1;$k<=$i_nilai_kualitas_no;$k++)
				{
				echo '<img src="../../template/img/bintang.png" width="16">';
				}

			echo '<br>
			'.$i_nilai_kualitas.'
			</td>
			<td>';
			
			for ($k=1;$k<=$i_nilai_manfaat_no;$k++)
				{
				echo '<img src="../../template/img/bintang.png" width="16">';
				}

			echo '<br>
			'.$i_nilai_manfaat.'
			</td>
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