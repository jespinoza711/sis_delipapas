<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>DeliPapas | Inicio</title>
        <link rel="shortcut icon" href="<?= base_url('resources/images/ico/ico.ico') ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= base_url() ?>resources/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/AdminLTE.css" rel="stylesheet" type="text/css" />

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

                        <?php if ($this->session->userdata('logged') == null) { ?>

                            <li class="user user-menu"><a href="<?= base_url('close') ?>"><span>Cerrar sesión</span></a></li>

                        <?php } else { ?>

                            <li class="user user-menu"><a href="<?= base_url('login') ?>"><span>Iniciar sesión</span></a></li>

                        <?php } ?>

                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="active"><a href="<?= base_url('home') ?>"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
                        <li class="active"><a href="<?= base_url('venta') ?>"><i class="fa fa-home"></i> <span>Ventas</span></a></li>
                        <li class="active"><a href="<?= base_url('compra') ?>"><i class="fa fa-home"></i> <span>Compras</span></a></li>
                        <li class="active"><a href="<?= base_url('inventario') ?>"><i class="fa fa-home"></i> <span>Inventario</span></a></li>
                        <li class="active"><a href="#"><i class="fa fa-home"></i> <span>Registros</span></a></li>

                        <ul class="sidebar-menu">
                            <li class="active"><a href="<?= base_url('usuario') ?>"><i class="fa fa-home"></i> <span>Usuario</span></a></li>
                            <li class="active"><a href="<?= base_url('empleado') ?>"><i class="fa fa-home"></i> <span>Empleado</span></a></li>
                            <li class="active"><a href="<?= base_url('proveedor') ?>"><i class="fa fa-home"></i> <span>Proveedor</span></a></li>
                            <li class="active"><a href="<?= base_url('cliente') ?>"><i class="fa fa-home"></i> <span>Cliente</span></a></li>
                            <li class="active"><a href="<?= base_url('producto') ?>"><i class="fa fa-home"></i> <span>Producto</span></a></li>
                        </ul>

                        <li class="active"><a href="<?= base_url('reporte') ?>"><i class="fa fa-home"></i> <span>Reportes</span></a></li>
                        <li class="active"><a href="<?= base_url('ajustes') ?>"><i class="fa fa-home"></i> <span>Ajustes</span></a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Página en blanco
                        <small>Panel de control</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i> Inicio</a></li>
                        <li class="active">Página en blanco</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?= $container ?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <script src="<?= base_url() ?>resources/js/config/config.js"></script>
        <script src="<?= base_url() ?>resources/js/jquery-2.1.1.min.js"></script>
        <script src="<?= base_url() ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>resources/js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>