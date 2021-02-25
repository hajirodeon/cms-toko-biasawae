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
$filenya = "member.php";
$judul = "[MASTER] Data Member";
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








//ke daftar pegawai
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

		$sqlcount = "SELECT * FROM m_member ".
						"WHERE nama LIKE '%$kunci%' ".
						"OR email LIKE '%$kunci%' ".
						"OR telp LIKE '%$kunci%' ".
						"OR propinsi LIKE '%$kunci%' ".
						"OR kabupaten LIKE '%$kunci%' ".
						"OR kecamatan LIKE '%$kunci%' ".
						"OR kelurahan LIKE '%$kunci%' ".
						"OR alamat LIKE '%$kunci%' ".
						"OR kodepos LIKE '%$kunci%' ".
						"OR kelamin LIKE '%$kunci%' ".
						"OR tmp_lahir LIKE '%$kunci%' ".
						"OR tgl_lahir LIKE '%$kunci%' ".
						"OR web LIKE '%$kunci%' ".
						"ORDER BY nama ASC";
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

		$sqlcount = "SELECT * FROM m_member ".
						"ORDER BY nama ASC";
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
		echo '<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				<tr bgcolor="'.$warnaheader.'">
		        <th>NAMA</th>
		        <th>EMAIL</th>
		        <th>TELEPON</th>
		        <th>WEB</th>
		        <th>PROPINSI</th>
		        <th>KABUPATEN</th>
		        <th>KECAMATAN</th>
		        <th>KELURAHAN</th>
		        <th>ALAMAT</th>
		        <th>KODE POS</th>
		        <th>KELAMIN</th>
		        <th>TTL</th>
		        <th>POSTDATE</th>
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
			$usernamex = nosql($data['usernamex']);
			$passwordx = nosql($data['passwordx']);
			$nama = balikin($data['nama']);
			$email = balikin($data['email']);
			$telp = balikin($data['telp']);
			$propinsi = balikin($data['propinsi']);
			$kabupaten = balikin($data['kabupaten']);
			$kecamatan = balikin($data['kecamatan']);
			$kelurahan = balikin($data['kelurahan']);
			$alamat = balikin($data['alamat']);
			$kodepos = balikin($data['kodepos']);
			$kelamin = balikin($data['kelamin']);
			$tmp_lahir = balikin($data['tmp_lahir']);
			$tgl_lahir = balikin($data['tgl_lahir']);
			$web = balikin($data['web']);
			$postdate = balikin($data['postdate']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nama.'</td>
			<td>'.$email.'</td>
			<td>'.$telp.'</td>
			<td>'.$web.'</td>
			<td>'.$propinsi.'</td>
			<td>'.$kabupaten.'</td>
			<td>'.$kecamatan.'</td>
			<td>'.$kelurahan.'</td>
			<td>'.$alamat.'</td>
			<td>'.$kodepos.'</td>
			<td>'.$kelamin.'</td>
			<td>'.$tmp_lahir.', '.$tgl_lahir.'</td>
			<td>'.$postdate.'</td>
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