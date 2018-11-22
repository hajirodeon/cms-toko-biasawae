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
 
 

//query
$qtyk = mysql_query("SELECT * FROM m_item");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_item = mysql_num_rows($qtyk);



//query
$qtyk = mysql_query("SELECT SUM(jml) AS total ".
						"FROM m_item");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_stock = nosql($rtyk['total']);



//query
$qtyk = mysql_query("SELECT * FROM member_order");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_order = mysql_num_rows($qtyk);




//query
$qtyk = mysql_query("SELECT * FROM member_order ".
						"WHERE konfirmasi = 'false'");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_pending = mysql_num_rows($qtyk);





//query
$qtyk = mysql_query("SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_kirim = '0000-00-00'");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_proses = mysql_num_rows($qtyk);






//query
$qtyk = mysql_query("SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_kirim <> '0000-00-00'");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_dikirim = mysql_num_rows($qtyk);






//query
$qtyk = mysql_query("SELECT * FROM member_order ".
						"WHERE konfirmasi = 'true' ".
						"AND tgl_diterima <> '0000-00-00'");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_selesai = mysql_num_rows($qtyk);





//query
$qtyk = mysql_query("SELECT AVG(nilai_kualitas_no) AS total ".
						"FROM member_testimoni");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_kualitas = round(mysql_num_rows($qtyk));


//persen
$kualitas_persen = round(($jml_kualitas / 5) * 100);










//query
$qtyk = mysql_query("SELECT AVG(nilai_manfaat_no) AS total ".
						"FROM member_testimoni");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_manfaat = round(mysql_num_rows($qtyk));


//persen
$manfaat_persen = round(($jml_manfaat / 5) * 100);









//query
$qtyk = mysql_query("SELECT AVG(jml_speed_kirim) AS total ".
						"FROM member_order ".
						"WHERE tgl_diterima <> '0000-00-00'");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_speed_kirim = round(nosql($rtyk['total']));









//query
$qtyk = mysql_query("SELECT * FROM member_diskusi");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_diskusi = round(mysql_num_rows($qtyk));






//query
$qtyk = mysql_query("SELECT * FROM member_testimoni");
$rtyk = mysql_fetch_assoc($qtyk);
$jml_testimoni = round(mysql_num_rows($qtyk));








echo '<div class="box box-widget widget-user-2">
<div class="box-footer no-padding">
  <ul class="nav nav-stacked">
	 	<li><a href="#">Kecepatan Kirim (Hari)<span class="pull-right badge bg-black">'.$jml_speed_kirim.'</span></a></li>
		<li><a href="#">Diskusi <span class="pull-right badge bg-red">'.$jml_diskusi.'</span></a></li>
		<li><a href="#">Testimoni <span class="pull-right badge bg-orange">'.$jml_testimoni.'</span></a></li>
    	<li><a href="#">Item <span class="pull-right badge bg-blue">'.$jml_item.'</span></a></li>
        <li><a href="#">Stock <span class="pull-right badge bg-aqua">'.$jml_stock.'</span></a></li>
        <li><a href="#">Total Transaksi <span class="pull-right badge bg-green">'.$jml_order.'</span></a></li>
        <li><a href="#">Transaksi Pending <span class="pull-right badge bg-red">'.$jml_pending.'</span></a></li>
        
        <li><a href="#">Transaksi Proses <span class="pull-right badge bg-orange">'.$jml_proses.'</span></a></li>
		<li><a href="#">Transaksi Sedang Dikirim <span class="pull-right badge bg-magenta">'.$jml_dikirim.'</span></a></li>
        <li><a href="#">Transaksi Selesai <span class="pull-right badge bg-purple">'.$jml_selesai.'</span></a></li>
	</ul>
</div>
</div>';
