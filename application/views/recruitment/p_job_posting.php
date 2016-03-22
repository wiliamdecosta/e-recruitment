<script src="<?php echo BS_PATH; ?>tinymce/tinymce.min.js"></script>
<script src="<?php echo BS_PATH; ?>tinymce/jquery.tinymce.min.js"></script>

<div id="breadcrumbs" class="breadcrumbs">
    <div id="breadcrumbs" class="breadcrumbs">
	    <ul class="breadcrumb">
	    	<li>
	    		<i class="ace-icon fa fa-home home-icon"></i>
	    		<a href="<?php echo base_url("index.php/panel/index"); ?>">Home</a>
	    	</li>
            <li>
	    		<a href="#">Lowongan</a>
	    	</li>
            <li class="active">Pembukaan Lowongan</li>
	    </ul><!-- /.breadcrumb --
	    <!-- /section:basics/content.searchbox -->
    </div>
</div>

<div class="page-content">
    <div class="row">
    	<div class="col-xs-12">
    		<!-- PAGE CONTENT BEGINS -->
    		<div class="row">
    		    <div class="col-xs-12">
    		        <div class="tabbable">
    		            <ul class="nav nav-tabs padding-18 tab-size-bigger tab-color-blue">
    					    <li class="active">
    					    	<a href="#" data-toggle="tab" aria-expanded="true">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Pembukaan Lowongan</strong>
    					    	</a>
    					    </li>
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-2">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Syarat Pendidikan</strong>
    					    	</a>
    					    </li>
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-3">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Syarat Jurusan</strong>
    					    	</a>
    					    </li>
    		            </ul>
    		            <input type="hidden" id="tab_job_posting_id" value="">
    		            <input type="hidden" id="tab_job_code" value="">
    		        </div>
    		        
    		        <div class="tab-content no-border">
    		            <div class="row">
                            <div class="col-xs-12">       
                               <table id="grid-table"></table>
                               <div id="grid-pager"></div>    
                            </div>
                        </div>    
    		        </div>
    		    </div>    
    	    </div>
    	    
    	    
    		
            <!-- PAGE CONTENT ENDS -->
    	</div><!-- /.col -->
    </div><!-- /.row -->
</div>

