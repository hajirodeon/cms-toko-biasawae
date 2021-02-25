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
	



?>



<script language='javascript'>
//membuat document jquery
$(document).ready(function(){

	$("#btnKRM").on('click', function(){
		$('#loading').show();

		$("#formx2").submit(function(){
			$.ajax({
				url: "i_login.php?aksi=simpan",
				type:$(this).attr("method"),
				data:$(this).serialize(),
				success:function(data){					
					$("#iloginresult").html(data);
					setTimeout('$("#loading").hide()',5000);
					}
				});
			return false;
		});
	
	
	});	






	$("#btnLUPA").on('click', function(){
		window.location.href = "<?php echo $sumber;?>/lupa.php";
	});	








});

</script>




<?php



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$euser = cegah($_GET['usernamex']);
	$epass = md5(cegah($_GET['passwordx']));

	
	//empty
	if ((empty($euser)) OR (empty($epass)))
		{
		echo '<h3>INPUT TIDAK LENGKAP</h3>';	
		} 
	else
		{
		//cek
		$qku = mysqli_query($koneksi, "SELECT * FROM m_member ".
								"WHERE usernamex = '$euser' ".
								"AND passwordx = '$epass'");
		$rku = mysqli_fetch_assoc($qku);
		$tku = mysqli_num_rows($qku);
		
		//jika null
		if (empty($tku))
			{
			echo '<h3>
			ERROR... SILAHKAN COBA LAGI...
			</h3>';
			}
		else
			{
			//lanjut
			$ku_kd = nosql($rku['kd']);
			$ku_telp = nosql($rku['telp']);
			$ku_nama = balikin($rku['nama']);
			
			//bikin sesi
			$_SESSION['member_session'] = "MEMBER";
			$_SESSION['telp6_session'] = $ku_telp;
			$_SESSION['sesikd'] = $ku_kd;
			$_SESSION['sesinama'] = $ku_nama;
			$_SESSION['kd6_session'] = $ku_kd;
			$_SESSION['nama6_session'] = $ku_nama;
			$_SESSION['username6_session'] = $euser;
			$_SESSION['pass6_session'] = $epass;
			$_SESSION['hajirobe_session'] = $x;
			
			?>
			
			
			
			<script language='javascript'>
			//membuat document jquery
			$(document).ready(function(){
					window.location.href = "<?php echo $sumber;?>"; 
			
			});
			
			</script>
			
			<?php
			
	
			}

								
		}	

	
	exit();
	}



//jika form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'form'))
	{
	echo '<form name="formx2" id="formx2">

	<table height="300" width="800" border="0" cellpadding="5" cellspacing="5">
	<tr>
	<td valign="top" width="50">
	</td>
	
	<td valign="top">
	


        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="glyphicon glyphicon-user"></i>
            </div>
            <input type="text" class="btn btn-info" size="30" name="usernamex" id="usernamex" placeholder="Username" autocomplete="off" />
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon">
              <i class=" glyphicon glyphicon-lock "></i>
            </div>
            <input type="password" class="btn btn-info" name="passwordx" id="passwordx" size="30" placeholder="Password" autocomplete="off" />
          </div>
        </div>


        <button name="btnKRM" id="btnKRM" class="btn btn-danger" type="submit">MASUK >></button>
	
	<br>
	<br>
	<br>


	<hr>
	
	<button name="btnLUPA" id="btnLUPA" class="btn btn-primary" type="button">LUPA PASSWORD</button>
        
	</td>
	</tr>
	</table>
	</form>';
	
	exit();
	}
	
	
exit();
?>