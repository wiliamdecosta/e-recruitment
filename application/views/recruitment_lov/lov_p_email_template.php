<script src="<?php echo BS_PATH; ?>tinymce/tinymce.min.js"></script>
<script src="<?php echo BS_PATH; ?>tinymce/jquery.tinymce.min.js"></script>

<div id="modal_lov_email_template" class="modal fade" tabindex="-1" style="overflow-y: scroll;z-index:2;">
	<div class="modal-dialog">
		<div class="modal-content">
		    <!-- modal title -->
			<div class="modal-header no-padding">
				<div class="table-header">
					<span class="form-add-edit-title"> Data Template Email List </span>
				</div>
			</div>
            <input type="hidden" id="modal_lov_email_template_id_val" value="" />
            <input type="hidden" id="modal_lov_email_template_code_val" value="" />
            <input type="hidden" id="modal_lov_email_template_job_posting_id" value="" />
			<!-- modal body -->
			<div class="modal-body">
			    <p>
              <button type="button" class="btn btn-sm btn-success" id="modal_lov_email_template_btn_blank">
  	           <span class="fa fa-pencil-square-o" aria-hidden="true"></span> BLANK
              </button>
          </p> 
				   
          <div class="row">
              <div class="col-xs-12">
                <table id="grid-table-lov_email_template" width="100%"></table>
                <div id="grid-pager-lov_email_template"></div>    
              </div>
          </div>
			</div>

			<!-- modal footer -->
			<div class="modal-footer no-margin-top">
			    <div class="bootstrap-dialog-footer">
			        <div class="bootstrap-dialog-footer-buttons">
        				<button class="btn btn-danger btn-xs radius-4" data-dismiss="modal">
        					<i class="ace-icon fa fa-times"></i>
        					Close
        				</button>
    				</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>
    
    jQuery(function($) {
        $("#modal_lov_email_template_btn_blank").on(ace.click_event, function() {
            $("#"+ $("#modal_lov_email_template_id_val").val()).val("");
            $("#"+ $("#modal_lov_email_template_code_val").val()).val(""); 
            $("#modal_lov_email_template").modal("toggle"); 
        });
    });
    
    function modal_lov_email_template_show(the_id_field, the_code_field, p_job_posting_id) {
        modal_lov_email_template_set_field_value(the_id_field, the_code_field); 
        $("#modal_lov_email_template_job_posting_id").val( p_job_posting_id );
        $("#modal_lov_email_template").modal({backdrop: 'static'});

        modal_lov_email_template_prepare_table();
    }
        
    function modal_lov_email_template_set_field_value(the_id_field, the_code_field) {
         $("#modal_lov_email_template_id_val").val(the_id_field);
         $("#modal_lov_email_template_code_val").val(the_code_field);
    }
    
    function modal_lov_email_template_fill_value(rowKey) {
         var code_val = $('#grid-table-lov_email_template').jqGrid('getCell', rowKey, 'email_tpl_subject');
         modal_lov_email_template_set_value(rowKey, code_val);
    }

    function modal_lov_email_template_set_value(the_id_val, the_code_val) {  
         $("#"+ $("#modal_lov_email_template_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_email_template_code_val").val()).val(the_code_val);                              
         $("#modal_lov_email_template").modal("toggle");
    }
    
    function modal_lov_email_template_prepare_table() {

        var grid_selector = "#grid-table-lov_email_template";
        var pager_selector = "#grid-pager-lov_email_template";

        jQuery("#grid-table-lov_email_template").jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_email_template_controller/read"; ?>',
            postData : {job_posting_id : $("#modal_lov_email_template_job_posting_id").val()},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'email_tpl_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Job Posting ID', name: 'job_posting_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Pilih',name: 'email_tpl_id',width: 80, align: "center",editable: false,
                    formatter: function(cellvalue, options, rowObject) {
                        return '<a href="#'+ $("#modal_lov_email_template_code_val").val() +'" onclick="modal_lov_email_template_fill_value('+cellvalue+');"> <i class="ace-icon fa fa-pencil-square-o bigger-200"></i> </a>';
                    }
                },
                {label: 'Subject Email',name: 'email_tpl_subject', width: 250, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:100,
                        defaultValue: 'Interview PDAM Tirtawening'
                    }
                },
                {label: 'Keterangan',name: 'email_tpl_description', width: 250, sortable: true, editable: true,
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
                                        'print'
                                    ],
                                    toolbar1: 'print',
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
                }
            ],
            height: '100%',
            autowidth: true,
            rowNum: 10,
            viewrecords: true,
            rowList: [5],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                

            },
            sortorder:'',
            onSortCol: modal_lov_email_template_clearSelection,
            onPaging: modal_lov_email_template_clearSelection,
            pager: '#grid-pager-lov_email_template',
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
                    modal_lov_email_template_updatePagerIcons(table);
                }, 0);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."recruitment.p_email_template_controller/crud"; ?>',
            caption: "Email Interview Template"

        });

        jQuery('#grid-table-lov_email_template').jqGrid('navGrid', '#grid-pager-lov_email_template',
            {   //navbar options
                edit: true,
                editicon: 'ace-icon fa fa-search-plus grey',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
                delicon: 'ace-icon fa fa-trash-o red',
                search: false,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                },

                refreshicon: 'ace-icon fa fa-refresh green',
                view: false,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },

            {
                // options for the Edit Dialog
                editCaption : 'View Record',
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                viewPagerButtons: false,
                serializeEditData: modal_lov_email_template_serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    modal_lov_email_template_style_edit_form(form);

                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});

                    form.parent().find('#sData').hide();
                    form.find('input[type="text"], textarea').prop("style", "border:0px; background:#ffffff !important; ");
                    form.find('select').prop("style", "border:0px;-webkit-appearance: none;-moz-appearance: none;appearance: none;");
                    
                    form.find('input[type="text"]').prop("readonly", true);
                    form.find('select').prop("disabled", true);
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
                        return $("#modal_lov_email_template_job_posting_id").val();
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
                serializeEditData: modal_lov_email_template_serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    modal_lov_email_template_style_edit_form(form);

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
                serializeDelData: modal_lov_email_template_serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    if (form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    modal_lov_email_template_style_delete_form(form);

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
                    modal_lov_email_template_style_search_form(form);
                    
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    modal_lov_email_template_style_search_filters($(this));
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

        modal_lov_email_template_responsive_jqgrid(grid_selector, pager_selector);
    }
    

    function modal_lov_email_template_serializeJSON(postdata) {
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

    function modal_lov_email_template_clearSelection() {

        return null;
    }

    function modal_lov_email_template_style_edit_form(form) {
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

    function modal_lov_email_template_style_delete_form(form) {
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
        buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
    }

    function modal_lov_email_template_style_search_filters(form) {
        form.find('.delete-rule').val('X');
        form.find('.add-rule').addClass('btn btn-xs btn-primary');
        form.find('.add-group').addClass('btn btn-xs btn-success');
        form.find('.delete-group').addClass('btn btn-xs btn-danger');
    }
    function modal_lov_email_template_style_search_form(form) {
        var dialog = form.closest('.ui-jqdialog');
        var buttons = dialog.find('.EditTable')
        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
    }

    function modal_lov_email_template_beforeDeleteCallback(e) {
        var form = $(e[0]);
        if (form.data('styled')) return false;

        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
        modal_lov_email_template_style_delete_form(form);

        form.data('styled', true);
    }

    function modal_lov_email_template_beforeEditCallback(e) {
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
        modal_lov_email_template_style_edit_form(form);
    }

    function modal_lov_email_template_updatePagerIcons(table) {
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

    function modal_lov_email_template_responsive_jqgrid(grid_selector, pager_selector) {
                
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".modal-dialog").width() - 30 );
        $(pager_selector).jqGrid( 'setGridWidth', $(".modal-dialog").width() - 30 );
 
    }
</script>