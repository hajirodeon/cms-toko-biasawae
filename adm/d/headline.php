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
$filenya = "headline.php";
$judul = "Data Produk Unggulan";
$judulku = "[DATA MASTER]. $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$hkd = nosql($_REQUEST['hkd']);
$artkd = nosql($_REQUEST['artkd']);







//jadikan headline
if ($s == "ganti")
	{
	//netralkan dulu...
	mysqli_query($koneksi, "UPDATE m_item SET headline_no = '' ".
					"WHERE headline_no = '$hkd'");
	
	
	//update
	mysqli_query($koneksi, "UPDATE m_item SET headline_no = '$hkd' ".
					"WHERE kd = '$artkd'");
					
					
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


echo '<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">



<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">';


//jika ganti headline
if (!empty($hkd))
	{
	//daftar 
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_item ".
					"ORDER BY postdate DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?hkd=$hkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	if ($count != 0)
		{
		//view data
		echo '<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
			
		<tr bgcolor="'.$warnaheader.'">
		<td width="200"><strong><font color="'.$warnatext.'">IMAGE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">JUDUL</font></strong></td>
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
			$i_kd = nosql($data['kd']);
			$i_judul = balikin($data['nama']);
			$i_filex = balikin($data['filex1']);
			$i_postdate = $data['postdate'];


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<img src="../../filebox/item/'.$i_kd.'/'.$i_filex.'" width="200" height="200">
			</td>
			<td>
			'.$i_judul.'
			<br>
			<br>
			<br>
			
			[<a href="'.$filenya.'?s=ganti&artkd='.$i_kd.'&hkd='.$hkd.'">JADIKAN HEADLINE #'.$hkd.'</a>]
			</td>
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
		</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>BELUM ADA DATA.</strong>
		</font>
		</p>';
		}
	
	}

else
	{
	//looping headline
	for($k=1;$k<=6;$k++)
		{
		echo "<h4>#$k</h4>";
		
		
		//detail artikelnya
		$qku = mysqli_query($koneksi, "SELECT * FROM m_item ".
								"WHERE headline_no = '$k'");
		$rku = mysqli_fetch_assoc($qku);
		$tku = mysqli_num_rows($qku);
		
		//jika ada
		if (!empty($tku))
			{
			$ku_kd = nosql($rku['kd']);	
			$ku_judul = balikin($rku['nama']);
			$ku_filex = balikin($rku['filex1']);
			
			
			echo '<div class="table-responsive">          
		  <table class="table">
		    <thead>
			
			<tr>
			<td width="60">
			<img src="../../filebox/item/'.$ku_kd.'/'.$ku_filex.'" width="50" height="50">
			</td>
			<td>
			<b>'.$ku_judul.'</b>
			</td>
			</tr>
			
			</tbody>
		  </table>
		  </div>
		  ';
			}	



	
		echo '[<a href="'.$filenya.'?hkd='.$k.'">GANTI</a>].
		<hr>';
		}
		
	}	
	

echo '</form>


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