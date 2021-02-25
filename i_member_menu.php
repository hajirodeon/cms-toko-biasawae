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
 
 

///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd6_session = nosql($_SESSION['kd6_session']);
$notakd = nosql($_SESSION['notakd']);
$nama6_session = cegah($_SESSION['nama6_session']);
$telp6_session = nosql($_SESSION['telp6_session']);
$username6_session = nosql($_SESSION['username6_session']);
$member_session = nosql($_SESSION['member_session']);
$pass6_session = nosql($_SESSION['pass6_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);



//jika null
if (empty($kd6_session))
	{
	//jika reg
	if ($filenya == "reg.php")
		{
		$statusku = " class=\"active\"";	
		}
		
		
	
	//jika login
	else if ($filenya == "login.php")
		{
		$statusku2 = " class=\"active\"";	
		}

		

	echo '<li '.$statusku.'>
	<a href="'.$sumber.'/reg.php">
    <b>
	Menjadi Member
	</b>
    </a>
    </li>
    
    
    <li '.$statusku2.'>
	<a href="'.$sumber.'/login.php">
    <b>
	LOGIN
	</b>
    </a>
    </li>';
		
	}
	
//jika ada
else
	{
	//jika profil
	if ($filenya == "member_profil.php")
		{
		$statusku3 = " class=\"active\"";	
		}


	//jika troli
	if ($filenya == "member_troli.php")
		{
		$statusku4 = " class=\"active\"";	
		}

	//jika konfirmasi
	if ($filenya == "member_konfirmasi.php")
		{
		$statusku5 = " class=\"active\"";	
		}

	//jika history
	if ($filenya == "member_history.php")
		{
		$statusku6 = " class=\"active\"";	
		}

	//jika diskusi
	if ($filenya == "member_diskusi.php")
		{
		$statusku7 = " class=\"active\"";	
		}


	//jika testimoni
	if ($filenya == "member_testimoni.php")
		{
		$statusku8 = " class=\"active\"";	
		}

		
		
	//ketahui jumlah item yang masih dalam troli belanja
	$q = mysqli_query($koneksi, "SELECT * FROM member_order_detail ".
						"WHERE member_kd = '$kd6_session' ".
						"AND nota_kd = '$notakd' ".
						"ORDER BY item_nama ASC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);
		
		
	echo '<li '.$statusku3.'>
        <a href="'.$sumber.'/member_profil.php" title="Profil Diri">
          <i class="fa fa-user"></i>
        </a>

      </li>



      <li '.$statusku4.'>
        <a href="'.$sumber.'/member_troli.php" title="Troli Belanja">
          <i class="fa fa-opencart"></i>
          <span class="label label-success">'.$total.'</span>
        </a>
      </li>



      <li '.$statusku5.'>
        <a href="'.$sumber.'/member_konfirmasi.php" title="Konfirmasi Transfer">
          <i class="fa fa-money"></i>
        </a>
      </li>



      <li '.$statusku6.'>
        <a href="'.$sumber.'/member_history.php" title="History Transaksi">
          <i class="fa fa-history"></i>
        </a>
      </li>


      <li '.$statusku7.'>
        <a href="'.$sumber.'/member_diskusi.php" title="Diskusi">
          <i class="fa fa-pencil-square-o"></i>
        </a>
      </li>




      <li '.$statusku8.'>
        <a href="'.$sumber.'/member_testimoni.php" title="Testimoni">
          <i class="fa fa-comment"></i>
        </a>
      </li>





      <li>
        <a href="'.$sumber.'/logout.php"><i class="fa fa-gears"></i>KELUAR</a>
      </li>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>