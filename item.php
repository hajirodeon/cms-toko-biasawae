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
$tpl = LoadTpl("template/$temaku/cp_item.php");



nocache;

//nilai
$filenya = "item.php";
$filenya_ke = $sumber;
$itemkd = nosql($_REQUEST['itemkd']);
$notakd = nosql($_SESSION['notakd']);
$ke = "$sumber/$filenya?itemkd=$itemkd";


//jika null, bikin sesi
if (empty($notakd))
	{
	$_SESSION['notakd'] = $x;
	
	$notakd = nosql($_SESSION['notakd']);
	}
	
	
	

//detail e
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"WHERE kd = '$itemkd'");
$rtyk = mysqli_fetch_assoc($qtyk);
$nomer = $nomer + 1;
$e_kd = nosql($rtyk['kd']);
$e_nama = balikin($rtyk['nama']);
$e_isi = balikin($rtyk['isi']);
$e_harga = nosql($rtyk['harga']);
$e_jml = nosql($rtyk['jml']);
$filex1 = balikin($rtyk['filex1']);
$filex2 = balikin($rtyk['filex2']);
$filex3 = balikin($rtyk['filex3']);
$filex4 = balikin($rtyk['filex4']);
$filex5 = balikin($rtyk['filex5']);

$judul = $e_nama;
$judulku = "DETAIL ITEM : $judul";


$e_filex1 = "$sumber/filebox/item/$e_kd/$filex1";
$e_filex2 = "$sumber/filebox/item/$e_kd/$filex2";
$e_filex3 = "$sumber/filebox/item/$e_kd/$filex3";
$e_filex4 = "$sumber/filebox/item/$e_kd/$filex4";
$e_filex5 = "$sumber/filebox/item/$e_kd/$filex5";

$kd6_session = nosql($_SESSION['kd6_session']);


















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


	

//isi
$member_menu = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();



//update testimoni
$qku = mysqli_query($koneksi, "SELECT AVG(nilai_kualitas_no) AS nkualitas, ".
						"AVG(nilai_manfaat_no) AS nmanfaat ".
						"FROM member_testimoni ".
						"WHERE item_kd = '$itemkd' ".
						"ORDER BY postdate DESC");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);
$nkualitas = nosql($rku['nkualitas']);
$nmanfaat = nosql($rku['nmanfaat']);


//update
mysqli_query($koneksi, "UPDATE m_item SET jml_kualitas = '$nkualitas', ".
				"jml_manfaat = '$nmanfaat' ".
				"WHERE kd = '$itemkd'");



//detail e
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item ".
						"WHERE kd = '$itemkd'");
$rtyk = mysqli_fetch_assoc($qtyk);
$nomer = $nomer + 1;
$e_kd = nosql($rtyk['kd']);
$e_nama = balikin($rtyk['nama']);
$e_isi = balikin($rtyk['isi']);
$e_harga = nosql($rtyk['harga']);
$e_berat = nosql($rtyk['berat']);
$e_jml = nosql($rtyk['jml']);
$e_jml_terjual = nosql($rtyk['jml_terjual']);
$e_jml_dilihat = nosql($rtyk['jml_dilihat']);
$e_jml_kualitas = nosql($rtyk['jml_kualitas']);
$e_jml_manfaat = nosql($rtyk['jml_manfaat']);
$filex1 = balikin($rtyk['filex1']);
$filex2 = balikin($rtyk['filex2']);
$filex3 = balikin($rtyk['filex3']);
$filex4 = balikin($rtyk['filex4']);
$filex5 = balikin($rtyk['filex5']);



$e_filex1 = "$sumber/filebox/item/$e_kd/$filex1";
$e_filex2 = "$sumber/filebox/item/$e_kd/$filex2";
$e_filex3 = "$sumber/filebox/item/$e_kd/$filex3";
$e_filex4 = "$sumber/filebox/item/$e_kd/$filex4";
$e_filex5 = "$sumber/filebox/item/$e_kd/$filex5";



?>


<style>
	img {
  max-width: 100%; }

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }




.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }


.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

/*# sourceMappingURL=style.css.map */
</style>






<script language='javascript'>
//membuat document jquery
$(document).ready(function(){


	var jmlku = $('#jmlku').val();


	$('#btnKRM').click(function () {

			var jmlku = $('#jmlku').val();

			$("#iproses").load("i_item.php?aksi=simpan&notakd=<?php echo $notakd;?>&sesikd=<?php echo $kd6_session;?>&itemkd=<?php echo $itemkd;?>&jmlku="+jmlku);
	
		});
	


	$("#idiskusi").load("i_item.php?aksi=formdiskusi&sesikd=<?php echo $kd6_session;?>&itemkd=<?php echo $itemkd;?>");
	$("#ilistdiskusi").load("i_item.php?aksi=listdiskusi&sesikd=<?php echo $kd6_session;?>&itemkd=<?php echo $itemkd;?>");
	$("#ilisttestimoni").load("i_item.php?aksi=listtestimoni&sesikd=<?php echo $kd6_session;?>&itemkd=<?php echo $itemkd;?>");
			
			

});

