<div class="row">
    <div class="row">
        <div class="col-md-3">
            <img src="<?php echo base_url(); ?>/assets/img/no_img.png" style="border:1px solid #021a40;">
        </div>
        <div class="col-md-9">
            <form id="formLogin" method="post">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Nama Lengkap *</label>
                            <input type="text" value="<?php echo $row->applicant_fullname; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Nomor KTP *</label>
                            <input type="text" value="<?php echo $row->applicant_ktp_no; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Email *</label>
                            <input type="text" value="<?php echo $row->applicant_email; ?>" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Nomor Handphone</label>
                            <input type="text" value="<?php echo $row->applicant_hp; ?>" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Nomor Telepon</label>
                            <input type="text" value="<?php echo $row->applicant_telp; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Tanggal Lahir</label>
                            <input type="text" value="<?php echo $row->applicant_date_of_birth; ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Kota Asal</label>
                            <input type="text" value="<?php echo $row->applicant_city; ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Alamat *</label>
                    <textarea maxlength="5000"
                              class="form-control" name="message" id="message"
                              value="<?php echo $row->applicant_address; ?>"><?php echo $row->applicant_address; ?></textarea>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo
                           $this->security->get_csrf_hash(); ?>">
                    <div class="col-md-12">
                        <a type="submit" class="btn btn-primary btn-block" id="update_profile">Update Profile</a>
                    </div>
                </div>

        </div>
        </form>
    </div>
</div>


</div>

</div>
<script type="text/javascript">
    $( document ).ready(function() {
        $("#formRegister").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: "required",
                password_again: {
                    equalTo: "#password"
                },
                full_name: "required",
                ktp_number: {
                    required : true,
                    digits: true,
                    minlength: 16,
                    maxlength: 16
                }

            },
            messages: {
                email: {
                    required: "Email tidak boleh kosong",
                    email: "Email harus valid"
                }
            }
        });
    });

    $("#formRegister").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        if($("#formRegister").valid() == true){
            var url = "<?php echo site_url('register/register_action');?>";
            $.ajax({
                type: "POST",
                url: url,
                dataType : 'json',
                data: $("#formRegister").serialize(),
                success: function(data)
                {
                    if(data.success != true){
                        swal('',data.message,'error');
                        $("#formRegister")[0].reset();
                    }else{

                    }

                    swal('',data.message,'success');
                    $("#formRegister")[0].reset();
                    //window.location = '<?php echo site_url('login');?>';
                }
            });
        }



    });




    $('#btnRegister').click(function(){
//                        swal('','Verifikasi telah dikirim ke email anda ','success');
        //validator.form();
    });


</script>
<script>

    $('#update_profile').click(function () {
        swal('', 'Profile berhasil diupdate', 'success');
    })
</script>