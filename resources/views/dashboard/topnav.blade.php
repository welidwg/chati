<!DOCTYPE html>
<html>
<?php use App\Models\Actor;
Session::put('LAST_ACTIVITY', time());
use Illuminate\Support\Facades\Route;
use App\Models\notification;

?>
<?php ?>

<head>
    <base href="{{ url('/public') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="boots/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="fa1/css/all.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <link rel="stylesheet" href="alertify/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="alertify/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="alertify/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="alertify/css/themes/bootstrap.min.css" />
    <script>
        alertify.defaults.transition = "slide";
        alertify.defaults.theme.ok = "btn btn-primary";
        alertify.defaults.theme.cancel = "btn btn-danger";
        alertify.defaults.theme.input = "form-control";
    </script>
    <script src="alertify/alertify.min.js"></script>
    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js"
        integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous">
    </script>
    <script src="intense/intense.min.js"></script>
    <script>
        jQuery(function($) {
            jQuery('#loader').fadeOut(400);

        });
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
            display: block;
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

        body {
            background-color: #f9fbfc
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 8px
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
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

<script>
    let ip_address = "127.0.0.1";
    let socket_port = "3000";
    let socket = io(ip_address + ':' + socket_port);
</script>

<body id="page-top">
    @if (Session::has('login'))
        <script>
            jQuery(function($) {
                setInterval(() => {
                    Session();
                }, 500);

                function Session() {
                    $.ajax({
                        type: "post",
                        url: "{{ url('/Session' . '/' . Session::get('id')) }}",
                        data: {
                            query: "session",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data == 1) {
                                window.location.href = "{{ url('/?SessionExpired') }}";
                            }

                        },
                        error: function(e) {
                            console.log(e.responseText);


                        }
                    })
                }
            })
        </script>


        <div class="cont" id="loader">
            <div class="loader"></div>
        </div>
        <div id="wrapper">

            <style>


            </style>
            <?php $actor = Actor::where('_id', '=', Session::get('id'))->first(); ?>

            <style>
                .fixed-top {}

            </style>
            <div class="d-flex flex-column" id="content-wrapper" style="background-color: transparent;">
                <div id="content">
                    <nav class="navbar navbar-light navbar-expand bg-white  mb-9 topbar fixed-top clean-navbar">
                        <div class="container-fluid">
                            <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop"
                                type="button"><i class="fas fa-bars"></i></button>

                            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
                                href="#">
                                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                                <div class="sidebar-brand-text mx-3"><span>Chati</span></div>
                            </a>
                            <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                                <div class="input-group"><input class="bg-light form-control border-0 small"
                                        type="text" placeholder="Search for ..."><button class="btn btn-primary py-0"
                                        type="button"><i class="fas fa-search"></i></button></div>
                            </form>
                            <ul class="navbar-nav flex-nowrap ms-auto">
                                <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link"
                                        aria-expanded="false" data-bs-toggle="dropdown" href="#"><i
                                            class="fas fa-search"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in"
                                        aria-labelledby="searchDropdown">
                                        <form class="me-auto navbar-search w-100">
                                            <div class="input-group"><input
                                                    class="bg-light form-control border-0 small" type="text"
                                                    placeholder="Search for ...">
                                                <div class="input-group-append"><button class="btn btn-primary py-0"
                                                        type="button"><i class="fas fa-search"></i></button></div>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <li class="nav-item dropdown no-arrow mx-1">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                            aria-expanded="false" data-bs-toggle="dropdown" href="#"><span
                                                class="badge bg-danger badge-counter">3+</span><i
                                                class="fas fa-bell fa-fw"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                            <h6 class="dropdown-header">Notifications center</h6>
                                            <div id="notif">





                                            </div>

                                        </div>
                                        <script>
                                            $(function() {
                                                setInterval(() => {
                                                    GetNotif()
                                                }, 500);

                                                function GetNotif() {
                                                    $.ajax({
                                                        type: "post",
                                                        url: "{{ url('/GetNotif') }}",
                                                        data: {
                                                            _token: "{{ csrf_token() }}"
                                                        },
                                                        dataType: "json",
                                                        success: function(data) {
                                                            $('#notif').html("")
                                                            let i = 0;
                                                            let dest = "javascript:void()";
                                                            data.forEach(item => {
                                                                i++;
                                                                if (i > 3) {
                                                                    return false;
                                                                } else {
                                                                    if (item.title === "Friend Request") {
                                                                        dest = "{{ url('/home/Requests') }}";
                                                                    }
                                                                    $('#notif').append(`
                                                            <a class="dropdown-item d-flex align-items-center" href="${dest}">
                                                        <div class="me-3">
                                                            <div class="bg-primary icon-circle"><img
                                                                    src="uploads/${item.avatar}" width="45"
                                                                    height="45" class="rounded" alt=""></div>
                                                        </div>
                                                        <div><span
                                                                class="small text-gray-500">${item.title}</span>
                                                            <p>${item.subject}</p>
                                                        </div>
                                                        <div  '><label for="idNotif${i}"><i id="deleteNotif${i}" class="fad fa-trash"></i></label>
                                                 <input type="hidden" value="${item._id}" id="idNotif${i}"/></div>
                                                    </a>
                                                            `);

                                                                }


                                                                $("#deleteNotif" + i).on("click", function(e) {
                                                                    console.log("tey" + i);
                                                                });
                                                            });
                                                            if (data.length != 0) {
                                                                $('#notif').append(`<a class="dropdown-item text-center small text-gray-500" href="{{ url('/home/Notifications') }}">Show
                                                    All
                                                    Notifications</a>`);
                                                            } else {
                                                                $('#notif').append(
                                                                    `<a class="dropdown-item d-flex align-items-center">You have no notifications</a>`
                                                                );
                                                            }

                                                        },
                                                        error: (r) => {
                                                            console.log(r.responseText);
                                                        }
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                </li>
                                <li class="nav-item dropdown no-arrow mx-1">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                            aria-expanded="false" data-bs-toggle="dropdown" href="#"><span
                                                class="badge bg-danger badge-counter">7</span><i
                                                class="fas fa-envelope fa-fw"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                            <h6 class="dropdown-header">alerts center</h6>
                                            <div id="messageContent">


                                            </div>

                                            <script>
                                                jQuery(function($) {

                                                    let iduser = "{{ Session::get('id') }}";

                                                    let user = "";
                                                    socket.on("msgNumber", (from, content) => {
                                                        alertify.success("you have new message from " + from + "<br> " + content);
                                                    })

                                                    socket.emit('join', {
                                                        room: "{{ Session::get('id') }}"

                                                    });
                                                    socket.emit("chats", "{{ Session::get('id') }}");


                                                    socket.on("messages", (data1, user) => {
                                                        $("#messageContent").html("")

                                                        let lastmsg = "";
                                                        let from = "";
                                                        let active = "";
                                                        let time = "";

                                                        if (data1.length != 0) {
                                                            console.log(data1);
                                                            for (var i = 0; i < data1.length; i++) {

                                                                data1[i].messages.forEach(msg => {


                                                                });


                                                                console.log(lastmsg + " : " + from);
                                                                $.ajax({
                                                                    type: "post",
                                                                    url: "{{ url('/getUserByID') }}",
                                                                    data: {
                                                                        iduser: user[i],
                                                                        _token: "{{ csrf_token() }}"
                                                                    },
                                                                    dataType: "json",
                                                                    success: function(data) {

                                                                        if (data.from != "{{ Session::get('id') }}") {
                                                                            active = "active";
                                                                        }
                                                                        $("#messageContent").append(`<a class="dropdown-item d-flex align-items-center  " href="{{ url('/home/Messages') }}/${data[0] . _id}" style='font-weight:'>
                                                <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                        src="uploads/${data[0].avatar}">
                                                </div>
                                                <div class="fw-bold ${active}">
                                                    <div class="text-truncate"><span>${data[0].nom}</span></div>
                                                    <p class="small text-gray-500 mb-0">${data.lastmsg} - ${data.time}</p>
                                                </div>
                                            </a>`)


                                                                    },
                                                                    error: function(r) {
                                                                        console.log(r.responseText);
                                                                    }
                                                                });
                                                            }



                                                        }

                                                    });
                                                })
                                            </script>

                                            <a class="dropdown-item text-center small text-gray-500" href="#">Show
                                                All
                                                Alerts</a>
                                        </div>
                                    </div>
                                    <div class="shadow dropdown-list dropdown-menu dropdown-menu-end"
                                        aria-labelledby="alertsDropdown"></div>
                                </li>
                                <div class="d-none d-sm-block topbar-divider"></div>
                                <li class="nav-item dropdown no-arrow">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                            aria-expanded="false" data-bs-toggle="dropdown" href="#"><span
                                                class="d-none d-lg-inline me-2 text-gray-600 small">
                                                {{ Session::get('nom') }}
                                            </span><img class="border rounded-circle img-profile"
                                                src="uploads/{{ Session::get('avatar') }}"></a>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                            <a class="dropdown-item"
                                                href={{ url('/home/mainProfile/' . Session::get('id')) }}><i
                                                    class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile
                                            </a>

                                            <a class="dropdown-item" href="{{ url('/home/Profile') }}">

                                                <i
                                                    class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>

                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity
                                                log</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item"
                                                href="{{ url('/logout/' . Session::get('id')) }}"><i
                                                    class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="container-fluid">





                    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i
                            class="fas fa-angle-up"></i></a>
                    <script src="boots/js/bootstrap.min.js"></script>
                    <script src="boots/jsT/chart.min.js"></script>
                    <script src="boots/jsT/bs-init.js"></script>
                    <script src="boots/jsT/theme.js"></script>
                @else
                    <script>
                        window.location.href = "{{ url('/') }}"
                    </script>
    @endif
</body>

</html>
