<div class="row">
    <div class="col-lg-12 col-xs-12">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Bienvenido al Sistema DELIPAPAS </h1>
                <h3> <?= $datetime ?> </h3>
                <h4> <?= $rol . ' : ' . $user ?> </h4>
            </div>
        </div>
        <hr>
        <div class="row">            

            <?php if ($status_caja == 2) { ?>
            
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-check"></i> CERRAR CAJA </h4>
                        </div>
                        <div class="panel-body">
                            <a href="<?= base_url('cerrarcaja') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/caja.png' ?>" alt="Ir"></a>
                        </div>
                    </div>
                </div>

            <?php } else if ($status_caja == 1) { ?>
            
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-check"></i> APERTURAR CAJA </h4>
                        </div>
                        <div class="panel-body">
                            <a href="<?= base_url('abrircaja') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/caja.png' ?>" alt="Ir"></a>
                        </div>
                    </div>
                </div>

            <?php } else { ?>
            
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-check"></i> CAJA CERRADA</h4>
                        </div>
                        <div class="panel-body">
                            <a href="<?= base_url('home') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/caja.png' ?>" alt="Ir"></a>
                        </div>
                    </div>
                </div>

            <?php } if ($status_cajachica == 2) { ?>
            
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-check"></i> CERRAR CAJA CHICA </h4>
                        </div>
                        <div class="panel-body">
                            <a href="<?= base_url('cerrarcajachica') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/caja_chica.png' ?>" alt="Ir"></a>
                        </div>
                    </div>
                </div>

            <?php } else if ($status_cajachica == 1) { ?>
            
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-check"></i> APERTURAR CAJA CHICA </h4>
                        </div>
                        <div class="panel-body">
                            <a href="<?= base_url('abrircajachica') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/caja_chica.png' ?>" alt="Ir"></a>
                        </div>
                    </div>
                </div>

            <?php } else { ?>
            
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-check"></i> CAJA CHICA CERRADA </h4>
                        </div>
                        <div class="panel-body">
                            <a href="<?= base_url('home') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/caja_chica.png' ?>" alt="Ir"></a>
                        </div>
                    </div>
                </div>

            <?php } ?>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-check"></i> REGISTRO DIARIO </h4>
                    </div>
                    <div class="panel-body">
                        <a href="<?= base_url('registrodiario') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url() . 'resources/images/personal.png' ?>" alt="Ir"></a>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <div class="well">
            <div class="row">
                <div class="col-md-8">
                    <p>Sistema de gestión y control de actividades de la empresa Delipapas.</p>
                    <p>Copyright &copy; <a href="http://orange3s.com/" target="_blank"> Orange3S </a> 2014 </p>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-default btn-block" href="<?= base_url('close') ?>">Cerrar Sesi&oacute;n</a>
                </div>
            </div>
        </div>
    </div>
</div>