<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - Accueil</title>


</head>

<body>
    @include('navigation');
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Log In</h2>
            </div>
            <form method="post" id="loginForm">
                <div class="mb-3"><label class="form-label" for="email">Email</label><input
                        class="form-control item" type="email" name="email" id="email"></div>
                <div class="mb-3"><label class="form-label" for="password">Password</label><input
                        class="form-control" type="password" name="password" id="password"></div>
                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label" for="checkbox"><a href="#" id="buttonForget">Forget password
                                ?</a></label>
                    </div>
                </div><button class="btn btn-primary" type="submit">Log In</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </section>
    <script>
        jQuery(function($) {
            if (localStorage.getItem("code") != undefined) {
                console.log();
                alertify.prompt("New Password", "Please insert Carefully You new Password : ", '',
                    function(e, val) {
                        $.ajax({
                            url: "{{ url('/NewPass') }}",
                            type: "POST",
                            data: {
                                password: val,
                                email: localStorage.getItem("email"),
                                _token: "{{ csrf_token() }}"
                            },
                            beforeSend: function() {
                                // setting a timeout
                                $("#loader").css('display', "block");

                            },
                            success: function(data) {
                                alert(data);
                                $("#loader").css('display', "none");


                            },
                            error: function(r) {
                                alert(r.responseText);
                                $("#loader").css('display', "none");

                            }
                        })
                        localStorage.removeItem("code")
                        localStorage.removeItem("email")

                    },
                    function() {
                        alertify.error("operation cancelled");
                        localStorage.removeItem("code")
                    }).set("type", "password");
            }
            $("#buttonForget").on("click", function() {
                alertify.prompt("Password Revovery", "You should insert your email : ", '',
                    function(e, val) {
                        $.ajax({
                            type: "post",
                            url: "{{ url('/SendConfirm') }}",
                            data: {
                                email: val,
                                _token: "{{ csrf_token() }}"
                            },
                            beforeSend: function() {
                                // setting a timeout
                                $("#loader").css('display', "block");
                            },
                            success: function(data) {
                                localStorage.setItem("email", val)
                                $("#loader").css('display', "none");

                                if (data == 0) {
                                    e.cancel = true;
                                    alertify.error("Email doesn't exist ");
                                } else {
                                    alertify.success(data);
                                    localStorage.setItem("code", data);
                                    alertify.prompt("Confirmation",
                                        "Please Insert the code  you've received in your mail here : ",
                                        '',
                                        function(e, v) {
                                            if (v === localStorage.getItem("code")) {
                                                window.location.reload()

                                            } else {
                                                e.cancel = true;
                                                alertify.error("Wrong Code ! ");
                                            }
                                        },
                                        function() {
                                            alertify.error("Operation Cancelled");
                                            localStorage.removeItem("code");
                                            localStorage.removeItem("email")

                                        })


                                }

                            },
                            error(r) {
                                alert(r.responseText);
                                $("#loader").css('display', "none");

                            }
                        })
                    },
                    function() {
                        alertify.error("cancel")
                    }).set("type", "email")
            })
            $("#loginForm").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "{{ url('/verifLogin') }}",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        // setting a timeout
                        $("#loader").css('display', "block");

                    },
                    success: function(data) {
                        $("#loader").css('display', "none");

                        if (data == 10) {
                            alertify.error("Verify you data ! ")
                        } else if (data == 0) {
                            alertify.error("Verify you data !")
                        } else if (data == 1) {
                            window.location.href = "{{ url('/home?welcome') }}";
                        } else if (data == 3) {
                            alertify.error("You are already connected from another session!")
                        } else {
                            alertify.error(data)
                        }
                        /*switch(data){
                            case 1 : window.location="/?welcome" break;
                            case 10 : alert("wrong pass") break;
                            case 0 : alert("not found") break;
                        }*/

                    },
                    error: function(r, err, th) {
                        alert(r.responseText)
                    }

                })

            })
        })
    </script>
    @include('footer')
</body>

</html>
