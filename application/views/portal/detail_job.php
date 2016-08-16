<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-6">
        <h4>Kualifikasi</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-6">

        <ul class="list list-icons list-icons-style-2 list-icons-sm">
            <li><i class="fa fa-check"></i> Pendidikan :
                <?php if ($edu->num_rows() > 0) {
                    foreach ($edu->result() as $row) {
                        $arr[] = $row->education_code;
                    }
                    echo implode(" , ", $arr);
                } else {
                    echo "Semua Jenjang Pendidikan";
                }; ?>
            </li>
        </ul>

        <ul class="list list-icons list-icons-style-2 list-icons-sm">
            <li><i class="fa fa-check"></i> Jurusan :
                <?php if ($major->num_rows() > 0) {
                    foreach ($major->result() as $row_major) {
                        $arr_major[] = $row_major->major_code;
                    }
                    echo implode(" , ", $arr_major);
                } else {
                    echo "Semua Jurusan";
                }; ?>
            </li>
        </ul>


        <ul class="list list-icons list-icons-style-2 list-icons-sm">
            <li><i class="fa fa-check"></i> Minimal IPK : <?php echo $job_detail->posting_min_ipk; ?></li>
        </ul>

        <ul class="list list-icons list-icons-style-2 list-icons-sm">
            <li><i class="fa fa-check"></i> Jenis Kelamin :
                <?php if ($job_detail->gender == "") {
                    echo "Pria dan Wanita";
                } else {
                    if ($job_detail->gender == "L") {
                        echo "Pria";
                    } else {
                        echo "Wanita";
                    }
                }
                ?>
            </li>
        </ul>

        <ul class="list list-icons list-icons-style-2 list-icons-sm">
            <li><i class="fa fa-check"></i> Usia : Semua Usia</li>
        </ul>
        &nbsp;


    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
               value="<?php echo
               $this->security->get_csrf_hash(); ?>">
        <div class="col-md-12">
            <a type="submit" class="btn btn-primary btn-block" id="btn_apply">Aplly Job</a>
        </div>
    </div>
</div>
<script>
    $('#btn_apply').click(function () {
        var job_post = $('#job').val();
        if (!job) {
            swal('', 'Tidak ada job yang dipilih!', 'error');
        } else {
            $.ajax({
                // async: false,
                cache: false,
                url: "<?php echo base_url();?>applicant/submitJob",
                type: "POST",
                dataType : 'json',
                data: {job_post: job_post},
                success: function (data) {
                    if(data.success == true){
                        swal('Thanks You !',data.message);
                        $('#detailJob').html('');
                        $('#job').val('');

                    }else{
                        swal('',data.message, 'error');
                    }


                }
            });

        }

    });

</script>