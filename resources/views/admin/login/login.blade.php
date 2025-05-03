<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Login</title>
    <!-- Icono de la aplicación en la pestaña del título -->
    <link rel="icon" href="{{ asset('imagen/escudo.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box responsive" style="width: 50%">
        <!-- /.login-logo -->
        <div class="card bg-green">
            <div class="card">
                <div class="login-logo mt-0">
                    <div class="card-title bg-green">
                        <a href="">
                            <img src="{{ asset('/imagen/logo_planeacion.png') }}" width="100%">
                        </a>
                    </div>
                    <a href="">
                        <img src="{{ asset('/imagen/escudo.png') }}" width="250px">
                        <b class="text-green text-bold display-3 mt-3" style="display: block;">{{ config('app.name'); }}</b>
                    </a>
                </div>
            </div>
            <div class="card-body login-card-body bg-success h3" style="align-items: center; display: flex;">
                <p class="login-box-msg text-bold">INICIO DE SESIÓN</p>

                <form action="{{ route('loginInicio') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control" placeholder="Correo Electrónico" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text bg-secondary">
                                <span class="fas fa-envelope text-white"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text bg-secondary">
                                <span class="fas fa-lock text-white"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-light btn-block text-success text-bold">INGRESAR</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
