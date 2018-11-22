<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{judul}</title>
    <meta name="author" content="{author}">
	<meta name="description" content="{description}">
	<meta name="url" content="{url}">
	<meta name="keywords" content="{keywords}">
	
	<meta property="og:title" content="{judul}"/>
	<meta property="og:type" content="website"/>
	<meta property="og:description" content="{judul}"/>
	<meta property="og:url" content="{ke}/"/>
	<meta property="og:site_name" content="{toko_nama}"/>


<!--
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
--> 



  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{sumber}/template/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{sumber}/template/adminlte/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{sumber}/template/adminlte/dist/css/AdminLTE-biasawae.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{sumber}/template/adminlte/dist/css/skins/skins-biasawae.css">








<!-- jQuery 3 -->
<script src="{sumber}/template/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{sumber}/template/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="{sumber}/template/adminlte/dist/js/adminlte.min.js"></script>






<script type="text/javascript">
$(document).ready(function() {
	$('#loading').ajaxStart(function(){
			$(this).show();
		}).ajaxStop(function(){
			$(this).hide();
		});





		$("#btnCARI").on('click', function(){
			var kunci = $('#kunci').val();
			
			$("#formcari").submit(function(){
				$.ajax({
					url: "i_cari.php?aksi=cari",
					type:$(this).attr("method"),
					data:$(this).serialize(),
					success:function(data){					
						$("#result").html(data);
						}
					});
				return false;
			});
		
		
		});	

	





});

</script>







<style>

#footer 
	{
	background-color: white;
	width: 100%;
	bottom: 0;
	position: fixed;
	}




#headerku 
	{
	width: 100%;
	top: 0;
	position: fixed;
	z-index: 1000;
	}






