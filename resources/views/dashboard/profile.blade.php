<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Chati - profile</title>
</head>
<style>
    .cont {
        position: fixed;
        right: 0;
        left: 0;
        top: 0;
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
<style>
    .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8
    }

    .profile-button {
        background: rgb(99, 39, 120);
        box-shadow: none;
        border: none
    }

    .profile-button:hover {
        background: #682773
    }

    .profile-button:focus {
        background: #682773;
        box-shadow: none
    }

    .profile-button:active {
        background: #682773;
        box-shadow: none
    }

    .back:hover {
        color: #682773;
        cursor: pointer
    }

    .labels {
        font-size: 11px
    }

    .add-experience:hover {
        background: #BA68C8;
        color: #fff;
        cursor: pointer;
        border: solid 1px #BA68C8
    }

    .rounded-circle {
        width: 190px
    }

</style>

<body>
    @include('dashboard/topnav')
    @include('dashboard/sidebars')

    <div class="container rounded col-md-8  mt-5 ">
        <div class="row">

            <div class="col-md-7 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form id="update" method="post" enctype="multipart/form-data">
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Full Name</label><input type="text"
                                    class="form-control" placeholder="Full Name" name="name"
                                    value="{{ Session::get('nom') }}"></div>
                            <div class="col-md-6"><label class="labels">Username</label><input required
                                    type="text" id="username" name="username" class="form-control"
                                    value="{{ Session::get('username') }}" placeholder="username">
                            </div>
                            <div class="col-md-12"><label class="labels">About You</label><input required
                                    type="text" id="about" name="about" class="form-control"
                                    value="{{ Session::get('about') }}" placeholder="about you">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">PhoneNumber</label><input
                                    type="text" class="form-control" placeholder="enter phone number" name="tel"
                                    id="tel" value="{{ Session::get('tel') }}"></div>
                            <div class="col-md-12"><label class="labels">Address</label>
                                <input type="text" class="form-control" placeholder="enter address" name="address"
                                    value="{{ Session::get('address') }}">
                            </div>
                            <div class="col-md-12"><label class="labels">Email </label>
                                <input type="email" class="form-control" name="email" placeholder="enter email "
                                    value="{{ Session::get('email') }}" id="email" required>
                            </div>
                            <div class="col-md-12"><label class="labels">Change avatar</label>
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">New Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="****">
                            </div>
                            <div class="col-md-6"><label class="labels">Confirm Password</label>
                                <input type="password" id="confirm" name="password2" class="form-control"
                                    placeholder="****">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ Session::get('id') }}">
                        <div class="mt-5 text-center"><button id="sub" class="btn btn-primary profile-button"
                                type="submit">Save
                                Profile</button></div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <div class="col-md-4">
                <form action="" method="post" id="addExp">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience"><span>Add
                                Experience</span>
                            <button class="border px-3 p-1 add-experience">
                                <i class="fa fa-plus"></i>&nbsp;Experience</button>
                        </div><br>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchCheckDefault">
                                Current ?</label>
                            <input class="form-check-input"  id="current" type="checkbox" name="current"
                                id="flexSwitchCheckDefault">

                        </div>
                        <div class="col-md-12"><label class="labels">Experience Name</label>
                            <input type="text" class="form-control" placeholder="experience" value="" required
                                name="expName">
                        </div>
                        <div class="col-md-12"><label class="labels">From</label>
                            <input type="date" class="form-control" placeholder="from" value="" required
                                name="expFrom">
                        </div>
                        <div id="to1"  class="col-md-12"><label
                                class="labels">To</label>
                            <input type="date" id="to" class="form-control" placeholder="from" value="" name="expTo">
                        </div>

                        <script>
                            $(function() {
                                $("#current").on("change", function(e) {
                                    if ($(this).is(':checked')) {
                                        $("#to1").css("display", "none");
                                        $("#to1").attr("disabled", true);

                                    } else {
                                        $("#to1").css("display", "block");
                                        $("#to1").attr("disabled", false);


                                    }
                                })

                            });
                        </script>
                        <div class="col-md-12"><label class="labels">Additional Details</label>
                            <input type="text" class="form-control" placeholder="additional details" value=""
                                name="detail">
                        </div>

                        @csrf
                        <input type="hidden" name="id" value="{{ Session::get('id') }}">

                </form>
            </div>
            <script>
                jQuery(function($) {
                    $("#addExp").on("submit", function(e) {
                        e.preventDefault();

                        $.ajax({
                            url: "{{ url('/AddExp') }}",
                            data: $(this).serialize(),
                            type: "post",
                            success: function(data) {
                                if (data == 1) {
                                    alertify.success("Experience Added successfully!")
                                    $("#addExp").trigger("reset")
                                } else if (data == 0) {
                                    alertify.error("You already have a current experience !")

                                } else {
                                    alert(data)
                                }

                            },
                            error: function(r) {
                                alert(r.responseText)
                            }
                        })

                    })
                })
            </script>
        </div>
    </div>
    </div>
    </div>
    </div>



</body>
<script>
    jQuery(function($) {
        $("#update").on("submit", function(e) {
            e.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/UpdateProfile') }}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // setting a timeout
                    $("#loader").css('display', "block");
                },
                success: function(data) {

                    if (data == 1) {
                        alertify.success("Profile Updated !");
                    } else {
                        alertify.error("Erreur de serveur");

                    }
                    $("#loader").css('display', "none");
                    setInterval(() => {
                        window.location.reload()
                    }, 500);
                },
                error: function(r) {
                    alert(r.responseText);
                    $("#loader").css('display', "none");
                }
            })
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
        $("#username").on("keyup", function() {
            var val = $(this).val();
            if (!verify("username", val, "username")) {
                $("#sub").attr("disabled", true);
            }
        })
        $("#tel").on("keyup", function() {
            var val = $(this).val();
            if (!verify("tel", val, "tel")) {
                $("#sub").attr("disabled", true);
            }
        })
        $("#email").on("keyup", function() {
            var val = $(this).val();
            if (!verify("email", val, "email")) {
                $("#sub").attr("disabled", true);
            }
        })

        function verify(column, val, id) {
            $.ajax({
                type: "POST",
                url: "{{ url('/verifyProfile') }}",
                data: {
                    col: column,
                    data: val,
                    id: "{{ Session::get('id') }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data == 10 || data == 1) {
                        $("#" + id).css("border", "1px solid #ccc");
                        $("#sub").removeAttr("disabled");
                        return true;
                    } else {
                        alertify.error(column + ' already exists');
                        $("#" + id).css("border", "1px solid red");
                        return false;
                    }
                },
                error(r) {
                    alert(r.responseText)
                }
            })
        }
    })
</script>

</html>
