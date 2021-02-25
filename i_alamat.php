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

require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");



$id_provinsi  = nosql($_POST['id_provinsi']);
$id_kabupaten  = nosql($_POST['id_kabupaten']);
$aksi  = nosql($_GET['aksi']);



//jika aksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'detail'))
	{
	//nilai
	$propkd = cegah($_GET['propkd']);

	//jadikan session
	$_SESSION['propkd'] = $propkd;	
	
	
	$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
							"WHERE id_prov = '$propkd'");
	$row = mysqli_fetch_assoc($query);
	$d_nama = balikin($row['nama']);
	
	//echo $d_nama;
		
	}







//jika aksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'detail2'))
	{
	//nilai
	$kabkd = cegah($_GET['kabkd']);
	
	//jadikan session
	$_SESSION['kabkd'] = $kabkd;
	
	
	$query = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
							"WHERE id_kab = '$kabkd'");
	$row = mysqli_fetch_assoc($query);
	$d_nama = balikin($row['nama']);
	
	//echo $d_nama;
		
	}









//jika aksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'detail3'))
	{
	//nilai
	$keckd = cegah($_GET['keckd']);
	
	//jadikan session
	$_SESSION['keckd'] = $keckd;
	
	
	$query = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
							"WHERE id_kec = '$keckd'");
	$row = mysqli_fetch_assoc($query);
	$d_nama = balikin($row['nama']);
	
	//echo $d_nama;
		
	}







