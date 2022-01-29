<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - registration</title>
</head>

<body>
    @include('navigation');
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Registration</h2>
            </div>
            <script>
                jQuery(function($) {


                    function verify(column, val, id) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/verifyName') }}",
                            data: {
                                col: column,
                                data: val,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                if (data == 1) {
                                    $("#" + id).css("border", "1px solid red")
                                    $("#sub").attr("disabled", true);
                                    alertify.error(column + ' already exists');
                                } else {
                                    $("#" + id).css("border", "1px solid #ccc")
                                    $("#sub").removeAttr("disabled");
                                }
                            },
                            error(r) {
                                alertify.error(r.responseText)
                            }
                        })
                    }
                    $("#username").on("keyup", function() {
                        var val = $(this).val();
                        verify("username", val, "username");
                    })
                    $("#email").on("keyup", function() {
                        var val = $(this).val();
                        verify("email", val, "email");
                    })
                    $("#confirm").on("keyup", function() {
                        var confirm = $(this).val();
                        var main = $("#password").val();
                        if (main === confirm) {
                            $("#confirm").css("border", "1px solid #ccc");
                            $("#sub").removeAttr("disabled");

                        } else {
                            $("#sub").attr("disabled", true);
                            $("#confirm").css("border", "1px solid red");


                        }

                    })


                })
            </script>
            <form method="post" action="{{ url('/addUser') }}" enctype="multipart/form-data">
                <div class="mb-3"><label class="form-label" for="username">Username</label><input
                        class="form-control item" type="text" name="username" id="username" required></div>
                <div class="mb-3"><label class="form-label" for="name">Name</label><input
                        class="form-control item" type="text" name="name" required></div>
                <div class="mb-3"><label class="form-label" for="email">Email</label><input
                        class="form-control item" type="email" id="email" name="email" required></div>
                <div class="mb-3"><label class="form-label" for="">Password</label><input
                        class="form-control item" type="password" name="password" id="password" required></div>
                <div class="mb-3"><label class="form-label" for="">Confirm Password</label><input
                        class="form-control item" type="password" name="password2" id="confirm" required></div>
                <div class="mb-3"><label class="form-label" for="">Avatar</label><input
                        class="form-control item" type="file" id="avatar" name="avatar"></div>
                <button class="btn btn-primary" id="sub" type="submit">Sign Up</button>
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
            </form>
        </div>
    </section>
    @include('footer')
</body>

</html>