</script>







					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img src="<?php echo $e_filex1;?>" /></div>
						  <div class="tab-pane" id="pic-2"><img src="<?php echo $e_filex2;?>" /></div>
						  <div class="tab-pane" id="pic-3"><img src="<?php echo $e_filex3;?>" /></div>
						  <div class="tab-pane" id="pic-4"><img src="<?php echo $e_filex4;?>" /></div>
						  <div class="tab-pane" id="pic-5"><img src="<?php echo $e_filex5;?>" /></div>
						</div>
						<ul class="preview-thumbnail nav nav-tabs">
						  <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="<?php echo $e_filex1;?>" /></a></li>
						  <li><a data-target="#pic-2" data-toggle="tab"><img src="<?php echo $e_filex2;?>" /></a></li>
						  <li><a data-target="#pic-3" data-toggle="tab"><img src="<?php echo $e_filex3;?>" /></a></li>
						  <li><a data-target="#pic-4" data-toggle="tab"><img src="<?php echo $e_filex4;?>" /></a></li>
						  <li><a data-target="#pic-5" data-toggle="tab"><img src="<?php echo $e_filex5;?>" /></a></li>
						</ul>

						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title"><?php echo $e_nama;?></h3>

						<p class="product-description"><?php echo $e_isi;?></p>

						<table border="0" width="100%">
							<tr valign="top">
								<td width="75">
									<p>Berat</p>
									
									<p>Dilihat</p>
									
									<p>Terjual</p>
								</td>
								
								<td>
									
									<p>: <b><?php echo $e_berat;?> Gram</b></p>
									
									<p>: <b><?php echo $e_jml_dilihat;?></b></p>
									
									<p>: <b><?php echo $e_jml_terjual;?></b></p>

									<br>
									<br>	
								</td>
							</tr>							
						</table>


						
						
						<h4 class="price">Harga : <span><?php echo xduit2($e_harga);?></span></h4>
				

						<div class="action">
						
						<form id="frmbeli">
							
						<?php
						if (!empty($kd6_session))
							{
							echo '<select name="jmlku" id="jmlku" class="add-to-cart btn btn-info">
							<option value="1" selected>1</option>';
							
	
							for ($k=1;$k<=$e_jml;$k++)
								{
								echo '<option value="'.$k.'">'.$k.'</option>';
								}
	
				
							echo '</select>
						
							<input name="btnKRM" id="btnKRM" type="button" class="add-to-cart btn btn-danger" value="BELI">
							
							<input name="itemkd" id="itemkd" type="hidden" value="'.$itemkd.'">
							
							<div id="iproses"></div>
							<div id="ihasil"></div>';
							}
						?>
							
							
						</form>
						
						</div>

					</div>







          	
							              	
				<div class="container">
				    <div class="row">
						<div class="col-md-10">

						<br>
						<br>
						<br>						
						

						
						<?php
						//jika ada...
						if (!empty($nkualitas))
							{
							for ($k=1;$k<=$nkualitas;$k++)
								{
								echo '<img src="template/img/bintang.png" width="16">';
								}
							
							$xkualitas = $arrkualitas[$nkualitas];
							echo ' [Kualitas : '.$xkualitas.']
							<br>';
							
							
							for ($k=1;$k<=$nmanfaat;$k++)
								{
								echo '<img src="template/img/bintang.png" width="16">';
								}
							
							$xmanfaat = $arrmanfaat[$nmanfaat];
							echo ' [Manfaat : '.$xmanfaat.']
							<br>';
							}
						
						?>
		

						<br>
						<br>

						


							<div class="tabbable-panel">
								<div class="tabbable-line">
									<ul class="nav nav-tabs ">
										<li class="active">
											<a href="#tab_default_1" data-toggle="tab">
											DISKUSI </a>
										</li>
										<li>
											<a href="#tab_default_2" data-toggle="tab">
											TESTIMONI </a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_default_1">
											
											<div id="idiskusi"></div>
											<div id="ilistdiskusi"></div>

										</div>
										<div class="tab-pane" id="tab_default_2">

											<div id="ilisttestimoni"></div>

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>




<?php
//update jumlah dilihat
mysqli_query($koneksi, "UPDATE m_item SET jml_dilihat = jml_dilihat + 1 ".
				"WHERE kd = '$itemkd'");






//isi
$isi = ob_get_contents();
ob_end_clean();




require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>