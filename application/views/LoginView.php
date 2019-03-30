<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giriş Paneli</title>
    <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/alertifyjs/alertify.min.js');?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/all.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/alertify.min.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/bootstrap.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/styles/loginstyle.css');?>" type="text/css">
</head>
<body>
<div class="container-fluid">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3 class="d-flex justify-content-center mt-5">Giriş Paneli</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text justify-content-center"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Kullanıcı Adı" aria-label="UserName" id="name" name="username"/>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text justify-content-center"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Şifre" aria-label="Password" id="password" name="password"/>
                    </div>
                    <div class="form-group">
                        <input type="button" value="Giriş" class="btn float-right login_btn" id="loginBtn"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/login.js');?>"></script>
</body>
</html>