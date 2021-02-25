<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chrono'Taxi | Connexion</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">UC</h1>

            </div>
            <h3>Bienvenue sur Chrono'Taxi</h3>
            <p>Connectez-vous à votre espace.</p>
            @if($errors->any())
                <p class="alert alert-danger">{{ $errors->all()[0] }}</p>
            @endif
            @if(session()->has("success"))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            <form method="POST" action="{{ route('dologin') }}" class="needs-validation">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" class="form-control" placeholder="Email" name="email" tabindex="1"
                        required autofocus>
                </div>

                <div class="form-group">
                    <input id="password" type="password" placeholder="Mot de passe" class="form-control" name="password"
                        tabindex="2" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Connexion
                    </button>
                </div>
            </form>
            <p class="m-t"> <small>&copy; LAB2VIEW</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>
