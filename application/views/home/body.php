<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>DeliPapas | Inicio</title>
        <link rel="shortcut icon" href="<?= base_url('resources/images/ico/ico.ico') ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= base_url('resources/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/jquery-ui.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('resources/css/AdminLTE.css') ?>" rel="stylesheet" type="text/css" />

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?= base_url() ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Delipapas
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <!-- User Account: style can be found in dropdown.less -->

                        <li class="user user-menu"><a href="<?= base_url('cajachica') ?>"><span>CAJA CHICA</span></a></li>
                        <li class="user user-menu"><a href="<?= base_url('registrodiario') ?>"><span>REGISTRO DIARIO</span></a></li>

                        <?php if ($this->session->userdata('logged') == true) { ?>

                            <li class="user user-menu"><a href="<?= base_url('close') ?>"><span>CERRAR SESION</span></a></li>

                        <?php } else { ?>

                            <li class="user user-menu"><a href="<?= base_url('login') ?>"><span>INICIAR SESION</span></a></li>

                        <?php } ?>

                    </ul>
                </div>
            </nav>
        </header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <ul class="sidebar-menu">

                        <?php
                        if ($this->session->userdata('logged') == true) {
                            echo show_menu($this->session->userdata('user_rol'));
                        } else {
                            echo show_menu();
                        }
                        ?>

                    </ul>
                </section>
            </aside>

            <aside class="right-side">
                <section class="content-header">
                    <h1> <?= $page ?> <small></small> </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url('home') ?>"><i class="fa fa-home"></i> Inicio </a></li>
                        <li class="active"> <?= $page ?> </li>
                    </ol>
                </section>                
                <section class="content"> <?= $container ?> </section> 
            </aside>
        </div>

        <script src="<?= base_url('resources/js/jquery-2.1.1.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/config.js') ?>" type="text/javascript"></script>        
        <script src="<?= base_url('resources/js/jquery-number.min.js') ?>"></script>
        <script src="<?= base_url('resources/js/jquery-ui.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/jquery.dataTables.js') ?>"></script>
        <script src="<?= base_url('resources/js/dataTables.bootstrap.js') ?>"></script>        
        <script src="<?= base_url('resources/js/plugins/input-mask/jquery.inputmask.js') ?>"></script>
        <script src="<?= base_url('resources/js/plugins/input-mask/jquery.inputmask.extensions.js') ?>"></script>
        <script src="<?= base_url('resources/js/plugins/input-mask/jquery.inputmask.date.extensions.js') ?>"></script>
        <script src="<?= base_url('resources/js/plugins/daterangepicker/daterangepicker.js') ?>"></script>
        <script src="<?= base_url('resources/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/AdminLTE/app.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/empleado.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/producto.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/usuario.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/caja.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/proveedor.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/cliente.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/venta.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/compra.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/cajachica.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/registrodiario.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/pago.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/inventario.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/reporte.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/planilla.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/concepto.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/config/comprobante.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('resources/js/SmartNotification.js') ?>" type="text/javascript"></script>
       
    </body>
</html>