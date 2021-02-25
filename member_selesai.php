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
$tpl = LoadTpl("template/$temaku/cp_member_selesai.php");



nocache;

//nilai
$filenya = "member_selesai.php";
$judul = "Selesai Order";
$judulku = $judul;
$s = nosql($_REQUEST['s']);
$notakd = nosql($_SESSION['notakd']);
$sesikd = nosql($_SESSION['kd6_session']);
$sesinama = cegah($_SESSION['nama6_session']);




//proses /////////////////////////////////////////////////////////////////////////////////////////////
//hitung total transaksi
//ketahui detail sebelumnya...
$qku = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd'");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);
$ku_total_jenis = $tku;




//ketahui detail sebelumnya...
$qku2 = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total, ".
						"SUM(subtotal_berat) AS total_berat, ".
						"SUM(jumlah) AS total_qty, ".
						"nota_kode AS notaku ".
						"FROM member_order_detail ".
						"WHERE member_kd = '$sesikd' ".
						"AND nota_kd = '$notakd'");
$rku2 = mysqli_fetch_assoc($qku2);
$ku_nota_kode = nosql($rku2['notaku']);
$ku_total = nosql($rku2['total']);
$ku_total_berat = nosql($rku2['total_berat']);
$ku_total_qty = nosql($rku2['total_qty']);



//kode unik
$ku_kodeunik = rand(1,999);
$ku_totalakhir = $ku_total + $ku_kodeunik; 
$ku_kd = md5("$sesikd$ku_total_berat$ku_total_qty$ku_total_jenis$ku_total$tahun$bulan$tanggal");



//jika null
if (empty($ku_nota_kode))
	{
	//kasi nomor nota
	$ku_nota = "$tahun$bulan$tanggal$ku_kodeunik";


	
	//buat sesi
	$_SESSION['notakode'] = $ku_nota;
	
	
	
	//update ke database
	mysqli_query($koneksi, "UPDATE member_order SET member_nama = '$sesinama', ".
					"tgl_booking = '$today', ".
					"nota_kode = '$ku_nota', ".
					"barang_jml_jenis = '$ku_total_jenis', ".
					"barang_qty = '$ku_total_qty', ".
					"barang_berat = '$ku_total_berat', ".
					"subtotal = '$ku_total', ".
					"kodeunik = '$ku_kodeunik', ".
					"total = '$ku_totalakhir' ".
					"WHERE member_kd = '$sesikd' ".
					"AND kd = '$notakd'");
	
	
	mysqli_query($koneksi, "UPDATE member_order_detail SET member_nama = '$sesinama', ".
					"nota_kode = '$ku_nota' ".
					"WHERE member_kd = '$sesikd' ".
					"AND nota_kd = '$notakd'");
	
	}








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


require("template/js/number.js");


?>

<script language='javascript'>
//membuat document jquery
$(document).ready(function(){



	$("#btnKRM").on('click', function(){
		
		$("#formx2").submit(function(){
			$.ajax({
				url: "i_member_selesai.php?aksi=simpan",
				type:$(this).attr("method"),
				data:$(this).serialize(),
				success:function(data){					
					$("#ihasil").html(data);
					}
				});
			return false;
		});
	
	
	});	



			
	
	$('#provinsi').change(function() { 
	     var provinsi = $(this).val(); 
	     $.ajax({
	            type: 'POST', 
	          url: 'i_alamat.php', 
	         data: 'id_provinsi=' + provinsi, 
	         success: function(response) { 
	              $('#kabupaten').html(response);
	            }
	       });
	       
		$("#k_prop").load("i_alamat.php?aksi=detail&propkd="+provinsi);
	    });
	 
	
	
	
	$('#kabupaten').change(function() { 
	     var kabupaten = $(this).val(); 
	     $.ajax({
	            type: 'POST', 
	          url: 'i_alamat.php', 
	         data: 'id_kabupaten=' + kabupaten, 
	         success: function(response) { 
	              $('#kecamatan').html(response);
	            }
	       });
	       
		$("#k_kab").load("i_alamat.php?aksi=detail2&kabkd="+kabupaten);
		$("#k_ongkirnya").load("i_alamat.php?aksi=detail4&kabkd="+kabupaten);
	    });




	
	$('#kecamatan').change(function() { 
	     var kecamatan = $(this).val(); 

		$("#k_kec").load("i_alamat.php?aksi=detail3&keckd="+kecamatan);
		$("#k_ongkirnya").load("i_alamat.php?aksi=detail4&keckd="+kecamatan);

	    });
	    
	    
	    
	    


		
});

