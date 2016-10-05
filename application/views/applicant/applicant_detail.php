<div class="row">
    <div class="row">
        <div class="col-md-1">
            <!--<img src="<?php /*echo base_url(); */?>/assets/img/no_img.png" style="border:1px solid #021a40;">-->
        </div>
        <div class="col-md-9">
            <form id="formBiodata" method="post">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-8">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="inFullName" value="<?php echo $row->applicant_fullname; ?>"
                                   class="form-control" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-md-4">
                            <label>Jenis Kelamin *</label>
                            <select name="sl_jk" id="sl_jk" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Nomor KTP *</label>
                            <input type="text" name="inKTP" value="<?php echo $row->applicant_ktp_no; ?>"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Jurusan *</label>
                            <?php echo combo('slJurusan', 'sl_jurusan', 'recruitment.p_college_major', 'major_code', 'major_id', null, 'Pilih Jurusan', 'major_code', 'asc', $row->major_id); ?>
                        </div>
                        <div class="col-md-3">
                            <label>Pendidikan *</label>
                            <?php echo combo('slPendidikan', 'sl_pendidikan', 'recruitment.p_education', 'education_code', 'education_id', null, 'Pilih Pendidikan', 'education_code', 'asc', $row->education_id); ?>
                        </div>
                        <div class="col-md-3">
                            <label>IPK *</label>
                            <input type="text" name="inIPK" value="<?php echo $row->applicant_ipk; ?>"
                                   class="form-control" placeholder="3.15">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Email *</label>
                            <input type="text" name="inEmail" value="<?php echo $row->applicant_email; ?>"
                                   class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Nomor Handphone</label>
                            <input type="text" name="inHP" value="<?php echo $row->applicant_hp; ?>"
                                   class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Nomor Telepon</label>
                            <input type="text" name="inTelp" value="<?php echo $row->applicant_telp; ?>"
                                   class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Tanggal Lahir *</label>
                            <?php echo hari('Pilih Hari', $row->day); ?>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <?php echo bulan('Pilih Bulan', $row->month); ?>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp; </label>
                            <?php echo tahun('Pilih Tahun', $row->year); ?>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Kota Asal</label>
                            <input type="text" name="inKotaAsal" value="<?php echo $row->applicant_city; ?>"
                                   class="form-control" style="text-transform:uppercase">
                        </div>
                        &nbsp;
                        <div class="col-md-12">
                            <label>Alamat</label>
                    <textarea maxlength="5000"
                              class="form-control" name="inAddress" id="inAddress"
                              value="<?php echo $row->applicant_address; ?>"><?php echo $row->applicant_address; ?></textarea>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo
                           $this->security->get_csrf_hash(); ?>">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block" id="update_profile">Update Profile
                        </button>
                    </div>
                </div>

        </div>
        </form>
    </div>
</div>


</div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#sl_jk").val('<?php echo $row->gender; ?>');

        $("#formBiodata").validate({
            rules: {
                inName: "required",
                inEmail: {
                    required: true,
                    email: true
                },
                inFullName: "required",
                inKTP: {
                    required: true,
                    digits: true,
                    minlength: 16,
                    maxlength: 16
                },
                hari: "required",
                bulan: "required",
                tahun: "required",
                sl_jurusan: "required",
                sl_pendidikan: "required",
                inIPK: {
                    required: true,
                    number: true
                },
                sl_jk: "required"

            },
            messages: {
                email: {
                    required: "Email tidak boleh kosong",
                    email: "Email harus valid"
                },
                sl_jk: {
                    required: "Pilih jenis kelamin "
                }
            }
        });
    });

    $("#formBiodata").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        if ($("#formBiodata").valid() == true) {

            swal({
                title: "Submit",
                text: "Apakah anda yakin merubah data ?",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                setTimeout(function () {

                    var url = "<?php echo site_url('applicant/updateData');?>";
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: 'json',
                        data: $("#formBiodata").serialize(),
                        success: function (data) {
                            if (data.success != true) {
                                swal('', data.message, 'error');
                            } else {
                                swal('', data.message);
                                window.location = '<?php echo site_url('applicant');?>';
                            }


                        }
                    });

                }, 2000);
            });



        }


    });


    $('#btnRegister').click(function () {
//                        swal('','Verifikasi telah dikirim ke email anda ','success');
        //validator.form();
    });


</script>
<script>

    /* $('#update_profile').click(function () {
     swal('', 'Profile berhasil diupdate', 'success');
     })*/
</script>