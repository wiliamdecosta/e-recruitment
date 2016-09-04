<div id="breadcrumbs" class="breadcrumbs">
    <div id="breadcrumbs" class="breadcrumbs">
	    <ul class="breadcrumb">
	    	<li>
	    		<i class="ace-icon fa fa-home home-icon"></i>
	    		<a href="<?php echo base_url(); ?>">Home</a>
	    	</li>
            <li class="active">Dashboard</li>
	    </ul><!-- /.breadcrumb --
	    <!-- /section:basics/content.searchbox -->
    </div>
</div>

<div class="page-content">
    <div class="row">
        <div class="alert alert-block alert-success">
             <i class="ace-icon fa fa-check green"></i>
             Selamat datang di
             <strong class="green">
                 Aplikasi PDAM E-Recruitment <small>(Version: 1.0)</small>
             </strong> , TIRTAWENING PDAM KOTA BANDUNG
        </div>
    </div>

    <?php
        $ci = & get_instance();
		$ci->load->model('adm_sistem/dashboard');
		$dasboard = $ci->dashboard;
    ?>
    <?php if( $ci->session->userdata('module_id') == 1 ) : /* admin dashboard */?>

    <div class="row">
        <div class="span12 infobox-container">
            <div class="infobox infobox-green">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-user"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $dasboard->getTotalUser(); ?> Data</span>
                    <div class="infobox-content">User</div>
                </div>
            </div>
            <div class="infobox infobox-blue">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-users"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $dasboard->getTotalRole(); ?> Data</span>
                    <div class="infobox-content">Role</div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif($ci->session->userdata('module_id') == 2) : /* recruitment dashboard */ ?>

    <div class="row">
        <div class="span12 infobox-container">
            <div class="infobox infobox-green">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-users"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $dasboard->getTotalApplicant(); ?> Data</span>
                    <div class="infobox-content">Pelamar</div>
                </div>
            </div>
            <div class="infobox infobox-blue">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-briefcase"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $dasboard->getTotalJobVacancy(); ?> Data</span>
                    <div class="infobox-content">Lowongan Pekerjaan</div>
                </div>
            </div>

            <div class="infobox infobox-red">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-envelope"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $dasboard->getTotalInterviewEmailSent(); ?> Data</span>
                    <div class="infobox-content">Email Interview</div>
                </div>
            </div>

        </div>
    </div>
    <div class="space-16"></div>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <h4 class="blue">Enabled Front End ? </h4>
            <?php
                $ci = & get_instance();
                $ci->load->model('base/variables');
                $table = $ci->variables;

                $enabled = $table->get_var('frontend-enabled');
                $checked = '';
                if($enabled == 'Y' or empty($enabled)) {
                    $checked = 'checked';
                }
            ?>
            <label>
                <input type="checkbox" <?php echo $checked; ?> class="ace ace-switch ace-switch-5" id="check-frontend-enabled">
                <span class="lbl"></span>
            </label>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
$(function(e) {

    $('#check-frontend-enabled').change(function() {
        if($(this).is(":checked")) {
            setEnable('Y');
        }else {
            setEnable('N');
        }
    });
});

function setEnable(enabled) {

    $.post( "<?php echo WS_URL.'base.variables_controller/set_var'; ?>",
        { var_name: 'frontend-enabled',
          var_value: enabled,
        },
        function( response ) {
            if(response.success == false) {
                showBootDialog(false, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
            }else {

            }
        }
    );
}
</script>