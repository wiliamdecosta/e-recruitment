<div class="row">
    <form id="formLogin" method="post">
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Pilih Job</label>
                    <select class="form-control mb-md" id="job" name="job">
                        <option value="">-- Pilih Job --</option>
                        <?php foreach ($job as $row) {
                        echo "<option value='$row->job_id'> ". $row->job_code ." - " .$row->job_name. " </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" id="detailJob">

        </div>

    </form>
</div>
<script>
    $('#btn_apply').click(function () {
        var job = $('#job').val();
        if (!job) {
            swal('', 'Tidak ada job yang dipilih!', 'error');
        } else {
            swal('', 'Lamaran berhasil disubmit, Silahkan cek email untuk langkah selanjutnya', 'success');
        }

    })

    $("#job").change(function () {
        var job_id = $(this).val();
        $.ajax({
            // async: false,
            cache: false,
            url: "<?php echo base_url();?>applicant/getJobDetail",
            type: "POST",
            data: {job_id: job_id},
            success: function (data) {
                $("#detailJob").html(data);

            }
        });

    });
</script>