</script>
	

<?php
echo '<h1>'.$judul.'</h1>
<hr>';



//ketahui nota terakhir, yang belum dibayar
$qku = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE member_kd = '$sesikd' ".
						"AND kd = '$notakd'");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);
$ku_nota_kode = balikin($rku['nota_kode']);
$ku_tgl_booking = balikin($rku['tgl_booking']);
$ku_barang_jml_jenis = nosql($rku['barang_jml_jenis']);
$ku_barang_qty = nosql($rku['barang_qty']);
$ku_barang_berat = nosql($rku['barang_berat']);
$ku_subtotal = nosql($rku['subtotal']);
$ku_kodeunik = nosql($rku['kodeunik']);
$ku_total = nosql($rku['total']);



//detail pembayaran
$qku2 = mysqli_query($koneksi, "SELECT * FROM m_pembayaran");
$rku2 = mysqli_fetch_assoc($qku2);
$ku2_judul = balikin($rku2['judul']);
$ku2_isi = balikin($rku2['isi']);




//jika selesai ///////////////////////////////////////////////////////////////////////////////////////
if ($s == "selesai")
	{
	echo '<h3>
	Nomor Nota :
	<br>
	<b>'.$ku_nota_kode.'</b>
	</h3>
	
	<h3>
	Tanggal Order :
	<br>
	<b>'.$ku_tgl_booking.'</b>
	</h3>
	
	<h3>
	Total Transfer :
	<br>
	<b>
	'.xduit2($ku_total).'
	</b>	
	</h3>
	<hr>
	
	<p>
	'.$ku2_judul.'
	</p>
	<p>
	'.$ku2_isi.'
	</p>
	<hr>
	
	
	<h3>
	[<a href="member_konfirmasi.php">KONFIRMASI TRANSFER</a>].
	</h3>
	<hr>';
		
		
		
	//hapus sesi notakd
	$_SESSION['notakd'] = "";	
	}
