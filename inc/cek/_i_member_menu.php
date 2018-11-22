<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd6_session = nosql($_SESSION['kd6_session']);
$telp6_session = nosql($_SESSION['telp6_session']);
$username6_session = nosql($_SESSION['username6_session']);
$member_session = nosql($_SESSION['member_session']);
$pass6_session = nosql($_SESSION['pass6_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);



//jika null
if (empty($kd6_session))
	{
		
	}
	
//jika ada
else
	{
	?>
		
	
        	
		<!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="{sumber}/member/profil.php" class="dropdown-toggle" data-toggle="dropdown" title="Profil Diri">
              <img src="{sumber}/template/img/users.png" class="user-image" alt="User Image">
              <span class="hidden-xs">&nbsp;</span>
            </a>

          </li>



          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Troli Belanja">
              <i class="fa fa-opencart"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Troli Belanja</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                      <p>item1</p>
                  </li>

                  <li>
                      <p>item2</p>
                  </li>
                  
                  <li>
                      <p>item3</p>
                  </li>
                  
                  <li>
                      <p>item3</p>
                  </li>
                  <li>
                      <p>item3</p>
                  </li>
                  <li>
                      <p>item3</p>
                  </li>
                  <li>
                      <p>item3</p>
                  </li>
                  <li>
                      <p>item3</p>
                  </li>
                  <li>
                      <p>item3</p>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">EDIT TROLI BELANJA</a></li>
            </ul>
          </li>


          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i>KELUAR</a>
          </li>

	<?php
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>