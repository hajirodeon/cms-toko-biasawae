<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd16_session = nosql($_SESSION['kd16_session']);
$username16_session = nosql($_SESSION['username16_session']);
$adm_session = nosql($_SESSION['adm_session']);
$pass16_session = nosql($_SESSION['pass16_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysqli_query($koneksi, "SELECT kd FROM adminx ".
						"WHERE kd = '$kd16_session' ".
						"AND usernamex = '$username16_session' ".
						"AND passwordx = '$pass16_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd16_session))
	OR (empty($username16_session))
	OR (empty($pass16_session))
	OR (empty($adm_session))
	OR (empty($hajirobe_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>