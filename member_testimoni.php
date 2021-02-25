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


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("template/$temaku/cp_config.php");
$tpl = LoadTpl("template/$temaku/cp_member_testimoni.php");



nocache;

//nilai
$filenya = "member_testimoni.php";
$judul = "Testimoni";
$judulku = $judul;
$sesikd = nosql($_SESSION['kd6_session']);
$sesinama = cegah($_SESSION['nama6_session']);
$s = nosql($_REQUEST['s']);
$notakd = nosql($_REQUEST['notakd']);




//proses /////////////////////////////////////////////////////////////////////////////////////////////

//proses /////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();


require("i_info.php");

//isi
$iinfo = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();


require("i_headline2.php");

//isi
$iheadline = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_random.php");

//isi
$irandom = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


require("i_member_menu.php");



//jika null
if (empty($kd6_session))
	{
	//re-direct
	$ke = "$sumber/login.php";
	xloc($ke);
	exit();	
	}
	

//isi
$member_menu = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();







echo '<form name="formx" id="formx" action="'.$filenya.'" enctype="multipart/form-data" method="post">';



//query
$q = mysqli_query($koneksi, "SELECT * FROM member_testimoni ".
					"WHERE member_kd = '$sesikd' ".
					"ORDER BY postdate DESC");
$row = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);

if (!empty($total))
	{
	?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php


echo '<div class="table-responsive">          
	  <table class="table" border="1">
	    <thead>
		<tr bgcolor="'.$warnaheader.'">
      <th>POSTDATE</th>
      <th>TESTIMONI</th>
      <th>ITEM</th>
    </tr>
	    </thead>
	    <tbody>';



do 
	{
	$r_kd = nosql($row['kd']);
	$r_postdate = balikin($row['postdate']);
	$r_isi = balikin($row['isi']);
	$r_item_kd = nosql($row['item_kd']);
	$r_item_nama = balikin($row['item_nama']);
	$i_kualitas_no = nosql($row['nilai_kualitas_no']);
	$i_manfaat_no = nosql($row['nilai_manfaat_no']);
	$i_kualitas = balikin($row['nilai_kualitas']);
	$i_manfaat = balikin($row['nilai_manfaat']);


	$url_cantik = trim(seo_friendly_url($e_nama));
			
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

		


		

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$r_postdate.'</td>
		<td>';
					
			for ($k=1;$k<=$i_kualitas_no;$k++)
				{
				echo '<img src="template/img/bintang.png" width="16">';
				}
			
			
			echo ' [Kualitas : '.$i_kualitas.'].
			<br>';
			
			
			for ($k=1;$k<=$i_manfaat_no;$k++)
				{
				echo '<img src="template/img/bintang.png" width="16">';
				}
			
			echo ' [Manfaat : '.$i_manfaat.'].
			<br>
			<br>
		
		'.$r_isi.'
		</td>
		<td>
		<a href="'.$sumber.'/item.php?'.$url_cantik.'&itemkd='.$r_item_kd.'" title="'.$r_item_nama.'">
		'.$r_item_nama.'
		</a>
		</td>
        </tr>';
		}
	while ($row = mysqli_fetch_assoc($q));

	echo '</tbody>
	  </table>
	  </div>';
	}
	
else
	{
	echo "<font color=red>
	<h3>BELUM ADA TESTIMONI</h3>
	</font>";
	}

	
echo '</form>';




//isi
$isi = ob_get_contents();
ob_end_clean();










require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>