<script>
    
    jQuery(function($) {
        $( "#tab-2" ).on( "click", function() {
            var the_id = $("#tab_job_posting_id").val();
            var the_code = $("#tab_job_code").val();
            if(the_id == "") {
                showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Perhatian', 'Pilih salah satu baris data');
                return false;    
            }
            
            loadContentWithParams("recruitment-p_job_education.php", {
                job_posting_id: the_id,
                job_code : the_code
            });
        });
        
        $( "#tab-3" ).on( "click", function() {
            var the_id = $("#tab_job_posting_id").val();
            var the_code = $("#tab_job_code").val();
            if(the_id == "") {
                showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Perhatian', 'Pilih salah satu baris data');
                return false;
            }
            loadContentWithParams("recruitment-p_job_major.php", {
                job_posting_id: the_id,
                job_code : the_code
            });
        });
    });
    
    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        
        $(window).on('resize.jqGrid', function () {
            responsive_jqgrid(grid_selector, pager_selector);
        });
        
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
               responsive_jqgrid(grid_selector, pager_selector);
            }
        });
        
        
        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_job_posting_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID',name: 'job_posting_id', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {label: 'Kode Lamaran', name: 'job_id', width: 120, align: "left", editable: true, hidden:true, 
                    editrules: {edithidden: true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo WS_JQGRID."recruitment.p_job_controller/html_select_options_job"; ?>'}
                },
                {label: 'Kode Lamaran', name: 'job_code', width: 150, align: "left", editable: false},
                {label: 'Deskripsi',name: 'posting_short_desc', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:255
                    },
                    editrules: {required: true}
                },
                {label: 'Nomor Lowongan',name: 'posting_no', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: true}
                },
                {label: 'Tgl Posting', name: 'posting_date', width: 120, editable: true,
                    edittype:"text",
                    editrules: {required: true},
                    editoptions: {
                        // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                        // use it to place a third party control to customize the toolbar
                        dataInit: function (element) {
                           $(element).datepicker({
    			    			autoclose: true,
    			    			format: 'yyyy-mm-dd',
    			    			orientation : 'top',
    			    			todayHighlight : true
                            });
                        }
                    }
                },
                {label: 'Is Active ?',name: 'is_active', width: 100, sortable: true, editable: true,
                    align: 'center',
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'Y': 'YES', 'N': 'NO'}}
                },
                {label: 'Vacancy Letter', name: 'description', width: 150, editable: true, 
                    editrules:{
                       required:true, 
                       edithidden:true
                    }, 
                    hidden:true,
                    align: "left",
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<textarea class="mceEditor"></textarea>');
                            elm.val( value );
                            // give the editor time to initialize
                            setTimeout( function() {
                                try {
                                    tinymce.remove("#" + options.id);
                                } catch(ex) {}
                                tinymce.init({ mode:"specific_textareas", width:650, height:"300", editor_selector : "mceEditor", statusbar:false, menubar:false});
                            }, 100);
                            
                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            if(oper === 'get') {
                                return tinymce.get('description').getContent({format: 'row'});
                            } else if( oper === 'set') {
                                if(tinymce.get('description')) {
                                    tinymce.get('description').setContent( gridval );
                                }
                            }
                        }
                    }
                },
                {label: 'Tgl Pembuatan', name: 'created_date', width: 120, align: "left", editable: false},
                {label: 'Dibuat Oleh', name: 'created_by', width: 120, align: "left", editable: false},
                {label: 'Tgl Update', name: 'updated_date', width: 120, align: "left", editable: false},
                {label: 'Diupdate Oleh', name: 'created_by', width: 120, align: "left", editable: false}
            ],
            height: '100%',
            autowidth: true,
            rowNum: 10,
            viewrecords: true,
            rowList: [5, 10, 20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'job_posting_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'job_code');
                
                var posting_no = $('#grid-table').jqGrid('getCell', rowid, 'posting_no');
                
                $('#tab_job_posting_id').val(celValue);
                $('#tab_job_code').val(celCode + " - " + posting_no);
            },
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                }, 0);

            },

            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."recruitment.p_job_posting_controller/crud"; ?>',
            caption: "Pembukaan Lowongan"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: true,
                editicon: 'ace-icon fa fa-pencil blue',
                add: true,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: true,
                delicon: 'ace-icon fa fa-trash-o red',
                search: true,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    $('#tab_job_posting_id').val("");
                    $('#tab_job_code').val("");
                },

                refreshicon: 'ace-icon fa fa-refresh green',
                view: false,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});
                    /*$("#USER_NAME").prop("readonly", true);*/
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                    $(".mce-widget").hide();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});
                    
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                    $(".mce-widget").hide();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    
                    $(".topinfo").html('<div class="ui-state-success">' + response.message + '</div>'); 
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();
                          
                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    if (form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form(form);

                    form.data('styled', true);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                    style_search_form(form);
                    
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
        );
        
    }); /* end jquery onload */
    
    
    
    function serializeJSON(postdata) {
        var items;
        if(postdata.oper != 'del') {
            items = JSON.stringify(postdata, function(key,value){
                if (typeof value === 'function') {
                    return value();
                } else {
                  return value;
                }
            });
        }else {
            items = postdata.id;
        }

        var jsondata = {items:items, oper:postdata.oper, '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        return jsondata;
    }

    function clearSelection() {

        return null;
    }

    function style_edit_form(form) {
        //enable datepicker on "sdate" field and switches for "stock" field
        form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

        form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
        form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
        //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
        //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


        //update buttons classes
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
        buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

        buttons = form.next().find('.navButton a');
        buttons.find('.ui-icon').hide();
        buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
        buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
    }

    function style_delete_form(form) {
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
        buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
    }

    function style_search_filters(form) {
        form.find('.delete-rule').val('X');
        form.find('.add-rule').addClass('btn btn-xs btn-primary');
        form.find('.add-group').addClass('btn btn-xs btn-success');
        form.find('.delete-group').addClass('btn btn-xs btn-danger');
    }
    function style_search_form(form) {
        var dialog = form.closest('.ui-jqdialog');
        var buttons = dialog.find('.EditTable')
        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
    }

    function beforeDeleteCallback(e) {
        var form = $(e[0]);
        if (form.data('styled')) return false;

        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
        style_delete_form(form);

        form.data('styled', true);
    }

    function beforeEditCallback(e) {
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
        style_edit_form(form);
    }

    function updatePagerIcons(table) {
        var replacement =
        {
            'ui-icon-seek-first': 'ace-icon fa fa-angle-double-left bigger-140',
            'ui-icon-seek-prev': 'ace-icon fa fa-angle-left bigger-140',
            'ui-icon-seek-next': 'ace-icon fa fa-angle-right bigger-140',
            'ui-icon-seek-end': 'ace-icon fa fa-angle-double-right bigger-140'
        };
        $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function () {
            var icon = $(this);
            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

            if ($class in replacement) icon.attr('class', 'ui-icon ' + replacement[$class]);
        })
    }

    function responsive_jqgrid(grid_selector, pager_selector) {
                
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
    }

</script>