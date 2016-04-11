<script src="<?php echo BS_PATH; ?>tinymce/tinymce.min.js"></script>
<script src="<?php echo BS_PATH; ?>tinymce/jquery.tinymce.min.js"></script>

<div id="breadcrumbs" class="breadcrumbs">
    <div id="breadcrumbs" class="breadcrumbs">
	    <ul class="breadcrumb">
	    	<li>
	    		<i class="ace-icon fa fa-home home-icon"></i>
	    		<a href="<?php echo base_url("panel/index"); ?>">Home</a>
	    	</li>
            <li>
	    		<a href="#">Lowongan</a>
	    	</li>
            <li class="active">Email Interview Template</li>
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
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-1">
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
                            <li class="active">
                                <a href="#" data-toggle="tab" aria-expanded="true" id="tab-4">
                                    <i class="blue bigger-120"></i>
                                    <strong>Email Interview Template</strong>
                                </a>
                            </li>
    		            </ul>
    		            <input type="hidden" id="tab_job_posting_id" value="<?php echo getVarClean('job_posting_id','int',0); ?>">
    		            <input type="hidden" id="tab_job_code" value="<?php echo getVarClean('job_code','str',''); ?>">

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
        $( "#tab-1" ).on( "click", function() {
            loadContent("recruitment-p_job_posting.php");
        });
        
        $( "#tab-2" ).on( "click", function() {
            var the_id = $("#tab_job_posting_id").val();
            var the_code = $("#tab_job_code").val();
            
            loadContentWithParams("recruitment-p_job_education.php", {
                job_posting_id: the_id,
                job_code: the_code
            });
        });

        $( "#tab-3" ).on( "click", function() {
            var the_id = $("#tab_job_posting_id").val();
            var the_code = $("#tab_job_code").val();
            
            loadContentWithParams("recruitment-p_job_major.php", {
                job_posting_id: the_id,
                job_code: the_code
            });
        });
    });
    
    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        $(window).on("resize", function () {
            responsive_jqgrid(grid_selector, pager_selector);
        });

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_email_template_controller/read"; ?>',
            postData : {job_posting_id : $("#tab_job_posting_id").val()},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'email_tpl_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Job Posting ID', name: 'job_posting_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Subject Email',name: 'email_tpl_subject', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:100,
                        defaultValue: 'Interview PDAM Tirtawening'
                    },
                    editrules: {required: true},
                    formoptions: {
                        elmsuffix:'<i data-placement="left" class="orange"> Subject Email Silahkan Diubah </i>'
                    }
                },
                {label: 'Keterangan',name: 'email_tpl_description', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 80,
                        maxlength:255
                    }
                },
                {label: 'Isi Email', name: 'email_tpl_content', width: 150, editable: true, 
                    editrules:{
                       required:false, 
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
                                tinymce.init({ mode:"specific_textareas", width:650, height:"300", editor_selector : "mceEditor", statusbar:false, menubar:false,
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                                        'insertdatetime media nonbreaking save table contextmenu directionality',
                                        'emoticons template paste textcolor colorpicker textpattern imagetools'
                                    ],
                                    toolbar1: 'insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                                    toolbar2: 'print | forecolor backcolor emoticons',
                                    image_advtab: true
                                });
                            }, 100);
                            
                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            if(oper === 'get') {
                                return tinymce.get('email_tpl_content').getContent({format: 'row'});
                            } else if( oper === 'set') {
                                if(tinymce.get('email_tpl_content')) {
                                    tinymce.get('email_tpl_content').setContent( gridval );
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
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'job_edu_id');

            },
            sortorder:'',
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) { 
                    showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                }
                
                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                }, 0);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."recruitment.p_email_template_controller/crud"; ?>',
            caption: "Email Interview :: " + $("#tab_job_code").val()

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
                    jQuery("#detailsPlaceholder").hide();
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
                viewPagerButtons: false,
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
                editData: { 
                    job_posting_id: function() {
                        return $("#tab_job_posting_id").val();
                    }
                },
                closeAfterAdd: true,
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
                beforeInitData:function(form_id) {
                    jQuery("#grid-table").jqGrid('resetSelection');
                    return true;
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

    });

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
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );
 
    }

</script>