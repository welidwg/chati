<html lang="en">
<?php use Illuminate\Support\Facades\Request; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="alertify/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="alertify/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="alertify/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="alertify/css/themes/bootstrap.min.css" />

    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js"
        integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous">
    </script>


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="alertify/alertify.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script>
        alertify.defaults.transition = "slide";
        alertify.defaults.theme.ok = "btn btn-primary";
        alertify.defaults.theme.cancel = "btn btn-danger";
        alertify.defaults.theme.input = "form-control";
    </script>

    <style>
        .cont {
            position: fixed;
            right: 0;
            left: 0;
            margin-left: auto;
            margin-right: auto;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999999;
            transition: .3s;
            display: none;
        }

        .loader {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
            /*display: none;*/
            position: absolute;
            right: 0;
            left: 0;
            margin-left: auto;
            margin-right: auto;
            top: 40%;

        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }

            100% {
                transform: rotate(360deg)
            }
        }

    </style>
</head>


<body>
    @if (Request::has('SessionExpired'))
        <script>
            alertify.alert("Information","Your Session have been Expired");
        </script>
    @endif


    @if (!Session::has('login'))


        <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
            <div class="container"><a class="navbar-brand logo" href="#">Chati</a><button data-bs-toggle="collapse"
                    class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle
                        navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link <?php if (Request::path() == '/') {
    echo 'active';
} ?>"
                                href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link <?php if (Request::path() == 'login') {
    echo 'active';
} ?> "
                                href="{{ url('/login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link <?php if (Request::path() == 'register') {
    echo 'active';
} ?>"
                                href="{{ url('/register') }}">Register</a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
        <div class="cont" id="loader">
            <div class="loader"></div>
        </div>

    @else
        <script>
            window.location.href = "{{ url('/home') }}"
        </script>

    @endif
</body>

</html>
