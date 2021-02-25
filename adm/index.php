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
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/adm.php");
$tpl = LoadTpl("../template/admin.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang, ADMIN.";
$judulku = "$judul  [$adm_session]";





//isi *START
ob_start();







//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_item");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_item = mysqli_num_rows($qtyk);



//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_member");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_member = mysqli_num_rows($qtyk);






//query
$qtyk = mysqli_query($koneksi, "SELECT SUM(jml) AS total ".
						"FROM m_item");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_stock = nosql($rtyk['total']);



//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_order");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_order = mysqli_num_rows($qtyk);





//query
$qtyk = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima <> '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_omzet = nosql($rtyk['total']);



//query
$qtyk = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima <> '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_omzet = nosql($rtyk['total']);



//query
$qtyk = mysqli_query($koneksi, "SELECT SUM(jasakirim_ongkir_subtotal) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima <> '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_ongkir = nosql($rtyk['total']);








//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'false'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_pending = mysqli_num_rows($qtyk);





//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_kirim = '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_proses = mysqli_num_rows($qtyk);






//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_kirim <> '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_dikirim = mysqli_num_rows($qtyk);






//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_diterima <> '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_selesai = mysqli_num_rows($qtyk);






//query
$qtyk = mysqli_query($koneksi, "SELECT AVG(nilai_kualitas_no) AS total ".
						"FROM member_testimoni");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_kualitas = round(mysqli_num_rows($qtyk));


//persen
$kualitas_persen = round(($jml_kualitas / 5) * 100);










//query
$qtyk = mysqli_query($koneksi, "SELECT AVG(nilai_manfaat_no) AS total ".
						"FROM member_testimoni");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_manfaat = round(mysqli_num_rows($qtyk));


//persen
$manfaat_persen = round(($jml_manfaat / 5) * 100);









//query
$qtyk = mysqli_query($koneksi, "SELECT AVG(jml_speed_kirim) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima <> '0000-00-00'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_speed_kirim = round(nosql($rtyk['total']));









//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_diskusi");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_diskusi = round(mysqli_num_rows($qtyk));






//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM member_testimoni");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_testimoni = round(mysqli_num_rows($qtyk));






?>

      <!-- Info boxes -->
      <div class="row">

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ITEM</span>
              <span class="info-box-number"><?php echo $jml_item;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-pencil"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">STOCK</span>
              <span class="info-box-number"><?php echo $jml_stock;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        



		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">KUALITAS</span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo $kualitas_persen;?>%"></div>
              </div>
                  <span class="progress-description">
                    <?php echo $kualitas_persen;?>% 
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        



		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">MANFAAT</span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo $manfaat_persen;?>%"></div>
              </div>
                  <span class="progress-description">
                    <?php echo $manfaat_persen;?>% 
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        




        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">MEMBER</span>
              <span class="info-box-number"><?php echo $jml_member;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        







        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-play"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">KECEPATAN KIRIM</span>
              <span class="info-box-number"><?php echo $jml_speed_kirim;?> Hari</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        
        
        
        
        



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-pencil"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">DISKUSI</span>
              <span class="info-box-number"><?php echo $jml_diskusi;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        
        



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-pencil"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TESTIMONI</span>
              <span class="info-box-number"><?php echo $jml_testimoni;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        
        



        
        



        
        

                
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-opencart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL TRANSAKSI</span>
              <span class="info-box-number"><?php echo $jml_order;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-opencart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PENDING</span>
              <span class="info-box-number"><?php echo $jml_pending;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-opencart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PROSES BUNGKUS</span>
              <span class="info-box-number"><?php echo $jml_proses;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-opencart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TELAH DIKIRIM</span>
              <span class="info-box-number"><?php echo $jml_dikirim;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-opencart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SELESAI</span>
              <span class="info-box-number"><?php echo $jml_selesai;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>





		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">OMZET</span>
              <span class="info-box-number"><?php echo xduit2($jml_omzet);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>




		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ONGKOS KIRIM</span>
              <span class="info-box-number"><?php echo xduit2($jml_ongkir);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>










        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">TRANSAKSI SEMINGGU INI...</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">



				
				

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
							
				<tr bgcolor="'.$warnaheader.'">';
				
				echo '<td width="75" align="center"></td>';
													
													
				//tanggal sekarang
				$m = date("m");
				$de = date("d");
				$y = date("Y");
				
				//ambil 7hari terakhir
				for($i=0; $i<=7; $i++)
					{
					$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 
				
					echo '<td width="75" align="center"><strong><font color="'.$warnatext.'">'.$nilku.'</font></strong></td>';
					}


				echo '</tr>
				
				<tr>
				<td width="75" align="center">Baru</td>';
								
				//tanggal sekarang
				$m = date("m");
				$de = date("d");
				$y = date("Y");
				
				//ambil 7hari terakhir
				for($i=0; $i<=7; $i++)
					{
					$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 
				
				
					//ketahui ordernya...
					$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
											"WHERE tgl_bayar = '$nilku' ".
											"AND konfirmasi = 'true'");
					$tyuk = mysqli_num_rows($qyuk);
					
					if (empty($tyuk))
						{
						$tyuk = "";
						}
					
					
					
					echo '<td width="75" align="center">
					'.$tyuk.'					
					</td>';
					}


				echo '</tr>
				
				<tr>
				<td width="75" align="center">Bungkus</td>';
								
				//tanggal sekarang
				$m = date("m");
				$de = date("d");
				$y = date("Y");
				
				//ambil 7hari terakhir
				for($i=0; $i<=7; $i++)
					{
					$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 
				
				
					//ketahui ordernya...
					$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
											"WHERE tgl_proses = '$nilku' ".
											"AND tgl_kirim = '0000-00-00' ".
											"AND konfirmasi = 'true'");
					$tyuk = mysqli_num_rows($qyuk);
					
					if (empty($tyuk))
						{
						$tyuk = "";
						}
					
					
					
					
					echo '<td width="75" align="center">
					'.$tyuk.'					
					</td>';
					}


				echo '</tr>
				
				<tr>
				<td width="75" align="center">Kirim</td>';
								
				//tanggal sekarang
				$m = date("m");
				$de = date("d");
				$y = date("Y");
				
				//ambil 7hari terakhir
				for($i=0; $i<=7; $i++)
					{
					$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 
				
				
					//ketahui ordernya...
					$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
											"WHERE tgl_kirim = '$nilku' ".
											"AND konfirmasi = 'true'");
					$tyuk = mysqli_num_rows($qyuk);
					
					
					if (empty($tyuk))
						{
						$tyuk = "";
						}
					
					
					
					echo '<td width="75" align="center">
					'.$tyuk.'					
					</td>';
					}


				echo '</tr>
				
				
				<tr>
				<td width="75" align="center">Selesai</td>';
								
				//tanggal sekarang
				$m = date("m");
				$de = date("d");
				$y = date("Y");
				
				//ambil 7hari terakhir
				for($i=0; $i<=7; $i++)
					{
					$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 
				
				
					//ketahui ordernya...
					$qyuk = mysqli_query($koneksi, "SELECT * FROM member_order ".
											"WHERE tgl_diterima = '$nilku' ".
											"AND konfirmasi = 'true'");
					$tyuk = mysqli_num_rows($qyuk);
					
					
					if (empty($tyuk))
						{
						$tyuk = "";
						}
					
					
					
					echo '<td width="75" align="center">
					'.$tyuk.'					
					</td>';
					}


				echo '</tr>
				</tbody>
				  </table>
				  </div>
				  <hr>
				  <br>
				  <br>';




				//kasi default, kota kendal jawa tengah //////////////////////////////////////////////
			    $latitude = "-7.0265442";
			    $longitude = "110.1879106"; 
					

				
				?>
				
				
				<h3>
					Peta Lokasi Penerima Paket
				</h3>
				
				<style type="text/css">
				
				#map_canvas { 
					width: 100%
					height: 100% 
					}
				</style>
				
				<script type="text/javascript" src = "http://maps.google.com/maps/api/js?sensor=false&key=<?php echo $keyku;?>">
				
				</script>
				<script type="text/javascript">
				function initialize() {
				
				var infoWindow = new google.maps.InfoWindow;
				
				var mapOptions = {
				center: new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>),
				zoom: 1,
				mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				
				
				
				
				var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
				
				var bounds = new google.maps.LatLngBounds();
				
				
				<?php
				    $query = mysqli_query($koneksi, "select * from member_order ".
				    						"WHERE latx <> '' ".
				    						"ORDER BY postdate DESC");
					$row = mysqli_fetch_assoc($query);
				
				    do
				    	{
				    	//nilai
				        $name = $row['nota_kode'];
				        $lat = $row['latx'];
				        $lon = $row['laty'];
				
				        echo ("addMarker($lat, $lon, '<b>$name</b>');\n");
						}
					while ($row = mysqli_fetch_assoc($query)); 
				
				?>
				
				function addMarker(lat, lng, info) {
				    var location = new google.maps.LatLng(lat, lng);
				    bounds.extend(location);
				    var marker = new google.maps.Marker({
				        map: map,
				        position: location
				    });       
				    map.fitBounds(bounds);
				    bindInfoWindow(marker, map, infoWindow, info);
				}
				
				function bindInfoWindow(marker, map, infoWindow, html) {
				    google.maps.event.addListener(marker, 'click', function() {
				        infoWindow.setContent(html);
				        infoWindow.open(map, marker);
				    });
				}
				
				
				
				}
				
				</script>
				
				<body onload="initialize()">
				
				<div id="map_canvas" style="width: 100%; height: 400px"></div>
				










				    
				    

                </div>
                
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>ITEM TERLARIS</strong>
                  </p>

				<?php
				//daftar item laris
				$qyuk = mysqli_query($koneksi, "SELECT * FROM m_item ".
										"ORDER BY round(jml_terjual) DESC LIMIT 0,10");
				$ryuk = mysqli_fetch_assoc($qyuk);
				
				do
					{
					$yuk_itemkd = nosql($ryuk['kd']);
					$yuk_jml = nosql($ryuk['jml_terjual']);
					$yuk_nama = balikin($ryuk['nama']);
				
				
					$nilaiku = round(($yuk_jml / 100) * 100);	
					?>
	                  <!-- /.progress-group -->
	                  <div class="progress-group">
	                    <span class="progress-text"><?php echo $yuk_nama;?> [<?php echo $yuk_jml?>]</span>
	
	                    <div class="progress sm">
	                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $nilaiku;?>%"></div>
	                    </div>
	                  </div>
	                <?php
					}
				while ($ryuk = mysqli_fetch_assoc($qyuk));
				?>  



                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->



<?php




//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");

//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>