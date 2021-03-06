<script src="<?php echo BS_PATH; ?>tinymce/tinymce.min.js"></script>
<script src="<?php echo BS_PATH; ?>tinymce/jquery.tinymce.min.js"></script>
<style>
    .approve-bg {
        background: #A6E4FD !important;
        font-size:inherit;
    }

    .email-sent-bg {
        background: #BFFA37 !important;
        font-size:inherit;
    }

</style>
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
            <li class="active">Filter Pelamar</li>
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
            <div class="space-4"></div>
            <div class="row" id="detail_placeholder" style="display:none;">
                <div class="col-xs-12">
                    <div class="hr hr-dotted"></div>
                </div>
                <div class="col-xs-5">
                    <div class="space-2"></div>
                    <span class="ace-icon fa fa-info-circle bigger-120 light grey"> </span> <strong class="grey">Keterangan Warna Record:</strong>
                    <div class="space-2"></div>
                    <label class="approve-bg" style="padding:5px;"> &nbsp; </label> Pelamar Diapprove <br>
                    <label class="email-sent-bg" style="padding:5px;"> &nbsp; </label> Email interview telah dikirim ke Pelamar
                </div>
                <div class="col-xs-7" style="margin-bottom:50px;">
                    <div class="space-2"></div>
                    <div>
                            <span class="ace-icon fa fa-info-circle bigger-120 light grey"> </span> <strong id="info-apply-job" class="grey">Informasi Apply Job :</strong>
                            <div class="space-2"></div>
                            <div class="infobox-container">
                                <div class="infobox infobox-red">
                                    <div class="infobox-icon">
                                        <i class="ace-icon fa fa-users"></i>
                                    </div>
                                    <div class="infobox-data">
                                        <span class="infobox-data-number" id="info-box-pelamar">...</span>
                                        <div class="infobox-content">Pelamar</div>
                                    </div>
                                </div>

                                <div class="infobox infobox-blue">
                                    <div class="infobox-icon">
                                        <i class="ace-icon glyphicon glyphicon-check"></i>
                                    </div>
                                    <div class="infobox-data">
                                        <span class="infobox-data-number" id="info-box-pelamar-approve">...</span>
                                        <div class="infobox-content">Pelamar Approve</div>
                                    </div>
                                </div>

                                <div class="infobox infobox-green">
                                    <div class="infobox-icon">
                                        <i class="ace-icon fa fa-envelope"></i>
                                    </div>
                                    <div class="infobox-data">
                                        <span class="infobox-data-number" id="info-box-email-terkirim">...</span>
                                        <div class="infobox-content">Email Terkirim</div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col-xs-5">
                    <button class="btn btn-sm btn-primary" id="set_approve_pelamar">
                        <i class="ace-icon glyphicon glyphicon-check"></i>
                        Approve Pelamar
                    </button>
                </div>

                <div class="col-xs-3">
                    <div class="input-group">
                        <input id="form_email_template_id" type="text" placeholder="Icon ID" style="display:none;">
                         <input id="form_email_template_subject" readonly class="form-control" type="text" placeholder="Pilih Template Email">
                         <span class="input-group-btn">
                            <button class="btn btn-sm btn-success" type="button" id="btn_lov_email_template">
                                <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
                            </button>
                         </span>
                     </div>
                </div>
                <div class="col-xs-4">
                     <button class="btn btn-sm btn-success" id="send_email_pelamar">
                         <i class="ace-icon fa fa-envelope bigger-120"></i>
                         <span id="send_email_pelamar_text">Email Interview</span>
                     </button>
                </div>

                <div class="col-xs-12">
                    <div class="space-4"></div>
                    <table id="grid-table-detail"></table>
                    <div id="grid-pager-detail"></div>
                    <div class="space-4"></div>
                </div>

            </div>

            <!-- PAGE CONTENT ENDS -->
    	</div><!-- /.col -->
    </div><!-- /.row -->
</div>

<?php $this->load->view('recruitment_lov/lov_p_email_template.php'); ?>

