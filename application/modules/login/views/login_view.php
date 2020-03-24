<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Crm"/>
    <meta name="author" content="Rakib Ibna Hamid"/>

    <link rel="icon" href="<?php echo base_url() ?>public/assets/backend/images/favicon.ico">

    <title>Neon | Codeigniter</title>

    <link rel="stylesheet"
          href="<?php echo base_url() ?>public/assets/backend/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/backend/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/backend/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/backend/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/backend/css/neon-theme.css">


    <script src="<?php echo base_url() ?>public/assets/backend/js/jquery-1.11.3.min.js"></script>

    <script src="<?php echo base_url()?>public/assets/backend/js/ie8-responsive-file-warning.js"></script><![endif]-->



</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev"
      style="background-image: url('./public/assets/backend/images/login.jpg'); background-position: center;
    background-repeat: no-repeat; background-size: cover; height: 100%"
>


<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var baseurl = "<?php echo base_url()?>login/Login/login_check";
</script>
<div class="login-progressbar">
    <div></div>
</div>
<div class="login-container">
    <div class="" style="background-color: transparent">
        <div class="login-content" style="margin-left: 10%; margin-top: 10%">
            <a href="<?php echo base_url() ?>" class="logo">
                <img src="<?php echo base_url() ?>public/assets/backend/images/logo.png" width="120"
                     alt="" style="margin-bottom: 5%"/>
            </a>

            <p class="description" style="margin-bottom: 5%; color: white">Codeigniter HMVC</p>
            <div class="login-progressbar-indicator" style="margin-bottom: 15%">
                <h3>43%</h3>
                <span>logging in...</span>
            </div>
            <div class="form-login-error">
                <h3>Invalid login</h3>
                <p>Please enter valid <strong>username and password</strong></p>
            </div>
            <!-- progress bar indicator -->
            <div class="login-form">
                <form method="post" role="form" id="form_login">
                    <div class="form-group">
                        <div class="input-group" style="background-color: white">
                            <div class="input-group-addon" style="">
                                <i class="entypo-user"></i>
                            </div>
                            <input value="" style="color: black" type="text" data-validate="required"
                                   class="form-control" name="user_name" id="user_name"
                                   placeholder="User Name" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group" style="background-color: white">
                            <div class="input-group-addon" style="">
                                <i class="entypo-key"></i>
                            </div>
                            <input value="" style="color: black" type="password" data-validate="required"
                                   class="form-control" name="password" id="password"
                                   placeholder="Password" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-blue btn-block btn-login">
                            <i class="entypo-login"></i>
                            Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Bottom scripts (common) -->
<script src="<?php echo base_url() ?>public/assets/backend/js/gsap/TweenMax.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/backend/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/backend/js/neon-login.js"></script>


</body>
</html>