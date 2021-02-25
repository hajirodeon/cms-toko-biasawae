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
$tpl = LoadTpl("template/$temaku/cp_member_troli.php");



nocache;

//nilai
$filenya = "member_troli.php";
$judul = "Troli Belanja";
$judulku = $judul;
$notakd = nosql($_SESSION['notakd']);
$sesikd = nosql($_SESSION['kd6_session']);





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









echo '<form name="formx" id="formx">';

?>



<script>
$(document).ready(function(){


	$("#irincian").load("i_member_troli.php?aksi=rincian&sesikd=<?php echo $kd6_session;?>");





	$("#btnOK1").on('click', function(){
			window.location.href = "<?php echo $sumber;?>";
	
	});	


	$("#btnOK2").on('click', function(){
			window.location.href = "member_selesai.php?notakd=<?php echo $notakd;?>";
	
	});	





	<?php
	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd' ".
						"ORDER BY item_nama ASC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);


	do
	    {
		$r_kd = nosql($row['kd']);
		$r_itemkd = nosql($row['item_kd']);
		?>		
	
		$('#hapus<?php echo $r_kd;?>').click(function () {
			$("#loading").show();
			$("#loading").load("i_member_troli.php?aksi=hapus&sesikd=<?php echo $kd6_session;?>&detailkd=<?php echo $r_kd;?>");
			$("#loading").hide();
	
			});
	
	
	
	
			
		$('#jmlku<?php echo $r_kd;?>').change(function() { 
		    var jmlku = $(this).val();

			$("#loading").show();
			$("#loading").load("i_member_troli.php?aksi=simpan&sesikd=<?php echo $kd6_session;?>&detailkd=<?php echo $r_kd;?>&itemkd=<?php echo $r_itemkd;?>&jmlku="+jmlku);
			$("#subtotal<?php echo $r_kd;?>").load("i_member_troli.php?aksi=subtotal&sesikd=<?php echo $kd6_session;?>&detailkd=<?php echo $r_kd;?>&itemkd=<?php echo $r_itemkd;?>");
			$("#itotal").load("i_member_troli.php?aksi=total&sesikd=<?php echo $kd6_session;?>&notakd=<?php echo $notakd;?>");
			$("#irincian").load("i_member_troli.php?aksi=rincian&sesikd=<?php echo $kd6_session;?>");
			$("#loading").hide();
		    });
		 

		<?php
	
	    }
	while ($row = mysqli_fetch_assoc($q));
	?>
	
	

	
	});

</script>
	


<?php
//query
$q = mysqli_query($koneksi, "SELECT * FROM member_order ".
					"WHERE member_kd = '$sesikd' ".
					"AND kd = '$notakd' ".
					"AND penerima_nama = ''");
$row = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);

if (!empty($total))
	{
	//query
	$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd' ".
						"ORDER BY item_nama ASC");
	$row = mysqli_fetch_assoc($q);


	//update total
	$q2 = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total ".
						"FROM member_order_detail ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd'");
	$row2 = mysqli_fetch_assoc($q2);
	$totalnya2 = nosql($row2['total']);
	$totalnyax2 = xduit2($totalnya2);


	
	echo '<h3>TOTAL : <div id="itotal">
	<b>'.$totalnyax2.'</b>
	</div>
	</h3>
		


	<p>
	<div id="irincian"></div>
	</p>
	<p>
	<input name="btnOK1" id="btnOK1" type="button" value="LANJUT BELANJA" class="btn btn-success">
	<input name="btnOK2" id="btnOK2" type="button" value="SELESAI >>" class="btn btn-danger">
	</p>';
	
			


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
          <th>FOTO</th>
          <th>NAMA</th>
          <th>KONDISI</th>
          <th>BERAT</th>
          <th>HARGA</th>
          <th>JUMLAH</th>
          <th>SUBTOTAL</th>
          <th>#</th>
        </tr>
		    </thead>
		    <tbody>';



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
			$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
									"WHERE kd = '$r_itemkd'");
			$rtyk = mysqli_fetch_assoc($qtyk);
			$e_kd = nosql($rtyk['kd']);
			$e_nama = balikin($rtyk['nama']);
			$e_url_cantik = balikin($rtyk['url_cantik']);
			$e_harga = nosql($rtyk['harga']);
			$e_jml = nosql($rtyk['jml']);

			$url_cantik = trim(seo_friendly_url($e_nama));
			
			
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td width="150">
			<a href="'.$sumber.'/item.php?'.$url_cantik.'&itemkd='.$e_kd.'" title="'.$e_nama.'">
			<img src="'.$sumber.'/filebox/item/'.$r_itemkd.'/'.$r_filex.'" width="150">
			</a>
			</td>
			<td>
			<a href="'.$sumber.'/item.php?'.$url_cantik.'&itemkd='.$e_kd.'" title="'.$e_nama.'">
			'.$r_nama.'
			</a>
			</td>
			<td>'.$r_kondisi.'</td>
			<td>'.$r_berat.' gram</td>
			<td width="150" align="right">'.xduit2($r_harga).'</td>
			<td width="50">

			<select name="jmlku'.$r_kd.'" id="jmlku'.$r_kd.'" class="btn btn-info">
				<option value="'.$r_qty.'" selected>'.$r_qty.'</option>';
				

				for ($k=1;$k<=$e_jml;$k++)
					{
					echo '<option value="'.$k.'">'.$k.'</option>';
					}

	
			echo '</select>

			
			</td>
			<td width="150" align="right">
			
			<div id="subtotal'.$r_kd.'">
			'.xduit2($r_subtotal).'
			</div>
			
			</td>
			<td width="50">
			<div id="hapus'.$r_kd.'"><input name="btnHPS" id="btnHPS" type="button" value="HAPUS" class="btn btn-danger"></div>
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
		<h3>TROLI BELANJA MASIH KOSONG</h3>
		</font>";
		}		



	echo '</td>
	</tr>
	</table>
	
	
	</form>';




//isi
$isi = ob_get_contents();
ob_end_clean();










require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>