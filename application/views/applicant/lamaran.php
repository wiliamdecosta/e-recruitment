

<div class="row">
    <form id="formLogin" method="post">
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Pilih Lowongan</label>
                    <select class="form-control mb-md" id="job">
                        <option value="">-- Pilih Job --</option>
                        <option value="1">Human Resource Departement</option>
                        <option value="2">Information Technology</option>
                        <option value="3">Accounting</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo
                   $this->security->get_csrf_hash(); ?>">
            <div class="col-md-12">
                <a type="submit" class="btn btn-primary btn-block" id="btn_apply">Aplly Job</a>
            </div>
        </div>
    </form>
</div>
<script>
    $('#btn_apply').click(function(){
        var job = $('#job').val();
        if(!job){
            swal('','Tidak ada job yang dipilih!','error');
        }else{
            swal('','Lamaran berhasil disubmit, Silahkan cek email untuk langkah selanjutnya','success');
        }

    })
</script>
