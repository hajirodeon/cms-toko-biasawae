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
$filenya = "newsletter.php";
$filenyax = "i_newsletter_kirim.php";
$judul = "Data NEWSLETTER";
$judulku = "[NEWSLETTER]. $judul";
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
	
	







//isi *START
ob_start();




//js


echo '<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">';
?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  


<script language='javascript'>
//membuat document jquery
$(document).ready(function(){


	$("#btnMASSAL").on('click', function(){
		$('#loading').show();
		
		$("#formx21").submit(function(){
			$.ajax({
				url: "<?php echo $filenyax;?>?aksi=simpan",
				type:$(this).attr("method"),
				data:$(this).serialize(),
				success:function(data){					
					$("#ihasil2").html(data);
					setTimeout('$("#loading").hide()',5000);
					}
				});
			return false;
		});
	});	





		
});

</script>

	
	



<?php
echo '<form name="formx21" id="formx21">
<input name="btnMASSAL" id="btnMASSAL" type="submit" value="KIRIM EMAIL MASSAL >> " class="btn btn-danger">
<br>
<div id="ihasil2"></div>

<div id="loading" style="display:none">
<img src="'.$sumber.'/template/img/progress-bar.gif" width="100" height="16">
</div>

</form>


<hr>


NB. Yang dikirimkan massal ke email, adalah berita info terakhir.
<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">';



//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM m_member ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<div class="table-responsive">          
		  <table class="table" border="1">
		    <thead>
				
	<tr bgcolor="'.$warnaheader.'">
	<td><strong><font color="'.$warnatext.'">E-Mail</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
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
		$i_email = balikin($data['email']);
		$i_nama = balikin($data['nama']);





		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_email.'</td>
		<td>'.$i_nama.'</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</tbody>
		  </table>
		  </div>
	

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
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