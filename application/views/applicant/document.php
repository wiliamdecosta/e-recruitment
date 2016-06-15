
<div class="row">
    <form id="formLogin" method="post">
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Upload KTP</label>
                    <input id="input-1" type="file" class="fomr-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Upload Ijazah</label>
                    <input id="input-1" type="file" class="fomr-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Upload Pas Poto</label>
                    <input id="input-1" type="file" class="fomr-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Upload TRANSKRIP NILAI</label>
                    <input id="input-1" type="file" class="fomr-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Upload SKCK</label>
                    <input id="input-1" type="file" class="fomr-control">
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo
                   $this->security->get_csrf_hash(); ?>">
            <div class="col-md-12">
                <a type="submit" class="btn btn-primary btn-block" id="btn_upload">Upload Dokumen</a>
            </div>
        </div>
    </form>
</div>
<script>
    $('#btn_upload').click(function(){
        swal('','Upload berhasil','success');
    })
</script>
