<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="<?= base_url() ?>/public/assets/backend/images/favicon.ico">

    <title>Neon | Codeigniter</title>

    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/css/neon-core.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/css/neon-theme.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/css/neon-forms.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/css/custom.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>/public/assets/backend/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/public/assets/backend/js/select2/select2.css">

    <script src="<?= base_url() ?>/public/assets/backend/js/jquery-1.11.3.min.js"></script>

    <!--[if lt IE 9]><script src="<?= base_url() ?>/public/assets/backend/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body page-fade-only gray" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <div class="sidebar-menu">
        <?php if(isset($left_nav)){
            echo $left_nav;
        } ?>
    </div>

    <div class="main-content">

        <!-- Top Header -->
        <?php if(isset($top_header)){
            echo $top_header;
        } ?>

        <!-- Body -->
        <?php if(isset($master_body)){
            echo $master_body;
        } ?>

        <!-- Footer -->
        <?php if(isset($footer)){
            echo $footer;
        } ?>
    </div>
</div>





<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="<?= base_url() ?>/public/assets/backend/js/rickshaw/rickshaw.min.css">

<!-- Bottom scripts (common) -->
<script src="<?= base_url() ?>/public/assets/backend/js/gsap/TweenMax.min.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/bootstrap.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/joinable.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/resizeable.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/neon-api.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


<!-- Imported scripts on this page -->
<script src="<?= base_url() ?>/public/assets/backend/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/jquery.sparkline.min.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/fullcalendar/fullcalendar.min.js"></script>

<script src="<?php echo base_url() ?>/public/assets/backend/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>/public/assets/backend/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="<?php echo base_url() ?>/public/assets/backend/js/select2/select2.min.js"></script>
<script src="<?php echo base_url() ?>/public/assets/backend/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>/public/assets/backend/js/fileinput.js"></script>

<!-- JavaScripts initializations and stuff -->
<script src="<?= base_url() ?>/public/assets/backend/js/neon-custom.js"></script>

</body>
</html>