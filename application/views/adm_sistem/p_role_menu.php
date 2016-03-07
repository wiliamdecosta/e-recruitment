<!-- Bootgrid Dialog -->
<link rel="stylesheet" href="<?php echo BS_PATH; ?>bootgrid/jquery.bootgrid.css" />
<link rel="stylesheet" href="<?php echo BS_PATH; ?>bootgrid/modification.css" />
<script src="<?php echo BS_PATH; ?>bootgrid/jquery.bootgrid.min.js"></script>
<script src="<?php echo BS_PATH; ?>bootgrid/properties.js"></script>

<div id="breadcrumbs" class="breadcrumbs">
    <div id="breadcrumbs" class="breadcrumbs">
	    <ul class="breadcrumb">
	    	<li>
	    		<i class="ace-icon fa fa-home home-icon"></i>
	    		<a href="<?php echo base_url("index.php/panel/index"); ?>">Home</a>
	    	</li>
            <li>
	    		<a href="#">Role Administration</a>
	    	</li>
	    	<li>
	    		<a href="#">Module Role</a>
	    	</li>
            <li class="active">Menu</li>
	    </ul><!-- /.breadcrumb --
	    <!-- /section:basics/content.searchbox -->
    </div>
</div>

<div class="page-content">
    <div class="row" id="role_menu_row_content" style="display:none;">
    	<div class="col-xs-12">
    		<!-- PAGE CONTENT BEGINS -->
    		<div class="row">
    		    <div class="col-xs-12">
    		        		        
    		        <div class="tabbable">
    		            <ul class="nav nav-tabs padding-18 tab-size-bigger tab-color-blue">
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-1">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Role</strong>
    					    	</a>
    					    </li>
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-2">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>
    					    		Module Role : <?php echo getVarClean('role_code','str',''); ?>
    					    		</strong>
    					    	</a>
    					    </li>
    					    <li class="active">
    					    	<a href="#" data-toggle="tab" aria-expanded="true">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>
    					    		Menu : <?php echo getVarClean('application_code','str',''); ?>
    					    		</strong>
    					    	</a>
    					    </li>
    		            </ul>
    		        </div>
    		        
    		        
    		        <div class="tab-content no-border">
        		        <div>
        					<button class="btn btn-white btn-success btn-round" id="role_menu_btn_add">
        						<i class="ace-icon glyphicon glyphicon-plus bigger-120 green"></i>
        					    Add
        					</button>
        
        					<button class="btn btn-white btn-danger btn-round" id="role_menu_btn_delete">
        						<i class="ace-icon glyphicon glyphicon-trash bigger-120 red"></i>
        						Delete
        					</button>
        					
        					<input id="form_p_role_id" type="hidden" placeholder="ID Role" value="<?php echo getVarClean('p_role_id','int',0); ?>">
        					<input id="form_role_code" type="hidden" placeholder="Role Code" value="<?php echo getVarClean('role_code','str',''); ?>">
        					
        					<input id="form_p_application_id" type="hidden" placeholder="ID Application" value="<?php echo getVarClean('p_application_id','int',0); ?>">
        					<input id="form_application_code" type="hidden" placeholder="Application Code" value="<?php echo getVarClean('application_code','str',''); ?>">
        				</div>
        
        		        <table id="role_menu_grid_selection" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th data-identifier="true" data-visible="false" data-header-align="center" data-align="center" data-column-id="p_role_menu_id"> ID Role Menu</th>
                             <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                             <th data-column-id="menu_code" data-width="190">Menu Code</th>
                          </tr>
                        </thead>
                        </table>
                    </div>
    		    </div>
    	    </div>
            <!-- PAGE CONTENT ENDS -->
    	</div><!-- /.col -->
    </div><!-- /.row -->
</div>
<?php $this->load->view('adm_sistem/p_role_menu_add_edit.php'); ?>

<script>
    jQuery(function($) {
        role_menu_prepare_table();

        /* show content */
        $("#role_menu_grid_selection").bootgrid().on("loaded.rs.jquery.bootgrid", function (e){
           $("#role_menu_row_content").slideDown("fast", function(){});
        });

        $("#role_menu_btn_add").on(ace.click_event, function() {
            role_menu_show_form_add();
        });

        $("#role_menu_btn_delete").on(ace.click_event, function(){
            if($("#role_menu_grid_selection").bootgrid("getSelectedRows") == "") {
                showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Information', properties.bootgridinfo.no_delete_records);
            }else {
                role_menu_delete_records( $("#role_menu_grid_selection").bootgrid("getSelectedRows") );
            }
        });
        
        $("#tab-1").on(ace.click_event, function () {
            loadContent('adm_sistem-p_role.php');
        });
        
        $("#tab-2").on(ace.click_event, function () {
            loadContentWithParams('adm_sistem-p_application_role.php',{
                 p_role_id : $("#form_p_role_id").val(),
                 role_code  : $("#form_role_code").val()    
            });
        });
    });

    function role_menu_prepare_table() {
        $("#role_menu_grid_selection").bootgrid({
    	     formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="#" title="Delete" onclick="role_menu_delete_records(\''+ row.p_role_menu_id +'\')" class="red"><i class="ace-icon glyphicon glyphicon-trash bigger-130"></i></a>';
                }
             },
    	     rowCount:[10,25,50,100,-1],
    		 ajax: true,
    	     requestHandler:function(request) {
    	        if(request.sort) {
    	            var sortby = Object.keys(request.sort)[0];
    	            request.dir = request.sort[sortby];

    	            delete request.sort;
    	            request.sort = sortby;
    	        }
    	        return request;
    	     },
    	     responseHandler:function (response) {
    	        if(response.success == false) {
    	            showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
    	        }
    	        return response;
    	     },
       	     url: '<?php echo WS_URL."adm_sistem.p_role_menu_controller/read"; ?>',
       	     post: function () {
    	         return { 
                    p_role_id : $("#form_p_role_id").val(),
    	            p_application_id : $("#form_p_application_id").val()
    	         };
    	     },
    	     selection: true,
    	     multiSelect: true,
    	     sorting:true,
    	     rowSelect:true,
    	     labels: {
    	        loading     : properties.bootgridinfo.loading
	         }
    	});
    	resize_bootgrid();
    }

    function role_menu_reload_table() {
        $("#role_menu_grid_selection").bootgrid("reload");
    }

    function role_menu_delete_records(theID) {
        BootstrapDialog.confirm({
            type: BootstrapDialog.TYPE_WARNING,
		    title:'Delete Confirmation',
		    message: properties.bootgridinfo.delete_confirmation_question,
		    btnCancelLabel: 'Cancel',
            btnOKLabel: 'Yes, Delete',
		    callback: function(result) {
    	        if(result) {
    	            $.post( "<?php echo WS_URL.'adm_sistem.p_role_menu_controller/destroy'; ?>",
            		    { items: JSON.stringify(theID) },
                        function( response ) {
                            if(response.success == false) {
                	            showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                	        }else {
                    	        loadContentWithParams('adm_sistem-p_role_menu',{
                    	            
                    	            p_application_id    : $("#form_p_application_id").val(), 
                                    application_code    : $("#form_application_code").val(),
                    	            p_role_id           : $("#form_p_role_id").val(),
                    	            role_code           : $("#form_role_code").val()    
                    	        });
                                showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Information', response.message);
                            }
                        }
                	);
    	        }
		    }
		});
    }
    
</script>