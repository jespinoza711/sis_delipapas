<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title> .:: Delipapas | Iniciar sesi&oacute;n ::. </title>
        <link rel="shortcut icon" href="<?= base_url('resources/images/ico/ico.ico') ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= base_url('resources/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/AdminLTE.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">
                <h1> DeliPapas </h1>
                Iniciar Sesi&oacute;n
            </div>
            <form action="<?= base_url('login') ?>" method="post">
                <div class="body bg-gray">
                    <fieldset>
                        
                        <?php if ($this->session->userdata('error') != ''){ ?>
                
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <?= $this->session->userdata('error') ?>
                            </div>

                        <?php $this->session->set_userdata('error', ''); } ?>
                        
                        <div class="form-group"><?= form_input($usuario) ?></div>
                        <div class="form-group"><?= form_password($password) ?></div>
                    </fieldset>
                </div>
                <div class="footer" style="text-align:center"> 
                    <?= form_submit($inicio_sesion) ?> 
                    <p>Copyright &copy; <a href="http://orange3s.com/" target="_blank"> Orange3S </a> 2014 </p>
                </div>
                
            </form>            
        </div>

        <script src="<?= base_url('resources/js/jquery-2.1.1.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/bootstrap.min.js') ?>" type="text/javascript"></script>        

    </body>
</html>