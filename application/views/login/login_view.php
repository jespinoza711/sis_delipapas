<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Delipapas | Iniciar sesiÃƒÂ³n</title>
        <link rel="shortcut icon" href="<?= base_url('resources/images/ico/ico.ico') ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= base_url() ?>resources/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/AdminLTE.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Iniciar SesiÃ³n</div>
            <form action="<?= base_url('login') ?>" method="post">
                <div class="body bg-gray">
                    <?= form_open(base_url() . 'login', $form) ?>
                    <fieldset>
                        <?php if ($this->session->userdata('error_login_1') && $this->session->userdata('error_login_1') != "") { ?>
                            <div class="alert alert-danger">
                                <?= $this->session->userdata('error_login_1') ?>
                            </div>
                            <?php
                            $this->session->unset_userdata('error_login_1');
                        }
                        ?>
                        <div class="form-group">
                            <?= form_input($usuario) ?>
                        </div>
                        <div class="form-group">
                            <?= form_password($contraseÃ±a) ?>
                        </div>          

                    </fieldset>
                </div>


                <div class="footer">
                    <!--                    <button type="submit" class="btn bg-olive btn-block">Iniciar</button>  -->
                    <?= form_submit($inicio_sesion) ?>

                </div>
            </form>
        </div>

        <script src="<?= base_url() ?>resources/js/jquery-2.1.1.min.js"></script>
        <script src="<?= base_url() ?>resources/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>