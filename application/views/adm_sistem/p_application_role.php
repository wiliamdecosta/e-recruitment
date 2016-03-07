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
            <li class="active">Module Role</li>
	    </ul><!-- /.breadcrumb --
	    <!-- /section:basics/content.searchbox -->
    </div>
</div>

<div class="page-content">
    <div class="row" id="application_role_row_content" style="display:none;">
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
    					    <li class="active">
    					    	<a href="#" data-toggle="tab" aria-expanded="true">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>
    					    		Module Role : <?php echo getVarClean('role_code','str',''); ?>
    					    		</strong>
    					    	</a>
    					    </li>
    		            </ul>
    		        </div>
    		        
    		        <div class="tab-content no-border">
        		        <div>
        					<button class="btn btn-white btn-success btn-round" id="application_role_btn_add">
        						<i class="ace-icon glyphicon glyphicon-plus bigger-120 green"></i>
        					    Add
        					</button>
        
        					<button class="btn btn-white btn-danger btn-round" id="application_role_btn_delete">
        						<i class="ace-icon glyphicon glyphicon-trash bigger-120 red"></i>
        						Delete
        					</button>
        					
        					<input id="form_p_role_id" type="hidden" placeholder="ID Role" value="<?php echo getVarClean('p_role_id','int',0); ?>">
        					<input id="form_role_code" type="hidden" placeholder="Role Code" value="<?php echo getVarClean('role_code','str',''); ?>">
        				</div>
        
        		        <table id="application_role_grid_selection" class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th data-identifier="true" data-visible="false" data-header-align="center" data-align="center" data-column-id="p_application_role_id"> ID Role</th>
                                 <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                                 <th data-column-id="application_code" data-width="190">Module Code</th>
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

<?php $this->load->view('adm_sistem/p_application_role_add_edit.php'); ?>

<script>
    jQuery(function($) {
        application_role_prepare_table();

        /* show content */
        $("#application_role_grid_selection").bootgrid().on("loaded.rs.jquery.bootgrid", function (e){
           $("#application_role_row_content").slideDown("fast", function(){});
        });

        $("#application_role_btn_add").on(ace.click_event, function() {
            application_role_show_form_add();
        });

        $("#application_role_btn_delete").on(ace.click_event, function(){
            if($("#application_role_grid_selection").bootgrid("getSelectedRows") == "") {
                showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Information', properties.bootgridinfo.no_delete_records);
            }else {
                application_role_delete_records( $("#application_role_grid_selection").bootgrid("getSelectedRows") );
            }
        });
        
        $("#tab-1").on(ace.click_event, function () {
            loadContent('adm_sistem-p_role.php');
        });
    });

    function application_role_prepare_table() {
        $("#application_role_grid_selection").bootgrid({
    	     formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="#" title="Delete" onclick="application_role_delete_records(\''+ row.p_application_role_id +'\')" class="red"><i class="ace-icon glyphicon glyphicon-trash bigger-130"></i></a> &nbsp; <a href="#" title="Menu Role" onclick="application_role_show_role_menu(\''+ row.p_application_id +'\', \''+ row.application_code +'\')" class="purple"><i class="ace-icon glyphicon glyphicon-list bigger-130"></i></a>';
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
       	     url: '<?php echo WS_URL."adm_sistem.p_application_role_controller/read"; ?>',
       	     post: function () {
    	         return { p_role_id : $("#form_p_role_id").val() };
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

    function application_role_reload_table() {
        $("#application_role_grid_selection").bootgrid("reload");
    }

    function application_role_delete_records(theID) {
        BootstrapDialog.confirm({
            type: BootstrapDialog.TYPE_WARNING,
		    title:'Delete Confirmation',
		    message: properties.bootgridinfo.delete_confirmation_question,
		    btnCancelLabel: 'Cancel',
            btnOKLabel: 'Yes, Delete',
		    callback: function(result) {
    	        if(result) {
    	            $.post( "<?php echo WS_URL.'adm_sistem.p_application_role_controller/destroy'; ?>",
            		    { items: JSON.stringify(theID) },
                        function( response ) {
                            if(response.success == false) {
                	            showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                	        }else {
                    	        loadContentWithParams('adm_sistem-p_application_role',{
                    	            p_role_id : $("#form_p_role_id").val(),
                    	            role_code : $("#form_role_code").val()    
                    	        });
                                showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Information', response.message);
                            }
                        }
                	);
    	        }
		    }
		});
    }
    
    function application_role_show_role_menu(theID, theCode) {
        loadContentWithParams("adm_sistem-p_role_menu.php", {
            p_application_id: theID, 
            application_code: theCode,
            p_role_id : $("#form_p_role_id").val(),
            role_code : $("#form_role_code").val()
        });
    }
</script>