/* Default mode */
.tabbable-line > .nav-tabs {
  border: none;
  margin: 0px;
}
.tabbable-line > .nav-tabs > li {
  margin-right: 2px;
}
.tabbable-line > .nav-tabs > li > a {
  border: 0;
  margin-right: 0;
  color: #737373;
}
.tabbable-line > .nav-tabs > li > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
  border-bottom: 4px solid #fbcdcf;
}
.tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
  border: 0;
  background: none !important;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
  margin-top: 0px;
}
.tabbable-line > .nav-tabs > li.active {
  border-bottom: 4px solid #f3565d;
  position: relative;
}
.tabbable-line > .nav-tabs > li.active > a {
  border: 0;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.active > a > i {
  color: #404040;
}
.tabbable-line > .tab-content {
  margin-top: -3px;
  background-color: #fff;
  border: 0;
  border-top: 1px solid #eee;
  padding: 15px 0;
}
.portlet .tabbable-line > .tab-content {
  padding-bottom: 0;
}

/* Below tabs mode */

.tabbable-line.tabs-below > .nav-tabs > li {
  border-top: 4px solid transparent;
}
.tabbable-line.tabs-below > .nav-tabs > li > a {
  margin-top: 0;
}
.tabbable-line.tabs-below > .nav-tabs > li:hover {
  border-bottom: 0;
  border-top: 4px solid #fbcdcf;
}
.tabbable-line.tabs-below > .nav-tabs > li.active {
  margin-bottom: -2px;
  border-bottom: 0;
  border-top: 4px solid #f3565d;
}
.tabbable-line.tabs-below > .tab-content {
  margin-top: -10px;
  border-top: 0;
  border-bottom: 1px solid #eee;
  padding-bottom: 15px;
}




</style>







</head>

<body class="hold-transition skin-green sidebar-collapse sidebar-mini">



<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5bf37f25b8ad962c"></script>







<div class="wrapper">


<div id="headerku">
	
  <header class="main-header">

    <nav class="navbar navbar-static-top">

        <ul class="nav navbar-nav">
        	

          <li class="active">
            <a href="{sumber}">
            	<b>
				BERANDA
				</b>
            </a>

          </li>



		<li>
            <a href="{sumber}/cara_order.php">
            	<b>
				CARA ORDER
				</b>
            </a>

          </li>


		<li>
            <a href="{sumber}/pembayaran.php">
            	<b>
				PEMBAYARAN
				</b>
            </a>

          </li>




		<li>
            <a href="{sumber}/kontak_kami.php">
            	<b>
				KONTAK KAMI
				</b>
            </a>

          </li>
          
          
		</ul>



 <div class="col-sm-3 col-md-3">
        <form class="navbar-form" role="search" name="formcari" id="formcari">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari Produk" name="kunci" id="kunci">
            <div class="input-group-btn">
                <button class="btn btn-default" name="btnCARI" id="btnCARI" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form>
    </div>
    
    
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        	
			{member_menu}

        </ul>
      </div>

    </nav>
  </header>


</div>


<br>
<br>
<br>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
			




	<div class="row">
		
		            
            <div class="col-md-9">


              <div class="box box-success">
                <div class="box-header with-border">
					<p>

				
						{ideskripsi}

					</p>

                </div>
                <!-- /.box-footer-->
              </div>
              
              
              
              
              
              
				<div class="col-md-8">

	
	              <div class="box box-success">
	                <div class="box-header with-border">
	                  <h3 class="box-title">PRODUK UNGGULAN</h3>
	
	                </div>
	
	                <!-- /.box-body -->
	                <div class="box-footer">
						<p>
	
					
							{iheadline}
	
						</p>
	
	                </div>
	                <!-- /.box-footer-->
	              </div>
	              


	              <div class="box box-success">
	              	
	              	
	              	
						<a name="kategori"></a>							              	
						<div class="container">
						    <div class="row">
								<div class="col-md-6">

									<div class="tabbable-panel">
										<div class="tabbable-line">
											<ul class="nav nav-tabs ">
												<li class="active">
													<a href="#tab_default_1" data-toggle="tab">
													PRODUK </a>
												</li>
												<li>
													<a href="#tab_default_2" data-toggle="tab">
													DISKUSI </a>
												</li>
												<li>
													<a href="#tab_default_3" data-toggle="tab">
													TESTIMONI </a>
												</li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_default_1">
													
													{ilistproduk}

												</div>
												<div class="tab-pane" id="tab_default_2">

													{ilistdiskusi}

												</div>
												<div class="tab-pane" id="tab_default_3">

													{ilisttestimoni}

												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
						
						
						



	              </div>

	              





              
              
	              
	            </div>


            
	            <div class="col-md-4">

			        <div class="box box-success">
		                <div class="box-header with-border">
		                  <h3 class="box-title">TERBARU</h3>
		                </div>
		
		                <!-- /.box-body -->
		                <div class="box-footer">
							
							{iterbaru}
		
		
		                </div>
		                <!-- /.box-footer-->
		              </div>



              
	            </div>

            

              


			</div>



            <div class="col-md-3">






			<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">STATISTIK</h3>

                </div>

                <!-- /.box-body -->
                <div class="box-footer">

					{istatistik}

                </div>
                <!-- /.box-footer-->
              </div>
              
              



			<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">INFO</h3>

                </div>

                <!-- /.box-body -->
                <div class="box-footer">

					{iinfo}

                </div>
                <!-- /.box-footer-->
              </div>
              
              





              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">TERLARIS</h3>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
					
						{iterlaris}

					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
                </div>
                <!-- /.box-footer-->
              </div>









            </div>
            <!-- /.col -->



            



          </div>
          <!-- /.row -->
          
          
          
                      


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>&copy; 2018 . {versi}</b>
      <br>
      [<a href="http://github.com/hajirodeon" target="_blank">http://github.com/hajirodeon</a>]
      <br>
    [<a href="{sumber}/login_admin.php" target="_blank">LOGIN ADMIN</a>]
    </div>
    <br>
    <br>
    <br>

  </footer>



		
<div id="footer">
	<div id="loading" style="display:none">
	<img src="{sumber}/template/img/progress-bar.gif" width="100" height="16">
	</div>
	
	<div id="result"></div>
	
</div>






</div>
<!-- ./wrapper -->


</body>
</html>
