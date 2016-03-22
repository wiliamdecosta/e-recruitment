<div id="breadcrumbs" class="breadcrumbs">
    <div id="breadcrumbs" class="breadcrumbs">
	    <ul class="breadcrumb">
	    	<li>
	    		<i class="ace-icon fa fa-home home-icon"></i>
	    		<a href="<?php echo base_url("index.php/panel/index"); ?>">Home</a>
	    	</li>
            <li>
	    		<a href="#">Rekrutment</a>
	    	</li>
            <li class="active">Daftar Pelamar</li>
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
                    <table id="grid-table"></table>
                    <div id="grid-pager"></div>
    		    </div>
    	    </div>
            <!-- PAGE CONTENT ENDS -->
    	</div><!-- /.col -->
    </div><!-- /.row -->
</div>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        $(window).on("resize", function () {
            responsive_jqgrid(grid_selector, pager_selector);
        });

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_applicant_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'applicant_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Nama Lengkap',name: 'applicant_fullname',width: 250, align: "left",editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:60
                    },
                    editrules: {required: true}
                },
                
                {label: 'Pendidikan Terakhir', name: 'education_id', width: 120, align: "left", editable: true, hidden:true, 
                    editrules: {edithidden: true, required:true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo WS_JQGRID."recruitment.p_education_controller/html_select_options_education"; ?>'}
                },
                {label: 'Pendidikan Terakhir', name: 'education_code', width: 150, align: "left", editable: false},
                
                {label: 'Jurusan', name: 'major_id', width: 150, align: "left", editable: true, hidden:true, 
                    editrules: {edithidden: true, required:true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo WS_JQGRID."recruitment.p_college_major_controller/html_select_options_major"; ?>'}
                },
                {label: 'Jurusan', name: 'major_code', width: 150, align: "left", editable: false},
                
                {label: 'Status', name: 'applicant_status_id', width: 120, align: "left", editable: true, hidden:true, 
                    editrules: {edithidden: true, required:true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo WS_JQGRID."recruitment.p_applicant_status_controller/html_select_options_status"; ?>'}
                },
                {label: 'Status', name: 'status_code', width: 150, align: "left", editable: false},
                
                {label: 'Username',name: 'applicant_username',width: 150, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:32,
                        defaultValue: ''
                    },
                    editrules: {required: true},
                    formoptions: {
                        elmsuffix:'<i data-placement="left" class="orange"> Minimum. 8 Karakter</i>'
                    }
                },
                {label: 'Password',name: 'applicant_password',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'password',
                    editoptions: {
                        size: 30,
                        maxlength:15,
                        defaultValue: ''
                    },
                    editrules: {required: false},
                    formoptions: {
                        elmsuffix:'<i data-placement="left" class="orange"> Minimum 8 Karakter</i>'
                    }
                },
                {label: 'Tgl.Lahir', name: 'applicant_date_of_birth', width: 120, editable: true,
                    edittype:"text",
                    editrules: {required: true},
                    editoptions: {
                        dataInit: function (element) {
                           $(element).datepicker({
    			    			autoclose: true,
    			    			format: 'yyyy-mm-dd',
    			    			orientation : 'bottom',
    			    			todayHighlight : true
                            });
                        }
                    }
                },
                {label: 'No.KTP',name: 'applicant_ktp_no',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:16,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                        }
                    },
                    editrules: {edithidden: true, required: true},
                    formoptions: {
                        elmsuffix:'<i data-placement="left" class="orange"> 16 Karakter</i>'
                    }
                },
                {label: 'Email',name: 'applicant_email',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:60
                    },
                    editrules: {edithidden: true, email:true, required: true}
                },
                {label: 'No.Telp',name: 'applicant_telp',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 20,
                        maxlength:20,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                        }
                    },
                    editrules: {edithidden: true, required: true}
                },
                {label: 'No.HP',name: 'applicant_hp',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 20,
                        maxlength:20,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                        }
                    },
                    editrules: {edithidden: true, required: true}
                },
                {label: 'Kota',name: 'applicant_city',width: 150, hidden:true, align: "center",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 32,
                        maxlength:32
                    },
                    editrules: {edithidden: true, required: true}
                },
                {label: 'Alamat',name: 'applicant_address',width: 200, hidden:true, align: "left",editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:50,
                        maxlength:100
                    },
                    editrules: {edithidden: true, required: true}
                },
                {label: 'Tgl Pembuatan', name: 'created_date', width: 120, align: "left", editable: false},
                {label: 'Dibuat Oleh', name: 'created_by', width: 120, align: "left", editable: false},
                {label: 'Tgl Update', name: 'updated_date', width: 120, align: "left", editable: false},
                {label: 'Diupdate Oleh', name: 'created_by', width: 120, align: "left", editable: false}
            ],
            height: '100%',
            autowidth: true,
            rowNum: 20,
            viewrecords: true,
            rowList: [5, 10, 20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'p_doc_type_id');

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
            editurl: '<?php echo WS_JQGRID."recruitment.p_applicant_controller/crud"; ?>',
            caption: "Daftar Pelamar",
            
            subGrid: true, // set the subGrid property to true to show expand buttons for each row
            subGridRowExpanded: showApplicantDocs, // javascript function that will take care of showing the child grid
            subGridOptions : {
                reloadOnExpand :false,
                selectOnExpand : false,
                plusicon : "ace-icon fa fa-folder center bigger-110 pink",
                minusicon  : "ace-icon fa fa-folder-open center bigger-110 pink"
                // openicon : "ace-icon fa fa-chevron-right center orange"
            }

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
                    
                    $("#applicant_username").prop("readonly", true);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
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
                    
                    $("#tr_applicant_password", form).show();
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
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
    
    function showApplicantDocs(parentRowID, parentRowKey) {
        var childGridID = parentRowID + "_table";
        var childGridPagerID = parentRowID + "_pager";
        
        var parentGrid = $('#grid-table');
        var celValue = parentGrid.jqGrid ('getCell', parentRowKey, 'applicant_fullname');
        
        $('#' + parentRowID).append('<br><span class="label label-pink">'+
                                    'Data Dokumen Pelamar :: '+ celValue +
                                    '</span>');
        // add a table and pager HTML elements to the parent grid row - we will render the child grid here
        $('#' + parentRowID).append('<table id="' + childGridID + '"></table><div id="' + childGridPagerID + '"></div>');

        $("#" + childGridID).jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_applicant_doc_controller/read"; ?>',
            mtype: "POST",
            datatype: "json",
            page: 1,
            rowNum: 10,
            height: 'auto',
            autowidth: true,
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            postData:{ applicant_id: encodeURIComponent(parentRowKey) },
            colModel: [
                {label: 'ID', name: 'p_applicant_doc_id', key: true, width:125, sorttype:'number', editable: true, hidden:true },
                {label: 'Jenis Dokumen', name: 'p_doc_type_id', width: 150, align: "left", editable: true, hidden:true, 
                    editrules: {edithidden: true, required:true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo WS_JQGRID."recruitment.p_doc_type_controller/html_select_options_doc_type"; ?>'}
                },
                {label: 'Download',name: 'link_file',width: 80, align: "center",editable: false,
                    formatter: function(cellvalue, options, rowObject) {
                        return '<a href="<?php echo UPLOAD_PATH."'+ cellvalue +'#"; ?>" target="_blank"> <i class="ace-icon fa fa-download bigger-120"></i> </a>';
                    }
                },
                {label: 'Jenis Dokumen', name: 'doc_type_code', width: 150, align: "left", editable: false},
                {label: 'Nama File',name: 'applicant_doc_file',width: 350, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:255
                    },
                    editrules: {required: true}
                },
                {label: 'Tgl Pembuatan', name: 'created_date', width: 120, align: "left", editable: false},
                {label: 'Dibuat Oleh', name: 'created_by', width: 120, align: "left", editable: false},
                {label: 'Tgl Update', name: 'updated_date', width: 120, align: "left", editable: false},
                {label: 'Diupdate Oleh', name: 'created_by', width: 120, align: "left", editable: false}
            ],
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
            pager:childGridPagerID,
            editurl: '<?php echo WS_JQGRID."recruitment.p_applicant_doc_controller/crud"; ?>',
            rowList: [],        // disable page size dropdown
            pgbuttons: false,     // disable page control like next, back button
            pgtext: null,         // disable pager text like 'Page 0 of 10'
            viewrecords: false    // disable current view record text like 'View 1-10 of 100'
        });
        
        jQuery("#"+childGridID).jqGrid('navGrid',"#"+childGridPagerID,
            {   
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
                },
                refreshicon: 'ace-icon fa fa-refresh green',
                view: false,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },
            {
                // options for the Edit Dialog
                editData: {
                    applicant_id: function () {
                        var data = $("#"+childGridID).jqGrid('getGridParam', 'postData');
                        return data.applicant_id;
                    }
                },
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
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
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
                    applicant_id: function () {
                        var data = $("#"+childGridID).jqGrid('getGridParam', 'postData');
                        return data.applicant_id;
                    }
                },
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
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
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
        
    }
    
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