<script>

    jQuery(function($) {

        $("#btn_lov_email_template").on("click", function() {

            var grid = $("#grid-table-detail");
            var data = grid.jqGrid('getGridParam', 'postData');
            var job_posting_id = data.job_posting_id;

            modal_lov_email_template_show('form_email_template_id','form_email_template_subject', job_posting_id);
        });

        $('#send_email_pelamar').on('click', function() {

             if( $("#form_email_template_id").val() == "" ) {
                showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Perhatian', 'Silahkan pilih template email interview');
                return;
             }

             var grid = $("#grid-table-detail");
             var data = grid.jqGrid('getGridParam', 'postData');
             var job_posting_id = data.job_posting_id;
             var email_tpl_id = $("#form_email_template_id").val();

             BootstrapDialog.confirm({
                 title:'Email Interview',
                 type : BootstrapDialog.TYPE_WARNING,
                 message: 'Apakah Anda yakin untuk mengirim email interview ke pelamar-pelamar yang telah diapprove?',
                 btnCancelLabel: 'Tidak, Batalkan',
                 btnOKLabel: 'Ya, Yakin',
                 callback: function(result) {
                     if(result) {
                         $.post( '<?php echo WS_JQGRID."recruitment.t_applicant_job_controller/send_email_interview"; ?>',
                             {
                               job_posting_id: job_posting_id ,
                               email_tpl_id : email_tpl_id
                             },
                             function( response ) {
                                 if(response.success == false) {
                                    showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Perhatian', response.message);
                                 }else {
                                    showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Berhasil', response.message);
                                    grid.trigger("reloadGrid");
                                 }
                             }
                         );
                     }
                 }
             });
        });


        $('#set_approve_pelamar').on('click', function() {

            var grid = $("#grid-table-detail");
            var cellIDs = grid.jqGrid("getGridParam", "selarrrow");

            if( cellIDs.length > 0) {

                BootstrapDialog.confirm({
                    title:'Approve Confirmation',
                    type : BootstrapDialog.TYPE_INFO,
                    message: 'Apakah Anda yakin untuk menyetujui '+ cellIDs.length +' pelamar yang bersangkutan?',
                    btnCancelLabel: 'Tidak, Batalkan',
                    btnOKLabel: 'Ya, Yakin',
                    callback: function(result) {
                        if(result) {
                            $.post( '<?php echo WS_JQGRID."recruitment.t_applicant_job_controller/approve_applicants"; ?>',
                                {items: cellIDs.toString() },
                                function( response ) {
                                    if(response.success == false) {
                                        showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Perhatian', response.message);
                                    }else {
                                        showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Berhasil', response.message);
                                        grid.trigger("reloadGrid");
                                    }
                                }
                            );
                        }
                    }
                });

            }else {
                showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Perhatian', 'Silahkan checklist pelamar-pelamar yang ingin diapprove');
            }

        });
    });

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        $(window).on('resize.jqGrid', function () {
            responsive_jqgrid(grid_selector, pager_selector);
            responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
        });

        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
               responsive_jqgrid(grid_selector, pager_selector);
               responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
            }
        });

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_job_posting_controller/read"; ?>',
            postData : {is_active:'Y'},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID',name: 'job_posting_id', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {label: 'Excel Pelamar',name: '',width: 155, align: "center",editable: false,
                    formatter:function(cellvalue, options, rowObject) {
                        return '<a class="btn btn-success btn-xs" href="#" onclick="downloadExcelPelamar('+rowObject['job_posting_id']+')"><i class="fa fa-download"></i> Pelamar</a>';
                    }
                },
                {label: 'Kode Lamaran', name: 'job_id', width: 120, align: "left", editable: true, hidden:true,
                    editrules: {edithidden: true},
                    edittype: 'select',
                    editoptions: {
                        dataUrl: '<?php echo WS_JQGRID."recruitment.p_job_controller/html_select_options_job"; ?>',
                        buildSelect: function (data) {
                            if(data !== 'object' ) return data;

                            var response = $.parseJSON(data);
                            if(response.success == false) {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                                return "";
                            }
                        }
                    }
                },
                {label: 'Kode Lamaran', name: 'job_code', width: 150, align: "left", editable: false},
                {label: 'Deskripsi',name: 'posting_short_desc', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:255
                    },
                    editrules: {required: false}
                },
                {label: 'Min.IPK',name: 'posting_min_ipk', width: 125, sortable: true, editable: true,
                    editoptions: {
                        size: 10,
                        maxlength:4
                    },
                    editrules: {required: false, number:true, minValue:0, maxValue: 4}
                },
                {label: 'Batasan Gender ?',name: 'gender', width: 150, sortable: true, editable: true,
                    align: 'center',
                    editrules: {required:false, edithidden: true},
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'': 'Semua Gender', 'L': 'Hanya Laki-laki', 'P':'Hanya Perempuan'}}
                },
                {label: 'Nomor Lowongan',name: 'posting_no', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: false}
                },
                {label: 'Tgl Posting', name: 'posting_date', width: 120, editable: true,
                    edittype:"text",
                    editrules: {required: false}
                },
                {label: 'Is Active ?',name: 'is_active', width: 100, sortable: true, editable: true,
                    align: 'center',
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'Y': 'YES', 'N': 'NO'}}
                },
                {label: 'Vacancy Letter', name: 'description', width: 150, editable: true,
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

                var no_lowongan = $('#grid-table').jqGrid('getCell', rowid, 'posting_no');

                var grid_detail = jQuery("#grid-table-detail");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: '<?php echo WS_JQGRID."recruitment.t_applicant_job_controller/read"; ?>',
                        postData: {job_posting_id: rowid}
                    });
                    var strCaption = 'Daftar Pelamar :: ' + celCode + ' - ' + no_lowongan;
                    grid_detail.jqGrid('setCaption', strCaption);
                    jQuery("#send_email_pelamar_text").html('Email Interview Ke Pelamar Approve ('+ celCode + ' - ' + no_lowongan +')');
                    jQuery("#grid-table-detail").trigger("reloadGrid");
                    jQuery("#info-apply-job").html("Informasi Apply Job ( "+ no_lowongan +" ) : ");

                    jQuery("#form_email_template_id").val("");
                    jQuery("#form_email_template_subject").val("");

                    jQuery("#detail_placeholder").show();
                    responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
                }

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
            editurl: '<?php echo WS_JQGRID."recruitment.p_job_posting_controller/crud"; ?>',
            caption: "Daftar Lowongan Aktif"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: true,
                editicon: 'ace-icon fa fa-search-plus grey',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
                delicon: 'ace-icon fa fa-trash-o red',
                search: true,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    jQuery("#detail_placeholder").hide();
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


        /* --------- jqgrid detail --------- */
        jQuery("#grid-table-detail").jqGrid({
            mtype: "POST",
            datatype: "json",
            colModel: [
                {label: 'ID Applicant Job', name: 'applicant_job_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'ID Applicant', name: 'applicant_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'No.Registrasi',name: 'applicant_no_reg',width: 120, align: "left",editable: true,
                    editoptions: {
                        size: 20,
                        maxlength:60
                    },
                    editrules: {required: false}
                },
                {label: 'Tgl Apply', name: 'created_date', width: 100, align: "left", editable: false},
                {label: 'Nama Lengkap',name: 'applicant_fullname',width: 250, align: "left",editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:60
                    },
                    editrules: {required: false}
                },
                {label: 'Jenis Kelamin',name: 'gender', width: 120, sortable: true, editable: true,
                    align: 'center',
                    editrules: {required:false, edithidden: true},
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'L': 'Laki-laki', 'P':'Perempuan'}}
                },
                {label: 'IPK',name: 'applicant_ipk', width: 85, hidden:false, sortable: true, editable: true,
                    editoptions: {
                        size: 10,
                        maxlength:4
                    },
                    editrules: {required: false, number:true, minValue:0, maxValue: 4}
                },
                {label: 'Pendidikan Terakhir', name: 'education_id', width: 120, align: "left", editable: true, hidden:true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'select',
                    editoptions: {
                        dataUrl: '<?php echo WS_JQGRID."recruitment.p_education_controller/html_select_options_education"; ?>',
                        buildSelect: function (data) {
                            if(data !== 'object' ) return data;

                            var response = $.parseJSON(data);
                            if(response.success == false) {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                                return "";
                            }
                        }
                    }
                },
                {label: 'Pendidikan Terakhir', name: 'education_code', width: 150, align: "left", editable: false},

                {label: 'Jurusan', name: 'major_id', width: 150, align: "left", editable: true, hidden:true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'select',
                    editoptions: {
                        dataUrl: '<?php echo WS_JQGRID."recruitment.p_college_major_controller/html_select_options_major"; ?>',
                        buildSelect: function (data) {
                            if(data !== 'object' ) return data;

                            var response = $.parseJSON(data);
                            if(response.success == false) {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                                return "";
                            }
                        }
                    }
                },
                {label: 'Jurusan', name: 'major_code', width: 150, align: "left", editable: false},
                {label: 'Asal Kota', name: 'applicant_city', width: 170, align: "left", editable: false},
                {label: 'Status', name: 'applicant_status_id', width: 120, align: "left", editable: true, hidden:true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'select',
                    editoptions: {
                        dataUrl: '<?php echo WS_JQGRID."recruitment.p_applicant_status_controller/html_select_options_status"; ?>',
                        buildSelect: function (data) {
                            if(data !== 'object' ) return data;

                            var response = $.parseJSON(data);
                            if(response.success == false) {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                                return "";
                            }
                        }
                    }
                },
                {label: 'Status', name: 'status_code', width: 150, align: "left", editable: false},

                {label: 'Username',name: 'applicant_username',width: 150, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:32,
                        defaultValue: ''
                    },
                    editrules: {required: false}
                },
                {label: 'Password',name: 'applicant_password',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'password',
                    editoptions: {
                        size: 30,
                        maxlength:15,
                        defaultValue: ''
                    },
                    editrules: {required: false}
                },
                {label: 'Tgl.Lahir', name: 'applicant_date_of_birth', width: 120, editable: true,
                    edittype:"text",
                    editrules: {required: false}
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
                    editrules: {edithidden: true, required: false}
                },
                {label: 'Email',name: 'applicant_email',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:60
                    },
                    editrules: {edithidden: true, email:true, required: false}
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
                    editrules: {edithidden: true, required: false}
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
                    editrules: {edithidden: true, required: false}
                },
                {label: 'Kota',name: 'applicant_city',width: 150, hidden:true, align: "center",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 32,
                        maxlength:32
                    },
                    editrules: {edithidden: true, required: false}
                },
                {label: 'Alamat',name: 'applicant_address',width: 200, hidden:true, align: "left",editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:50,
                        maxlength:100
                    },
                    editrules: {edithidden: true, required: false}
                },
                {label: 'Diapply Oleh', name: 'created_by', width: 120, hidden:true, align: "left", editable: false},
                {label: 'Is Approve',name: 'is_approve',width: 120, align: "left",editable: true,
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'Y': 'YES', 'N': 'NO', '':'-'}}
                },
                {label: 'Send Email ?',name: 'is_send_email',width: 120, align: "left",editable: true,
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'Y': 'YES', 'N': 'NO', '':'-'}}
                },
                {label: 'Send Email Date',name: 'send_email_date',width: 130, align: "left",editable: true,
                    edittype:"text",
                    editrules: {required: false}
                },
                {label: 'Tgl Update', name: 'updated_date', width: 120, hidden:true, align: "left", editable: false},
                {label: 'Diupdate Oleh', name: 'created_by', width: 120, hidden:true, align: "left", editable: false}
            ],
            height: 'auto',
            rowNum: 20,
            viewrecords: true,
            rowList: [20,50,100],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            multiselect: true,
            onSelectRow: function (rowid) {

            },
            sortorder:'',
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid-pager-detail',
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
                    statisticInformation();
                }, 0);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."recruitment.t_applicant_job_controller/crud"; ?>',

            subGrid: true, // set the subGrid property to true to show expand buttons for each row
            subGridRowExpanded: showApplicantDocs, // javascript function that will take care of showing the child grid
            subGridWidth : 40,
            subGridOptions : {
                reloadOnExpand :false,
                selectOnExpand : false,
                plusicon : "ace-icon fa fa-folder center bigger-150 green",
                minusicon  : "ace-icon fa fa-folder-open center bigger-150 green"
                // openicon : "ace-icon fa fa-chevron-right center orange"
            },
            rowattr: function (rd) {
                if (rd.is_send_email == 'Y') {
                    return {"class": "email-sent-bg"};
                }else if(rd.is_approve == 'Y') {
                    return {"class": "approve-bg"};
                }
            }

        });

        jQuery('#grid-table-detail').jqGrid('navGrid', '#grid-pager-detail',
            {   //navbar options
                edit: true,
                editicon: 'ace-icon fa fa-search-plus grey',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
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
                editCaption : 'View Record',
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

                    form.parent().find('#sData').hide();
                    form.find('input[type="text"], textarea').prop("style", "border:0px; background:#ffffff !important; ");
                    form.find('select').prop("style", "border:0px;-webkit-appearance: none;-moz-appearance: none;appearance: none;");

                    form.find('input[type="text"]').prop("readonly", true);
                    form.find('select').prop("disabled", true);
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
    }); /* end jquery onload */

    function showDocFile(url) {
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - ((0.5 * width) / 2)) + dualScreenLeft;
        var top = ((height / 2) - ((0.7 * height) / 2)) + dualScreenTop;
        var newWindow = window.open(url, "Dokumen Pelamar", 'location=no,toolbar=no,menubar=no, scrollbars=yes, width=' + (0.5 * width) + ', height=' + (0.7 * height) + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
        return;
    }

    function showApplicantDocs(parentRowID, parentRowKey) {

        var childGridID = parentRowID + "_applicant_docs_table";
        var childGridPagerID = parentRowID + "_applicant_docs_pager";

        var parentGrid = $('#grid-table-detail');
        var celValue = parentGrid.jqGrid ('getCell', parentRowKey, 'applicant_fullname');

        var applicant_id = parentGrid.jqGrid ('getCell', parentRowKey, 'applicant_id');

        $('#' + parentRowID).append('<br><span class="label label-success">'+
                                    'Data Dokumen Pelamar :: '+ celValue +
                                    '</span>');
        // add a table and pager HTML elements to the parent grid row - we will render the child grid here
        $('#' + parentRowID).append('<div class="row"><div class="col-xs-6"><table id="' + childGridID + '"></table><div id="' + childGridPagerID + '"></div></div></div>');


        $("#" + childGridID).jqGrid({
            url: '<?php echo WS_JQGRID."recruitment.p_applicant_doc_controller/read"; ?>',
            mtype: "POST",
            datatype: "json",
            page: 1,
            rowNum: 10,
            height: 'auto',
            autowidth: false,
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            sortorder:'',
            onSortCol: clearSelection,
            onPaging: clearSelection,
            postData:{ applicant_id: encodeURIComponent(applicant_id) },
            colModel: [
                {label: 'ID', name: 'p_applicant_doc_id', key: true, width:125, sorttype:'number', editable: true, hidden:true },
                {label: 'Jenis Dokumen', name: 'p_doc_type_id', width: 150, align: "left", editable: true, hidden:true,
                    editrules: {edithidden: true, required:true},
                    edittype: 'select',
                    editoptions: {
                        dataUrl: '<?php echo WS_JQGRID."recruitment.p_doc_type_controller/html_select_options_doc_type"; ?>',
                        buildSelect: function (data) {
                            if(data !== 'object' ) return data;

                            var response = $.parseJSON(data);
                            if(response.success == false) {
                                showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                                return "";
                            }
                        }
                    }
                },
                {label: 'MD5 Email', name: 'md5_email', width: 120, hidden:true, align: "left", editable: false},
                {label: 'Preview',name: 'link_file',width: 80, align: "center",editable: false,
                    formatter: function(cellvalue, options, rowObject) {
                        var md5_email = rowObject['md5_email'];
                        return '<a href="#'+childGridID+'" onclick="showDocFile(\'<?php echo UPLOAD_PATH;?>'+md5_email+'/'+cellvalue+'\');"> <i class="ace-icon fa fa-download bigger-130"></i> </a>';
                    }
                },
                {label: 'Jenis Dokumen', name: 'doc_type_code', width: 150, align: "left", editable: false},
                {label: 'Nama File',name: 'applicant_doc_file',width: 250, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:255
                    },
                    editrules: {required: true}
                },
                {label: 'Tgl Upload', name: 'created_date', width: 120, align: "left", editable: false},
                {label: 'Diupload Oleh', name: 'created_by', width: 120, align: "left", editable: false},
                {label: 'Tgl Update', name: 'updated_date', width: 120, align: "left", hidden:true, editable: false},
                {label: 'Diupdate Oleh', name: 'created_by', width: 120, align: "left", hidden:true, editable: false}
            ],
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
            pager:childGridPagerID,
            editurl: '<?php echo WS_JQGRID."recruitment.p_applicant_doc_controller/crud"; ?>',
            rowList: [],        // disable page size dropdown
            pgbuttons: false,     // disable page control like next, back button
            pgtext: null,         // disable pager text like 'Page 0 of 10'
            viewrecords: false    // disable current view record text like 'View 1-10 of 100'
        });

        jQuery("#"+childGridID).jqGrid('navGrid',"#"+childGridPagerID,
            {
                edit: false,
                editicon: 'ace-icon fa fa-pencil blue',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
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
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );
    }

    function statisticInformation() {
        var grid = $("#grid-table-detail");
        var data = grid.jqGrid('getGridParam', 'postData');
        var job_posting_id = data.job_posting_id;

        $.post( '<?php echo WS_JQGRID."recruitment.t_applicant_job_controller/statistic_information"; ?>',
            {job_posting_id: job_posting_id },
            function( response ) {
                if(response.success == false) {
                    showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Perhatian', response.message);
                }else {
                    $("#info-box-pelamar").html( response.total_pelamar);
                    $("#info-box-pelamar-approve").html( response.total_pelamar_approve );
                    $("#info-box-email-terkirim").html( response.email_terkirim );
                }
            }
        );
    }

</script>

<script>
    function downloadExcelPelamar(job_posting_id) {
        var url = "<?php echo base_url().'excel_pelamar/download_pelamar_apply?job_posting_id='; ?>"+job_posting_id;
        window.location = url;
    }
</script>