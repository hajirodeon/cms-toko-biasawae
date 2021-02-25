<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd6_session = nosql($_SESSION['kd6_session']);
$telp6_session = nosql($_SESSION['telp6_session']);
$username6_session = nosql($_SESSION['username6_session']);
$member_session = nosql($_SESSION['member_session']);
$pass6_session = nosql($_SESSION['pass6_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysqli_query($koneksi, "SELECT kd FROM m_member ".
						"WHERE kd = '$kd6_session' ".
						"AND usernamex = '$username6_session' ".
						"AND passwordx = '$pass6_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd6_session))
	OR (empty($username6_session))
	OR (empty($pass6_session))
	OR (empty($member_session))
	OR (empty($hajirobe_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>