//jika aksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'detail4'))
	{
	//nilai
	$notakd = balikin($_SESSION['notakd']);
	$propkd = balikin($_SESSION['propkd']);
	$kabkd = balikin($_SESSION['kabkd']);
	$keckd = balikin($_SESSION['keckd']);
	
	
	//asal
	$query = mysqli_query($koneksi, "SELECT * FROM m_profil");
	$row = mysqli_fetch_assoc($query);
	$r_propkd = nosql($row['propinsi']);
	$r_kabkd = nosql($row['kabupaten']);
	$r_keckd = nosql($row['kecamatan']);

	//detail	
	$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
							"WHERE id_prov = '$r_propkd'");
	$row = mysqli_fetch_assoc($query);
	$d_propinsi = balikin($row['nama']);
	$_SESSION['asal_propinsi'] = $d_propinsi;


	$query = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
							"WHERE id_kab = '$r_kabkd'");
	$row = mysqli_fetch_assoc($query);
	$d_kabupaten_ongkir_jne_yes = nosql($row['ongkir_jne_yes']);
	$d_kabupaten_ongkir_jne_reg = nosql($row['ongkir_jne_reg']);
	$d_kabupaten_ongkir_pos_express = nosql($row['ongkir_pos_express']);
	$d_kabupaten_ongkir_pos_kilat = nosql($row['ongkir_pos_kilat']);
	$d_kabupaten_ongkir_jnt_reg = nosql($row['ongkir_jnt_reg']);
	$d_kabupaten_ongkir_tiki_reg = nosql($row['ongkir_tiki_reg']);
	$d_kabupaten = balikin($row['nama']);
	$_SESSION['asal_kabupaten'] = $d_kabupaten;


	$query = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
							"WHERE id_kec = '$r_keckd'");
	$row = mysqli_fetch_assoc($query);
	$d_kecamatan_ongkir_jne_yes = nosql($row['ongkir_jne_yes']);
	$d_kecamatan_ongkir_jne_reg = nosql($row['ongkir_jne_reg']);
	$d_kecamatan_ongkir_pos_express = nosql($row['ongkir_pos_express']);
	$d_kecamatan_ongkir_pos_kilat = nosql($row['ongkir_pos_kilat']);
	$d_kecamatan_ongkir_jnt_reg = nosql($row['ongkir_jnt_reg']);
	$d_kecamatan_ongkir_tiki_reg = nosql($row['ongkir_tiki_reg']);
	$d_kecamatan = balikin($row['nama']);
	$_SESSION['asal_kecamatan'] = $d_kecamatan;
	




	
	//tujuan
	$query = mysqli_query($koneksi, "SELECT * FROM provinsi ".
							"WHERE id_prov = '$propkd'");
	$row = mysqli_fetch_assoc($query);
	$t_propinsi = balikin($row['nama']);
	$_SESSION['tujuan_propinsi'] = $t_propinsi;
	$_SESSION['tujuan_propkd'] = $propkd;
	
	
	
	$query = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
							"WHERE id_kab = '$kabkd'");
	$row = mysqli_fetch_assoc($query);
	$t_kabupaten_ongkir_jne_yes = nosql($row['ongkir_jne_yes']);
	$t_kabupaten_ongkir_jne_reg = nosql($row['ongkir_jne_reg']);
	$t_kabupaten_ongkir_pos_express = nosql($row['ongkir_pos_express']);
	$t_kabupaten_ongkir_pos_kilat = nosql($row['ongkir_pos_kilat']);
	$t_kabupaten_ongkir_jnt_reg = nosql($row['ongkir_jnt_reg']);
	$t_kabupaten_ongkir_tiki_reg = nosql($row['ongkir_tiki_reg']);
	$t_kabupaten = balikin($row['nama']);
	$_SESSION['tujuan_kabupaten'] = $t_kabupaten;
	$_SESSION['tujuan_kabkd'] = $kabkd;

	$query = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
							"WHERE id_kec = '$keckd'");
	$row = mysqli_fetch_assoc($query);
	$t_kecamatan_ongkir_jne_yes = nosql($row['ongkir_jne_yes']);
	$t_kecamatan_ongkir_jne_reg = nosql($row['ongkir_jne_reg']);
	$t_kecamatan_ongkir_pos_express = nosql($row['ongkir_pos_express']);
	$t_kecamatan_ongkir_pos_kilat = nosql($row['ongkir_pos_kilat']);
	$t_kecamatan_ongkir_jnt_reg = nosql($row['ongkir_jnt_reg']);
	$t_kecamatan_ongkir_tiki_reg = nosql($row['ongkir_tiki_reg']);
	$t_kecamatan = balikin($row['nama']);
	$_SESSION['tujuan_kecamatan'] = $t_kecamatan;
	$_SESSION['tujuan_keckd'] = $keckd;




	//update nota
	mysqli_query($koneksi, "UPDATE member_order SET penerima_propinsi = '$t_propinsi', ".
					"penerima_kabupaten = '$t_kabupaten', ".
					"penerima_kecamatan = '$t_kecamatan' ".
					"WHERE kd = '$notakd'");
	
	



	//ongkir antar propinsi		
	$query = mysqli_query($koneksi, "SELECT * FROM ongkir_propinsi ".
							"WHERE (propinsi1 = '$d_propinsi' ".
							"AND propinsi2 = '$t_propinsi') ".
							"OR (propinsi2 = '$d_propinsi' ".
							"AND propinsi1 = '$t_propinsi')");
	$row = mysqli_fetch_assoc($query);
	$p_ongkir_jne_yes = nosql($row['ongkir_jne_yes']);
	$p_ongkir_jne_reg = nosql($row['ongkir_jne_reg']);
	$p_ongkir_pos_express = nosql($row['ongkir_pos_express']);
	$p_ongkir_pos_kilat = nosql($row['ongkir_pos_kilat']);
	$p_ongkir_jnt_reg = nosql($row['ongkir_jnt_reg']);
	$p_ongkir_tiki_reg = nosql($row['ongkir_tiki_reg']);




	$ongkir_jne_yes = $p_ongkir_jne_yes + $d_kabupaten_ongkir_jne_yes + $t_kabupaten_ongkir_jne_yes + $d_kecamatan_ongkir_jne_yes + $t_kecamatan_ongkir_jne_yes;
	$ongkir_jne_reg = $p_ongkir_jne_reg + $d_kabupaten_ongkir_jne_reg + $t_kabupaten_ongkir_jne_reg + $d_kecamatan_ongkir_jne_reg + $t_kecamatan_ongkir_jne_reg;
	$ongkir_pos_express = $p_ongkir_pos_express + $d_kabupaten_ongkir_pos_express + $t_kabupaten_ongkir_pos_express + $d_kecamatan_ongkir_pos_express + $t_kecamatan_ongkir_pos_express;
	$ongkir_pos_kilat = $p_ongkir_pos_kilat + $d_kabupaten_ongkir_pos_kilat + $t_kabupaten_ongkir_pos_kilat + $d_kecamatan_ongkir_pos_kilat + $t_kecamatan_ongkir_pos_kilat;
	$ongkir_jnt_reg = $p_ongkir_jnt_reg + $d_kabupaten_ongkir_jnt_reg + $t_kabupaten_ongkir_jnt_reg + $d_kecamatan_ongkir_jnt_reg + $t_kecamatan_ongkir_jnt_reg;
	$ongkir_tiki_reg = $p_ongkir_tiki_reg + $d_kabupaten_ongkir_tiki_reg + $t_kabupaten_ongkir_tiki_reg + $d_kecamatan_ongkir_tiki_reg + $t_kecamatan_ongkir_tiki_reg;
	
	
	



	
	
	//jika gak ada, gunakan dari rumus
	//masukkan ke database
	$qcc = mysqli_query($koneksi, "SELECT * FROM ongkir_kota ".
						"WHERE propinsi1 = '$d_propinsi' ".
						"AND propinsi2 = '$t_propinsi' ".
						"AND kota1 = '$d_kabupaten' ".
						"AND kota2 = '$t_kabupaten'");
	$tcc = mysqli_num_rows($qcc);
	
	//jika null, insert
	if (empty($tcc))
		{
		//query
		mysqli_query($koneksi, "INSERT INTO ongkir_kota(propinsi1, propinsi2, kota1, kota2, ".
						"ongkir_jne_yes, ongkir_jne_reg, ".
						"ongkir_pos_express, ongkir_pos_kilat, ".
						"ongkir_jnt_reg, ongkir_tiki_reg, postdate) VALUES ".
						"('$d_propinsi', '$t_propinsi', '$d_kabupaten', '$t_kabupaten', ".
						"'$ongkir_jne_yes', '$ongkir_jne_reg', ".
						"'$ongkir_pos_express', '$ongkir_pos_kilat', ".
						"'$ongkir_jnt_reg', '$ongkir_tiki_reg', '$today'");
		}		

	
	/*
	echo "<p>
	1.$ongkir_jne_yes
	<br> 
	2. $ongkir_jne_reg
	<br>
	3. $ongkir_pos_express
	<br>
	4. $ongkir_pos_kilat
	<br>
	5. $ongkir_jnt_reg
	<br>
	6. $ongkir_tiki_reg
	</p>";
	 * 
	 */

	 
		 
	?>
	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
		
		$('#f_jasakirim').change(function() { 
		     var f_jasakirim = $(this).val(); 

			$("#f_simpan").load("i_alamat.php?aksi=simpan&nilai="+f_jasakirim);
			$("#f_total").load("i_alamat.php?aksi=total");
		    });
		    
		    
		    
		    
	
	
			
	});
	
	</script>
		
	
	<?php
		 
	 
	echo '<div id="f_simpan"></div>
	<p>
	Jasa Kirim :
	<br>
	<select name="f_jasakirim" id="f_jasakirim" class="btn btn-info">
		<option value="'.$f_jasakirim.'">'.$f_jasakirim.'</option>';

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
				if ($r_nama == "JNE YES")
					{
					$ongkirku = $ongkir_jne_yes;
					$kdku = "JNEYESX$ongkirku"; 
					}
				
				//besarnya ongkos kirim
				else if ($r_nama == "JNE REG")
					{
					$ongkirku = $ongkir_jne_reg;
					$kdku = "JNEREGX$ongkirku"; 
					}
				
				//besarnya ongkos kirim
				else if ($r_nama == "POS EXPRESS")
					{
					$ongkirku = $ongkir_pos_express;
					$kdku = "POSEXPRESSX$ongkirku"; 
					}
					
				//besarnya ongkos kirim
				else if ($r_nama == "POS KILAT KHUSUS")
					{
					$ongkirku = $ongkir_pos_kilat;
					$kdku = "POSKILATKHUSUSX$ongkirku"; 
					}
					
				//besarnya ongkos kirim
				else if ($r_nama == "JNT REG")
					{
					$ongkirku = $ongkir_jnt_reg; 
					$kdku = "JNTREGX$ongkirku";
					}
					
				//besarnya ongkos kirim
				else if ($r_nama == "TIKI REG")
					{
					$ongkirku = $ongkir_tiki_reg;
					$kdku = "TIKIREGX$ongkirku"; 
					}
				
				
				
				
				
				
                echo '<option value="'.$kdku.'">'.$r_nama.' ['.xduit2($ongkirku).'/Kg]</option>';
				}
			while ($row = mysqli_fetch_assoc($query));


	echo '</select>
	</p>
	
	
	<div id="f_total"></id>';

	 
	 
	 
	 
	 
	exit();
	}















