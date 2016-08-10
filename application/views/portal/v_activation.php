<!DOCTYPE html>
<html class="boxed">
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>PDAM Recruitment Activation Page</title>

    <meta name="keywords" content="PDAM RECRUITMENT"/>
    <meta name="description" content="PDAM Tirtawening">
    <meta name="author" content="PDAM">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon_pdam.ico" type="image/x-icon"/>

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light"
          rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/swal/sweetalert.css">
    <script src="<?php echo base_url();?>assets/swal/sweetalert.min.js"></script>



</head>
<body>
</body>

</html>

<script type="text/javascript">
    sweetAlert('Berhasil','<?php echo $message;?>','<?php echo $status;?>');
    setTimeout(function(){
        window.location = '<?php echo site_url('login');?>';
    }, 5000);
</script>