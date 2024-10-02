<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Esra Demirtaş CRM</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Admin, Dashboard, Bootstrap" />
    <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png">

    <link rel="stylesheet" href="<?php echo base_url("assets"); ?>/libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets"); ?>/libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets"); ?>/libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets"); ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url("assets"); ?>/assets/css/core.css">
    <link rel="stylesheet" href="<?php echo base_url("assets"); ?>/assets/css/misc-pages.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>
<body class="simple-page">
<div id="back-to-home">
    <a href="index.html" class="btn btn-outline btn-default"><i class="fa fa-home animated zoomIn"></i></a>
</div>
<div class="simple-page-wrap">
    <div class="simple-page-logo animated swing">
        <a href="index.html">
            <span><i class="fa fa-gg"></i></span>
            <span>CMS LOGİN</span>
        </a>
    </div><!-- logo -->
    <div class="simple-page-form animated flipInY" id="login-form">
        <h4 class="form-title m-b-xl text-center">Kullanıcı Giriş Formu</h4>
        <form action="<?php echo base_url("login/loginForm")?>" method="post">
            <div class="form-group">
                <input id="sign-in-email" type="email" name="email" class="form-control" placeholder="E-posta Adresiniz ">
            </div>

            <div class="form-group">
                <input id="sign-in-password" type="password" name="password" class="form-control" placeholder="Şifreniz">
            </div>



            <input type="submit" class="btn btn-primary" value="Giriş Yap">
        </form>
    </div><!-- #login-form -->

    <div class="simple-page-footer">
        <p><a href="password-forget.html">Şifrenizi unuttunuz mu?</a></p>

    </div><!-- .simple-page-footer -->


</div><!-- .simple-page-wrap -->
</body>
</html>