//jika aksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//nilai
	$propkd = balikin($_SESSION['propkd']);
	$keckd = balikin($_SESSION['keckd']);
	$notakd = balikin($_SESSION['notakd']);
	$tujuan_propkd = balikin($_SESSION['tujuan_propkd']);
	$tujuan_kabkd = balikin($_SESSION['tujuan_kabkd']);
	$tujuan_keckd = balikin($_SESSION['tujuan_keckd']);
	$tujuan_propinsi = balikin($_SESSION['tujuan_propinsi']);
	$tujuan_kabupaten = balikin($_SESSION['tujuan_kabupaten']);
	$tujuan_kecamatan = balikin($_SESSION['tujuan_kecamatan']);
	$nilai = cegah($_GET['nilai']);
	
	

	//ketahui total berat
	$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE kd = '$notakd'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$yuk_berat1 = nosql($ryuk['barang_berat']);
	$yuk_subtotal = nosql($ryuk['subtotal']);
	$yuk_kodeunik = nosql($ryuk['kodeunik']);
	
	//jadikan kilogram
	$yuk_berat = round($yuk_berat1 / 1000);
	
	
	

	
	//pecah
	$pecahku = explode("X", $nilai);
	$e_jasakirim = trim($pecahku[0]);
	$e_ongkirnya = trim($pecahku[1]);
	
	//total ongkir
	$e_subtotal = round($e_ongkirnya * $yuk_berat); 


	//total bayar
	$e_total_bayar = $yuk_subtotal + $e_subtotal + $yuk_kodeunik;
	
	
	//update
	mysqli_query($koneksi, "UPDATE member_order SET jasakirim = '$e_jasakirim', ".
					"jasakirim_ongkir = '$e_ongkirnya', ".
					"jasakirim_ongkir_subtotal = '$e_subtotal', ".
					"total = '$e_total_bayar' ".
					"WHERE kd = '$notakd'");		

	
	



	exit();
	}














