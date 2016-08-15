<div class="row">
    <div class="alert alert-info">
        <strong>Informasi!</strong> Maksimal Upload setiap file adalah 3 Mb, dengan format JPG,JPEG atau PNG
    </div>
    <form id="formDokumen" method="post" class="form-horizontal">
        <?php foreach ($dokumen as $row) {
            ; ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo $row->description; ?></label>
                    <?php if ($row->applicant_doc_file == "") {
                        echo '<span class="btn btn-default btn-file">
                                    <input type="file" id="' . $row->code . '" name="' . $row->code . '" >
                                  </span>
                                    <a href="#" class="btn btn-default upload_single" data-id="' . $row->p_doc_type_id . '" data-dismiss="fileupload" data-param="' . $row->code . '">Upload</a>
                                    ';

                    } else {
                        echo '<p class="form-control-static">
                                    <a href="' . base_url() . 'application/third_party/applicant_docs/' . md5($this->session->userdata('applicant_email')) . '/' . $row->applicant_doc_file . '" target="_blank">' . $row->applicant_doc_file . '</a>
                            &nbsp; <i class="fa fa-times delete_dok" style="color:#E08374; cursor: pointer" data-id="' . $row->p_doc_type_id . '"></i>
                            </p>
                            ';
                    }
                    ?>
                </div>

            </div>

        <?php }; ?>
        <br>
        <div class="row">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo
                   $this->security->get_csrf_hash(); ?>">

        </div>
    </form>
    <br>

</div>
<script>
    $('.upload_single').click(function () {
        var param = $(this).attr('data-param');
        var doc_type_id = $(this).attr('data-id');
        if ($('#' + param).val() == "") {
            swal('', 'File tidak boleh kosong', 'warning');
        } else {
            // do upload
            var url = "<?php echo site_url('applicant/uploadDokumen');?>";

            var file_data = $('#' + param).prop('files')[0];
            var form_data = new FormData();
            form_data.append('filename', file_data);
            form_data.append('doc_type_id', doc_type_id);
            form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
            $.ajax({
                url: url,
                dataType: 'html',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $("#applicant_content").html(data);
                }
            });

        }

    });

    $('.delete_dok').click(function () {
        var doc_type = $(this).attr('data-id');
        if (doc_type) {
            swal({
                title: "",
                text: "Apakah anda yakin menghapus dokumen ini ?!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            }, function () {

                var url = "<?php echo site_url('applicant/deleteDokumen');?>";
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'html',
                    data: {doc_type: doc_type},
                    success: function (data) {
                        $("#applicant_content").html(data);
                    }
                });
            });


        }

    })


</script>
