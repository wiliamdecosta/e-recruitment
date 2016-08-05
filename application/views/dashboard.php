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
    <?php endif; ?>
</div>
