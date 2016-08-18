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
	    		<a href="#">Parameter</a>
	    	</li>
            <li class="active">Pengumuman Peserta Lulus</li>
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

<?php $this->load->view('recruitment_lov/lov_job_posting.php'); ?>

<script>

    function showLovLowongan(id, code) {
        modal_lov_job_posting_show(id, code);
    }

    function clearLovLowongan() {
        $('#form_job_posting_id').val('');
        $('#form_posting_no').val('');
    }

    function setLinkPdf(id) {
        var url = "<?php echo base_url().'pdf_pelamar_lulus/show?id='; ?>" + id;
        if(id == "") {
            url = "";
        }
        $("#file_upload").val(url);
    }

    function sendMailInfo(job_posting_id, posting_no, announcement_id ) {

        BootstrapDialog.confirm({
             title:'Send Email Announcement To Applicants',
             type : BootstrapDialog.TYPE_WARNING,
             message: 'Apakah Anda yakin untuk mengirim email pengumuman kepada para pelamar-pelamar yang lulus untuk lowongan : '+ posting_no +' ?',
             btnCancelLabel: 'Tidak, Batalkan',
             btnOKLabel: 'Ya, Yakin',
             callback: function(result) {
                 if(result) {
                     $.post( '<?php echo WS_JQGRID."recruitment.p_announcement_controller/send_email_announcement"; ?>',
                         {
                           job_posting_id: job_posting_id,
                           posting_no : posting_no,
                           announcement_id : announcement_id
                         },
                         function( response ) {
                             if(response.success == false) {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Perhatian', response.message);
                             }else {
                                showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Berhasil', response.message);
                             }
                         }
                     );
                 }
             }
         });

    }

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        $(window).on("resize", function () {
            responsive_jqgrid(grid_selector, pager_selector);
        });

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_announcement_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'announcement_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Kirim Email Info', name: 'job_posting_id', width: 150,  sortable:false, search:false, align:"center", editable: false,
                    formatter: function(cellvalue, options, rowObject) {
                        var posting_no = rowObject['posting_no'];
                        var announcement_id = rowObject['announcement_id'];
                        return '<button type="button" class="btn btn-xs btn-primary" onclick="sendMailInfo('+cellvalue+', \''+posting_no+'\', \''+announcement_id+'\')"> Send Mail </button>';
                    }
                },
                {label: 'Judul Pengumuman',name: 'announcement_title',width: 225, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:32
                    },
                    editrules: {required: true}
                },
                {label: 'Untuk Lowongan', name: 'posting_no', width: 200, align: "left", editable: false},
                {
                    label: 'Untuk Lowongan',
                    name: 'job_posting_id',
                    width: 150,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, number:true, required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_job_posting_id" type="text"  style="display:none;" onChange="setLinkPdf(this.value);">'+
                                        '<input id="form_posting_no" disabled type="text" class="col-xs-4 jqgrid-required" placeholder="Pilih Lowongan">'+
                                        '<button class="btn btn-warning btn-sm" type="button" onclick="showLovLowongan(\'form_job_posting_id\',\'form_posting_no\')">'+
                                        '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                        '</button>');
                                $("#form_job_posting_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_job_posting_id").val();
                            } else if( oper === 'set') {
                                $("#form_job_posting_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'posting_no');
                                        $("#form_posting_no").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Link PDF',name: 'file_upload',width: 225, align: "left",editable: true, hidden:true,
                    edittype: 'text',
                    editoptions: {
                        size: 50,
                        maxlength:32
                    },
                    editrules: {edithidden:true, required: false}
                },
                {label: 'Link PDF',name: 'file_upload',width: 225, align: "left",editable: false,
                    formatter:function(cellvalue, options, rowObject) {
                        if(cellvalue == "" || cellvalue == null) {
                            return '';
                        }else {
                            return '<a href="'+cellvalue+'" target="_blank">Download PDF</a>';
                        }
                    }
                },
                {label: 'Publish ?',name: 'publish_status', width: 100, sortable: true, editable: true,
                    align: 'center',
                    editrules: {required:true, edithidden: true},
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'Y': 'YES', 'N': 'NO'}}
                },
                {label: 'Tgl Pengumuman', name: 'announcement_date', width: 160, editable: true,
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
                {label: 'Isi Pengumuman', name: 'announcement_letter', width: 150, editable: true,
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
                                    toolbar2: 'print | forecolor backcolor emoticons | link',
                                    image_advtab: true
                                });
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            if(oper === 'get') {
                                return tinymce.get('announcement_letter').getContent({format: 'row'});
                            } else if( oper === 'set') {
                                if(tinymce.get('announcement_letter')) {
                                    tinymce.get('announcement_letter').setContent( gridval );
                                }
                            }
                        }
                    }
                },
                {label: 'Tgl Pengiriman Email', name: 'send_mail_date', width: 160, align: "left", editable: false},
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
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'announcement_id');

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
            editurl: '<?php echo WS_JQGRID."recruitment.p_announcement_controller/crud"; ?>',
            caption: "Pengumuman Pelamar Lulus"

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

                    $("#file_upload").prop("readonly", true);
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
                    $("#file_upload").prop("readonly", true);

                    setTimeout(function() {
                        clearLovLowongan();
                    },100);
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

    /*function ajaxFileUpload(id)
    {

        $.ajax ({
                type:'POST',
                url: '',
                secureuri: true,
                fileElementId: 'file_upload',
                dataType: 'json',
                data: { id: id },
                processData: true, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function (data, status) {
                    if (typeof (data.success) != 'undefined') {
                        if (data.success == true) {
                            return;
                        } else {
                            alert(data.message);
                        }
                    }
                    else {
                        return alert('Failed to upload file!');
                    }
                },
                error: function (data, status, e) {
                    return alert('Failed to upload file!');
                }
            }
        );
    }*/

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