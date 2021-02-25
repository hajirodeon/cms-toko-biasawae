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




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika cari
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'cari'))
	{
	//ambil nilai
	$kunci = seo_friendly_url(cegah($_GET['kunci']));


	?>


	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){

			window.location.href = "cari.php?kunci=<?php echo $kunci;?>";

	
	});
	
	</script>
	

	<?php
	exit();
	}

















	
exit();
?>