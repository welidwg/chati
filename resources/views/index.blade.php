<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - Accueil</title>
    <script src="js/app.js"></script>
</head>

<body>
    @include('navigation')
    <section class="clean-block clean-hero"
        style="background-image:url(&quot;assets/img/tech/image4.jpg&quot;);color:rgba(9, 162, 255, 0.85);">
        <div class="text">
            <h2>Welcome to Chati</h2>
            <p>A Tunisian social media plateform for communications</p>
            <a class="btn btn-outline-light btn-lg" href="{{ url('/login') }}">Login</a> or
            <a class="btn btn-outline-light btn-lg" href="{{ url('/register') }}">Sign Up</a>
        </div>
    </section>
    @include('footer')

</body>

</html>
