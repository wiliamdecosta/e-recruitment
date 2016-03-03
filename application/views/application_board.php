<!DOCTYPE html>
<html lang="en">
    <link href="<?php echo IMAGE_APP_PATH; ?>logo_pdam_small.png" rel="shortcut icon" />
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>PDAM E-Recruitment</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>bootstrap.css" />
		<link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>font-awesome.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>ace.css" class="ace-main-stylesheet" id="main-ace-style" />


		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo BS_JS_PATH; ?>ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo BS_JS_PATH; ?>html5shiv.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>respond.js"></script>
		<![endif]-->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo BS_JS_PATH; ?>jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='<?php echo BS_JS_PATH; ?>jquery1x.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo BS_JS_PATH; ?>jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo BS_JS_PATH; ?>bootstrap.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo BS_JS_PATH; ?>excanvas.js"></script>
		<![endif]-->
		<script src="<?php echo BS_JS_PATH; ?>jquery-ui.custom.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>jquery.ui.touch-punch.js"></script>
        <!-- Bootstrap Dialog -->
		<link rel="stylesheet" href="<?php echo BS_PATH; ?>bootdialog/bootstrap-dialog.min.css" />
		<script src="<?php echo BS_PATH; ?>bootdialog/bootstrap-dialog.min.js"></script>

		<script>
		    $(document).ready(function () {
                // Ajax setup csrf token.
                var csfrData = {};
                csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
                $.ajaxSetup({
                    data: csfrData,
                    cache: false
                });
           });
            
		    function showBootDialog(bootclosable, boottype, boottitle, bootmessage ) {
		        BootstrapDialog.show({
		            closable: bootclosable,
                    type: boottype,
    		    	title: boottitle,
    		    	message: bootmessage
			    });
		    }

		</script>
        <style>
            img.grayscale {
                filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); /* Firefox 10+, Firefox on Android */
                filter: gray; /* IE6-9 */
                -webkit-filter: grayscale(100%); /* Chrome 19+, Safari 6+, Safari 6+ iOS */
            }

            .widget-main img.img-app {
                width:100%;
            }
            
            .navbar-brand {
			    position: relative;
			}
			
			.navbar-brand > img {
				max-width:310px;
			}
			
			.row-centered {
                text-align:center;
            }

			.col-centered{
			    float:none;
			    display:inline-block;
                margin: 0 auto;
            }
        </style>
	</head>

	<body class="no-skin" style="display:none;">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="<?php echo BASE_URL."application/index"; ?>" class="navbar-brand">
						<small>
                            <img src="<?php echo IMAGE_APP_PATH."logo_pdam_small.png"; ?>">
                            PDAM E-Recruitment
                        </small>
					</a>
				</div>

				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
                        <li class="red">
							<a href="<?php echo BASE_URL."application/index"; ?>">
								<i class="ace-icon fa fa-home bigger-230"></i>
								<span> &nbsp; Home </span>
							</a>
						</li>
						<!-- #section:basics/navbar.user_menu -->
						<li class="dark-10" id="nav-bar-user-menu">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo IMAGE_APP_PATH; ?>user.png" alt="User's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php
									    $ci =& get_instance();
	                                    $full_name = $ci->session->userdata('full_name');
									    echo $full_name;
									?>
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#" id="btn-user-profile">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="#" id="btn-logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>


            <div class="">
               <div class="">
                   <div class="well well-sm">
                       <?php
					    $ci =& get_instance();
	                       $user_name = $ci->session->userdata('user_name');
					   ?>
		               <div class="inline middle blue bigger-110"> <strong> You are loged in as : <?php echo $user_name; ?></strong> </div>
		           </div>
               </div>
            </div>

            <div class="main-content">
                <div class="container">
                    <div class="row row-centered">
                        
                <?php
                    $ci = & get_instance();
                    /*$query = $ci->db->query($sql);
			        $row = $query->row_array();*/

			        $isdamin = 0;

                    if ( $ci->session->userdata('p_user_id') == 1 ) $isadmin = 1;
                    $query = $ci->db->query("select count(*) jml from recruitment.p_user_role where p_role_id=1 and p_user_id=" . $ci->session->userdata('p_user_id'));
                    $row = $query->row_array();
                    if($row['jml'] > 0) $isadmin = 1;

                    if ($isadmin==1) {
            			  $sql = "select aa.p_application_id, aa.code, aa.description, is_on, aa.md_on " .
            							 "from recruitment.v_display_app(1,0.0) aa ";
            		} else {

            			  $sql = "select aa.p_application_id, aa.code, aa.description, is_on, aa.md_on " .
            							 "from recruitment.v_display_app(0," . $ci->session->userdata('p_user_id') . " ) aa ";
            		}

		            $query = $ci->db->query($sql);
			        $items = $query->result_array();

                    foreach($items as $item):
                ?>
                    
                    <div class="col-xs-6 col-md-3 col-centered">
                        <div class="widget-box <?php echo ($item['is_on']) ? "widget-color-green":"widget-color-dark lighter"; ?>">
                        	<div class="widget-header center">
                        		<h5 class="widget-title smaller"><strong><?php echo $item['code'];?></strong></h5>
                        	</div>

                        	<div class="widget-body" data-module="<?php echo ($item['is_on']) ? $item['p_application_id']:0; ?>">
                        		<div class="widget-main">
                        		    <a href="#">
                        			    <img class="img-app"  src="<?php echo ($item['is_on']) ? IMAGE_APP_PATH.substr($item['md_on'],10,5)."_on.png" : IMAGE_APP_PATH.substr($item['md_on'],10,5)."_off.png"; ?>" alt="256x256">
                        	    	</a>
                        		</div>
                        	</div>
                        </div>
                    </div>
                    
                <?php endforeach;?>
                    </div>
                </div>
		    </div>
	    </div>


		</div><!-- /.main-container -->


		<!-- ace scripts -->

		<script src="<?php echo BS_JS_PATH; ?>ace/ace.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.touch-drag.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.settings-skin.js"></script>

		<script type="text/javascript">

			jQuery(function($) {
                setInitialTheme();
                setTimeout( function(){
			        $("body").show();
			    }, 500);

			    $("#btn-logout").on(ace.click_event, function() {
					BootstrapDialog.confirm({
					    title:'Logout Confirmation',
					    message: 'Are you sure to logout?',
					    btnCancelLabel: 'Cancel',
                        btnOKLabel: 'Yes, Logout',
					    callback: function(result) {
    					    if(result) {
    					        $(location).attr('href','<?php echo BASE_URL."base/logout";?>');
    					    }
					    }
					});
				});

				$("#btn-user-profile").on(ace.click_event, function() {
					loadContent('user_profile2.php');
				});

                $(".widget-body").on(ace.click_event, function(){
                   if($(this).attr('data-module') == 0) {
                        showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Information', 'Sorry, You have no privilege to access this menu');
                        return;
                   };

                   $.post( "<?php echo WS_URL.'base.variables_controller/set_app_module'; ?>",
                        {
                            module_id: $(this).attr('data-module'),
                        },
                        function( response ) {
                            if(response.success) {
                                $(location).attr('href','<?php echo BASE_URL."panel/index";?>');
                            }else {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                            }
                        }
                   );
                });

                $(".widget-body").css( 'cursor', 'pointer' );
			});

			function loadContent(id) {
                $(".main-content").html('<div align="center"><h3 class="smaller lighter grey"> <i class="ace-icon fa fa-spinner fa-spin orange bigger-300"></i> <br/> Loading . . . </h3></div>');
			    setTimeout( function(){
            	    $.post( "<?php echo BASE_URL.'panel/load_content/'; ?>" + id, function( data ) {
                        $( ".main-content" ).html( data );
                    });
       		    }, 500 );
			}

            function setInitialTheme() {
		        $.post( "<?php echo WS_URL.'base.variables_controller/get_theme'; ?>",
		            { var_name: 'panel-theme' },
        		    function( response ) {
        		        if(response.success == false) {
    	                    showBootDialog(false, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
    	                }else {
    	                    setThemeSkin2( response.items );
                        }
        		    }
    		    );
		    }
        </script>
</body>
</html>