<div class="row">
    <form id="formLogin" method="post">
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>E-mail Address *</label>
                    <input type="text" value="<?php echo $row->applicant_email;?>" class="form-control" name="email">
                </div>
                <div class="col-md-6">
                    <label>Nama Lengkap *</label>
                    <input type="text" value="<?php echo $row->applicant_fullname;?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <!--                                                        <a class="pull-right" href="#">(Lost Password?)</a>-->
                    <label>Password *</label>
                    <input type="password" value="<?php echo $row->applicant_password;?>" class="form-control" name="password">
                </div>
                <div class="col-md-6">
                    <!--                                                        <a class="pull-right" href="#">(Lost Password?)</a>-->
                    <label>Confirm Password *</label>
                    <input type="password" value="<?php echo $row->applicant_password;?>" class="form-control" name="confirm_password">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Nomor KTP *</label>
                    <input type="text" value="<?php echo $row->applicant_ktp_no;?>" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Nomor Handphone</label>
                    <input type="text" value="<?php echo $row->applicant_hp;?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>Nomor Telepon</label>
                    <input type="text" value="<?php echo $row->applicant_telp;?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Tanggal Lahir</label>
                    <input type="text" value="<?php echo $row->applicant_date_of_birth;?>" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Kota Asal</label>
                    <input type="text" value="<?php echo $row->applicant_city;?>" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Alamat *</label>
                    <textarea maxlength="5000"
                              class="form-control" name="message" id="message" value="<?php echo $row->applicant_address;?>"><?php echo $row->applicant_address;?></textarea>
                </div>

            </div>
        </div>
        <div class="row">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo
                   $this->security->get_csrf_hash(); ?>">
            <div class="col-md-12">
                <a type="submit" class="btn btn-primary btn-block" id="update_profile">Update</a>
            </div>
        </div>
    </form>
</div>
<script>
    $('#update_profile').click(function(){
        swal('','Profile berhasil diupdate','success');
    })
</script>