//jika aksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'total'))
	{
	//nilai
	$propkd = balikin($_SESSION['propkd']);
	$keckd = balikin($_SESSION['keckd']);
	$notakd = balikin($_SESSION['notakd']);
	$tujuan_propkd = balikin($_SESSION['tujuan_propkd']);
	$tujuan_kabkd = balikin($_SESSION['tujuan_kabkd']);
	$tujuan_keckd = balikin($_SESSION['tujuan_keckd']);
	$tujuan_propinsi = balikin($_SESSION['tujuan_propinsi']);
	$tujuan_kabupaten = balikin($_SESSION['tujuan_kabupaten']);
	$tujuan_kecamatan = balikin($_SESSION['tujuan_kecamatan']);


	//ketahui rincian
	$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE kd = '$notakd'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$yuk_subtotal = nosql($ryuk['subtotal']);
	$yuk_jasakirim = balikin($ryuk['jasakirim']);
	$yuk_ongkirnya = nosql($ryuk['jasakirim_ongkir_subtotal']);
	$yuk_kodeunik = nosql($ryuk['kodeunik']);
	$yuk_total = nosql($ryuk['total']);
	
	
	echo '<h3>
	Total Transfer : 
	<br>
	<b>'.xduit2($yuk_total).'</b>
	</h3>';



	exit();
	}























if(isset($_POST["id_provinsi"]) && !empty($_POST["id_provinsi"]))
	{
	echo '<option value="" selected></option>';
	
	$qku = mysqli_query($koneksi, "SELECT * FROM kabupaten ".
							"WHERE id_prov = '$id_provinsi' ".
  							"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);

	do
		{
		$ku_idkab = nosql($rku['id_kab']);
		$ku_nama = balikin($rku['nama']);

		echo '<option value="'.$ku_idkab.'">'.$ku_nama.'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));

	
	exit();
  	}




if(isset($_POST["id_kabupaten"]) && !empty($_POST["id_kabupaten"]))
	{
	echo '<option value="" selected></option>';
	
	$qku = mysqli_query($koneksi, "SELECT * FROM kecamatan ".
							"WHERE id_kab = '$id_kabupaten' ".
  							"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);

	do
		{
		$ku_idkec = nosql($rku['id_kec']);
		$ku_nama = balikin($rku['nama']);

		echo '<option value="'.$ku_idkec.'">'.$ku_nama.'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	exit();
  	}




exit();
?>