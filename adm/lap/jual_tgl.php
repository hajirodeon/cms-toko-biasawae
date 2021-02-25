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
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "jual_tgl.php";
$judul = "[LAPORAN] Penjualan per Tanggal";
$judulku = "$judul";
$judulx = $judul;


$xtgl1 = balikin($_REQUEST['xtgl1']);
$xtgl2 = balikin($_REQUEST['xtgl2']);



//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
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
	$xtgl1 = balikin($_POST['e_tgl1']);
	$xtgl2 = balikin($_POST['e_tgl2']);

	
	//re-direct
	$ke = "$filenya?xtgl1=$xtgl1&xtgl2=$xtgl2";
	xloc($ke);
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

?>

<script language='javascript'>
//membuat document jquery
$(document).ready(function(){


    $('#e_tgl1').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
    })
    

    $('#e_tgl2').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
    })
    
		
});

</script>
	

<?php


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$e_tgl1x = $xtgl1;
$e_tgl2x = $xtgl2;

//buat sesi
$_SESSION['e_tgl1x'] = $e_tgl1x;
$_SESSION['e_tgl2x'] = $e_tgl2x;



//jika null
if (empty($e_tgl1x))
	{
	$e_tgl1x = "$tanggal/$bulan/$tahun";
	}

	
//jika null
if (empty($e_tgl2x))
	{
	$e_tgl2x = "$tanggal/$bulan/$tahun";
	}





echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>



<input name="e_tgl1" id="e_tgl1" type="text" size="10" value="'.$e_tgl1x.'" class="btn btn-info">

Sampai 

<input name="e_tgl2" id="e_tgl2" type="text" size="10" value="'.$e_tgl2x.'" class="btn btn-info">


<input name="btnCARI" type="submit" class="btn btn-danger" value="CARI >>">
<input name="btnRST" type="submit" class="btn btn-primary" value="RESET">
</td>
</tr>
</table>';




//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//pecah
$pecahku = explode("/", $e_tgl1x);
$pecahku1 = $pecahku[0];
$pecahku2 = $pecahku[1];
$pecahku3 = $pecahku[2];
$begin = new DateTime("$pecahku3-$pecahku2-$pecahku1");



//pecah
$pecahku = explode("/", $e_tgl2x);
$pecahku1 = $pecahku[0];
$pecahku2 = $pecahku[1];
$pecahku3 = $pecahku[2];
$end = new DateTime("$pecahku3-$pecahku2-$pecahku1");


$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);





//view data				  
echo '<div class="table-responsive">          
  <table class="table" border="1">
    <thead>
		<tr bgcolor="'.$warnaheader.'">
		<th>TANGGAL</th>
        <th>JUMLAH TRANSAKSI</th>
        <th>JUMLAH MEMBER TRANSAKSI</th>
        <th>JUMLAH ITEM TERJUAL</th>
        <th>TOTAL OMZET</th>
        <th>TOTAL ONGKIR</th>
      </tr>
    </thead>
    <tbody>';





foreach($daterange as $date)
	{
    $nilku = $date->format("Y-m-d");

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


	//jumlah transaksi
	$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
							"WHERE tgl_diterima = '$nilku'");
	$jml_transaksi = mysqli_num_rows($qyuk);
	
	if (empty($jml_transaksi))
		{
		$jml_transaksi = "";
		}
	
	
	
	//jumlah member transaksi
	$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(member_kd) AS total ".
							"FROM member_order ".
							"WHERE tgl_diterima = '$nilku'");
	$jml_member = mysqli_num_rows($qyuk);
	
	if (empty($jml_member))
		{
		$jml_member = "";
		}
		
	
	
	//jumlah item terjual
	$qyuk = mysqli_query($koneksi, "SELECT SUM(barang_qty) AS total FROM member_order ".
							"WHERE tgl_diterima = '$nilku'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$jml_qty = nosql($ryuk['total']);
		
	
	
	//omzet
	$qyuk = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total FROM member_order ".
							"WHERE tgl_diterima = '$nilku'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$jml_total = nosql($ryuk['total']);
		
		
	//ongkir
	$qyuk = mysqli_query($koneksi, "SELECT SUM(jasakirim_ongkir_subtotal) AS total ".
							"FROM member_order ".
							"WHERE tgl_diterima = '$nilku'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$jml_ongkir = nosql($ryuk['total']);

	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td width="50">'.$nilku.'</td>
	<td width="50">'.$jml_transaksi.'</td>
	<td width="50">'.$jml_member.'</td>
	<td width="50">'.$jml_qty.'</td>
	<td>'.xduit2($jml_total).'</td>
	<td>'.xduit2($jml_ongkir).'</td>
	</tr>';
	}




$e_tgl1x = $_SESSION['e_tgl1x'];
$e_tgl2x = $_SESSION['e_tgl2x'];

$pecahku = explode("/", $e_tgl1x);
$pecahku1 = $pecahku[0];
$pecahku2 = $pecahku[1];
$pecahku3 = $pecahku[2];
$tgl1 = trim("$pecahku3-$pecahku2-$pecahku1"); 

$pecahku = explode("/", $e_tgl2x);
$pecahku1 = $pecahku[0];
$pecahku2 = $pecahku[1];
$pecahku3 = $pecahku[2];
$tgl2 = trim("$pecahku3-$pecahku2-$pecahku1");






//omzet
$qyuk = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima >= '$tgl1' ".
						"AND tgl_diterima <= '$tgl2'");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_total = nosql($ryuk['total']);
	
	
//ongkir
$qyuk = mysqli_query($koneksi, "SELECT SUM(jasakirim_ongkir_subtotal) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima >= '$tgl1' ".
						"AND tgl_diterima <= '$tgl2'");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_ongkir = nosql($ryuk['total']);



echo '</tbody>
    <thead>
		<tr bgcolor="'.$warnaheader.'">
		<th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>'.xduit2($jml_total).'</th>
        <th>'.xduit2($jml_ongkir).'</th>
      </tr>
    </thead>
  </table>
  </div>




</form>
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