else
	{
	//jika ada
	if (!empty($tku))
		{
		echo '<form name="formx2" id="formx2">
		<h3>
		Penerima Paket :
		</h3>
		<hr>
		
		
		<table width="100%" border="0">
		<tr valign="top">
		<td>
	
		<p>
		Nama :
		<br>
		<input name="e_nama" id="e_nama" type="text" size="30" value="'.$f_nama.'" class="btn btn-info">
		</p>
	
		<p>
		Telepon :
		<br> 
		<input name="e_telp" id="e_telp" type="text" size="20" value="'.$f_telp.'" class="btn btn-info">
		</p>
		
		
			<p>
			Propinsi : 
			<br>';			
			//Dapatkan semua 
			$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
									"ORDER BY nama ASC");
			$row = mysqli_fetch_assoc($query);
			?>
			
			<select name="provinsi" id="provinsi" class="btn btn-info">
			<option value="<?php echo $f_propinsi;?>">- <?php echo $f_propinsi;?> -</option>
			        <?php
			            do
			            	{
			            	$r_idprov = nosql($row['id_prov']);
							$r_nama = balikin($row['nama']);
							 
			                echo '<option value="'.$r_idprov.'">'.$r_nama.'</option>';
							}
						while ($row = mysqli_fetch_assoc($query));
			        ?>
			</select>
			</p>
			
			
			<p>
			Kabupaten / Kota :
			<br>
			<select name="kabupaten" id="kabupaten" class="btn btn-info">
			<option value="<?php echo $f_kabupaten;?>">- <?php echo $f_kabupaten;?> -</option>
			</select>
			</p>
					
			<p>
			Kecamatan :
			<br>
			<select name="kecamatan" id="kecamatan" class="btn btn-info">
			<option value="<?php echo $f_kecamatan;?>">- <?php echo $f_kecamatan;?> -</option>
			</select>
			</p>
		
		
			</td>
		
			<td>
		
		
			<p>
			Kelurahan :
			<br> 
			<input name="f_kelurahan" id="f_kelurahan" type="text" size="20" value="<?php echo $f_kelurahan;?>" class="btn btn-info">
			</p>
			
			<p>
			Alamat : 
			<br>
			<textarea cols="50" name="f_alamat" id="f_alamat" rows="5" class="btn btn-info"><?php echo $f_alamat;?></textarea>
			</p>
			
			<p>
			Kode Pos :
			<br> 
			<input name="f_kodepos" id="f_kodepos" type="text" size="5" value="<?php echo $f_kodepos;?>" onKeyPress="return numbersonly(this, event)" class="btn btn-info">
			</p>
	
			<p>
			Catatan untuk Penjual :
			<br>
			<input name="f_catatan" id="f_catatan" type="text" size="30" value="<?php echo $f_catatan;?>" class="btn btn-info">
			</p>
			
		
		
		
		</td>
	
	
		<td width="300">
		
		<?php
		echo '<h3>
		NO.NOTA : 
		<br>
		<b>'.$ku_nota_kode.'</b>
		</h3>
		
		<h3>
		Jumlah Jenis Item : 
		<br>
		<b>'.$ku_barang_jml_jenis.'</b>
		</h3>
		
		<h3>
		Jumlah Qty Item : 
		<br>
		<b>'.$ku_barang_qty.'</b>
		</h3>
		
		<h3>
		Berat dalam Paket : 
		<br>
		<b>'.$ku_barang_berat.' Gram</b>
		</h3>
		
		
		<h3>
		Kode Unik : 
		<br>
		<b>'.$ku_kodeunik.'</b>
		</h3>';
		?>
		
		</td>
		
		
		</tr>
		</table>
	
	
		<hr>
		<div id="k_prop"></div>	
		<div id="k_kab"></div>
		<div id="k_kec"></div>
		<div id="f_simpan"></div>
		<div id="k_ongkirnya">
		<p>
			Jasa Kirim :
			<br> 
			<select name="f_jasakirim2" id="f_jasakirim2" class="btn btn-info">
			<option value="<?php echo $f_jasakirim;?>">- <?php echo $f_jasakirim;?> -</option>
			        <?php
						//Dapatkan semua 
						$query = mysqli_query($koneksi, "SELECT * FROM m_jasa_kirim ".
												"WHERE status = 'true' ".
												"ORDER BY nama ASC");
						$row = mysqli_fetch_assoc($query);
			
			            do
			            	{
			            	$r_kd = nosql($row['kd']);
							$r_nama = balikin($row['nama']);
							
							
							//besarnya ongkos kirim
							
							
							
			                echo '<option value="'.$r_kd.'">'.$r_nama.' []</option>';
							}
						while ($row = mysqli_fetch_assoc($query));
			        ?>
			</select>
			</p>
		</div>
	
		
		<hr>				
			<p>
			<input name="btnKRM" id="btnKRM" type="submit" class="btn btn-danger" value="KIRIM >>">
			</p>
		
		<hr>
	
	
	
		<?php
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
							"WHERE member_kd = '$sesikd' ".
							"AND nota_kd = '$notakd' ".
							"ORDER BY item_nama ASC");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);
			
	
	
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
				$e_jml = nosql($rtyk['jml']);
				
		
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td width="150">
				<img src="'.$sumber.'/filebox/item/'.$r_itemkd.'/'.$r_filex.'" width="150">
				</td>
				<td>'.$r_nama.'</td>
				<td>'.$r_kondisi.'</td>
				<td width="100" >'.$r_berat.' gram</td>
				<td width="150" align="right">'.xduit2($r_harga).'</td>
				<td width="50">'.$r_qty.'</td>
				<td width="150" align="right">'.xduit2($r_subtotal).'</td>
		        </tr>';
				}
			while ($row = mysqli_fetch_assoc($q));
	
			echo '</tbody>
			  </table>
			  </div>';
		}
		
	else
		{
		echo '<font color=red>
		<h3>Maaf, Silahkan Belanja Dahulu...</h3>
		</font>';
		}
	
	
	
	echo '</form>
	
	
		<div id="ihasil"></div>';
	}




//isi
$isi = ob_get_contents();
ob_end_clean();










require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>