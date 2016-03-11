
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">E-Recruitment &copy; 2016. PDAM Tirtawening Kota Bandung</span>
						</span>

					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->



		<!-- ace scripts -->
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.scroller.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.colorpicker.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.fileinput.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.typeahead.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.wysiwyg.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.spinner.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.treeview.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.wizard.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/elements.aside.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.touch-drag.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.sidebar.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.sidebar-scroll-1.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.submenu-hover.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.widget-box.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.settings.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.settings-rtl.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.settings-skin.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.widget-on-reload.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>ace/ace.searchbox-autocomplete.js"></script>
        
        <!-- start blocked page when there is a post/get request -->
        <script src="<?php echo BS_JS_PATH; ?>jquery.blockUI.js"></script>
        <script src="<?php echo BS_JS_PATH; ?>jquery.ui.touch-punch.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                // Ajax setup csrf token.
                var csfrData = {};
                csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
                $.ajaxSetup({
                    data: csfrData,
                    cache: false
                });
           });
            
            $(document).ajaxStart(function () {
                //Global Jquery UI Block
                $(document).ajaxStart($.blockUI({
                    message:  '<i class="ace-icon fa fa-spinner fa-spin orange bigger-300"></i> <br/> <strong>Loading . . .</strong>',
                    css: {
                        border: 'none',
                        padding: '5px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px', 
                        color: '#fff',                       
                        opacity: .9
                    }
        
                })).ajaxStop($.unblockUI);
            });
            
            
            $(window).on('resize.jqGrid', function () {
                
                /*form modal*/
                if($("#editmodgrid-table").width() > $(window).width()) {
                    $("#editmodgrid-table").css("width", $(window).width()-20);        
                }else {
                    $("#editmodgrid-table").css("width", getMaxChildWidth($("#editmodgrid-table")) + 120);  
                }
                
                $("#editmodgrid-table").css("top",($(window).height() - $("#editmodgrid-table").height() ) / 2+$(window).scrollTop() + "px");
                $("#editmodgrid-table").css("left",( $(window).width() - $("#editmodgrid-table").width() ) / 2+$(window).scrollLeft() + "px");
                
                /*search modal */
                
                if($("#searchmodfbox_grid-table").width() > $(window).width()) {
                    $("#searchmodfbox_grid-table").css("width", $(window).width()-20);        
                }else {
                    $("#searchmodfbox_grid-table").css("width", 500);  
                }
            
            });
            
            
            function getMaxChildWidth(sel) {
                max = 0;
                $(sel).find('input[type=text],input[type=password],textarea,select,iframe').each(function() {
                    c_width = parseInt($(this).width());
                    if (c_width > max) {
                        max = c_width;
                    }    
                })
                return max;
            }

        </script>
        <!-- end blocked page -->
        
		<script type="text/javascript">
            
			jQuery(function($) {
			    
			    setInitialTheme();
			    setTimeout( function(){
			        $("body").show();
			        loadContent('dashboard.php');
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
				    $(".nav-menu-content").removeClass("active");
					loadContent('user_profile.php');
				});

				$(".nav-menu-content").on(ace.click_event,function(){
				    $(".nav-menu-content").removeClass("active");
				    $(this).addClass("active");
				    var menu_id = $(this).attr('data-source');
				    loadContent(menu_id);
				});
				
				$("#main-container").on(ace.click_event,function(){
				    $("#sidebar").removeClass("display");
				});
				
				
			});

			function loadContent(id) {
			    clearContentArea();
                /*$("#main-content").html('<div align="center"><h3 class="smaller lighter grey"> <i class="ace-icon fa fa-spinner fa-spin orange bigger-300"></i> <br/> Loading . . . </h3></div>');
			    setTimeout( function(){
            	    $.post( "<?php echo BASE_URL.'panel/load_content/'; ?>" + id, function( data ) {
                        $( "#main-content" ).html( data );
                    });
       		    }, 500 );*/
			    
			    $.post( "<?php echo BASE_URL.'panel/load_content/'; ?>" + id, function( data ) {
                    $( "#main-content" ).html( data );
                });
			}
			
			function loadContentWithParams(id, params) {
			    clearContentArea();
                /*$("#main-content").html('<div align="center"><h3 class="smaller lighter grey"> <i class="ace-icon fa fa-spinner fa-spin orange bigger-300"></i> <br/> Loading . . . </h3></div>');
			    setTimeout( function(){
			        $.post( "<?php echo BASE_URL.'panel/load_content/'; ?>" + id,
                        params,
                        function( data ) {
                            $( "#main-content" ).html( data );
                        }
                    );
       		    }, 500 );*/
       		    
       		    $.post( "<?php echo BASE_URL.'panel/load_content/'; ?>" + id,
                    params,
                    function( data ) {
                        $( "#main-content" ).html( data );
                    }
                );
       		    
			}
			
			function clearContentArea() {
			    $(".aside").remove();
			}
			
			/* called by ace.settings-skin.js */
			function updateVarTheme(skin_class) {
			    $.post( "<?php echo WS_URL.'base.variables_controller/set_theme'; ?>", 
        		    { var_name: 'panel-theme', var_value: skin_class },                
        		    function( response ) {
        		        if(response.success == false) showBootDialog(false, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
        		    }
    		    );
		    }
		    
		    function setInitialTheme() {
		        $.post( "<?php echo WS_URL.'base.variables_controller/get_theme'; ?>", 
		            { var_name: 'panel-theme' },
        		    function( response ) {
        		        if(response.success == false) {
    	                    showBootDialog(false, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
    	                }else {
            		        setThemeSkin( response.rows );
            		        $("#skin-colorpicker option[data-skin='"+ response.rows +"']").attr("selected","selected");
            		        $(".colorpick-btn").removeClass("selected");
                            $(".btn-colorpicker").css("background-color", $("#skin-colorpicker").val());
                        }
        		    }
    		    );
		    }
		    
        </script>


	</body>
</html>