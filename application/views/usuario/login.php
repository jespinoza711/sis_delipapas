<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Delipapas | Iniciar sesión</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= base_url() ?>resources/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>resources/css/AdminLTE.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Iniciar sesión</div>
            <form action="<?= base_url() ?>usuario/login" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" required="true"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña"  required="true"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Recordarme
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-olive btn-block">Iniciar</button>  
                    
                    <p><a href="#">¿Olvidé mi contraseña?</a></p>
                </div>
            </form>
        </div>

        <script src="<?= base_url() ?>resources/js/jquery-2.1.1.min.js"></script>
        <script src="<?= base_url() ?>resources/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>