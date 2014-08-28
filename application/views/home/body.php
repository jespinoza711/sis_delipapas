<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Inicio</title>
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
                        <li class="user user-menu">
                            <a href="<?= base_url() ?>login">
                                <span>Iniciar sesión</span>
                            </a>
                        </li>
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
                        <li class="active">
                            <a href="<?= base_url() ?>">
                                <i class="fa fa-home"></i> <span>Inicio</span>
                            </a>
                        </li>
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

        <script src="<?= base_url() ?>resources/js/jquery-2.1.1.min.js"></script>
        <script src="<?= base_url() ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>resources/js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>