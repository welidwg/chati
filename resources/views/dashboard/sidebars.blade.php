<?php use App\Models\Actor;
Session::put('LAST_ACTIVITY', time());
use Illuminate\Support\Facades\Route;

?>
<style>
   

    .data {
        width: 210px;
        max-width: 60vw;
        max-height: 70vh;
        background-color: #fffeff;
        border-radius: 15px;
        padding: 10px;
        display: flex;
        margin-bottom: 20px;
        flex-wrap: wrap;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.05);
    }

    @media all and (max-width: 200px) {
        .data {
            display: none
        }
    }

    .data .avatar {
        position: relative;
        float: left;
        padding: 6px;
        width: 50px
    }

    .data .avatar img {
        width: 40px;
        height: 40px;
        max-width: 100%;
        border-radius: 6px;

    }

    .data .alt {
        margin: 0 auto;
        margin-top: 8px
    }

    .data .alt h6 {
        font-size: 12px;
        font-weight: bolder
    }

    .data .alt span {
        font-size: 12px;
    }

    .data ul {
        margin: 0;
        width: 100%
    }

    .data ul li {
        border-bottom: 1px solid #fbfafc;

    }

    .data ul li a {
        font-weight: 700;

    }

    .data ul li:hover {
        font-weight: bolder;

    }




    .active {
        border-left: 4px solid #92bdef;
    }



    nav::-webkit-scrollbar {
        display: none;
    }

    .devider span {
        text-align: left
    }

    .data .buttons {
        display: inline-block;
        flex-wrap: wrap;
        padding: 11px;


    }

    .data .buttons button {
        display: inline-block;
        flex-wrap: wrap;
        padding: 11px;
        font-size: 12px;
        margin-left: 15px;
    }

</style>


@if (Session::has('login'))
    <?php $actor = Actor::where('_id', '=', Session::get('id'))->first(); ?>




    <nav class="navbar navbar-light align-items-start sidebar sticky-top " style="position: fixed;
                         top: 0;left:10;overflow: auto;overflow-x:hidden;height:100%;width: 300px;">
        <div class="container-fluid d-flex flex-column p-0" style="width: 350px">
            <br><br><br><br>
            <div class="data" id="accordionSidebar">
                <div class="avatar">
                    <img src="uploads/{{ Session::get('avatar') }}" alt="">
                </div>
                <div class="alt">
                    <h6>{{ Session::get('nom') }}</h6>
                    <span>@ {{ Session::get('username') }}</span>

                </div>

            </div>
            <div class="data">
                <ul class="navbar-nav " id="">
                    <li class="nav-item" id="home"><a class="nav-link " href="{{ url('/home') }}"><i
                                class=" far fa-home"></i>
                            <span>Home</span></a></li>
                    <li class="nav-item" id="profile">
                        <a class="nav-link" href={{ url('/home/mainProfile/' . Session::get('id')) }}>
                            <i class="far fa-user"></i><span>
                                Profile</span></a>
                    </li>
                    <li class="nav-item " id="Requests">
                        <a class="nav-link" id="Requests" href="{{ url('/home/Requests') }}">
                            <i class="far fa-users"></i>
                            Requests
                        </a>
                    </li>
                    <li class="nav-item " id="Contact">
                        <a class="nav-link " id="Contacts" href="{{ url('/home/Contacts') }}">
                            <i class="far fa-users"></i>
                            My Contacts
                        </a>
                    </li>
                    <li class="nav-item" id="SearchUser"><a class="nav-link"
                            href="{{ url('/home/SearchUser') }}"><i class="far fa-table"></i><span>Find
                                People</span></a></li>



                </ul>
            </div>
            <span>Tools</span>
            <div class="data">
                <ul class="navbar-nav " id="">
                    <li class="nav-item" id="profile"><a class="nav-link "
                            href="{{ url('home/Profile') }}"><i class=" far fa-users-cog"></i>
                            <span>Profile Settings</span></a></li>
                    <li class="nav-item" id="profile"><a class="nav-link "
                            href="{{ url('home/Profile') }}"><i class=" far fa-users-cog"></i>
                            <span>Exmaple Settings</span></a></li>



                </ul>

            </div>
            <!--<div class="text-center d-none d-md-inline "><button
                            class="bg-gradient-primary btn rounded-circle border-0" id="sidebarToggle"
                            type="button"></button></div>-->



        </div>
    </nav>
    <nav class="navbar navbar-light align-items-start sidebar " style="zoom: 1; position: fixed;
  top: 0;right:10;overflow: auto;overflow-x:hidden;height:90%;">
        <div class="container-fluid d-flex flex-column p-0" style="">
            <br><br><br><br>
            @if (request()->route()->uri != 'home/Requests')
                <div class="data" style="height: 40px;width: 100%">
                    <div class="avatar">
                        <i class="far fa-people-carry"></i>
                    </div>
                    <div class="alt">
                        <h6>Requests</h6>
                    </div>

                </div>

                @if ($actor->followersReq)
                    <?php $i = 0; ?>
                    @foreach ($actor->followersReq as $item)
                        @if ($i >= 2)
                            <?php break; ?>
                        @else
                            <?php
                            $i++;
                            $user = Actor::where('_id', '=', $item)->first(); ?>


                            <div class="data" id="accordionSidebar">
                                <div class="avatar">
                                    <img src="uploads/{{ $user->avatar }}" alt="">
                                </div>
                                <div class="alt">
                                    <h6>{{ $user->nom }}</h6>
                                    <span>wants to add you</span>

                                </div>

                                <div class="buttons">
                                    <button class="btn btn-primary" id="Accept{{ $i }}">Accept</button>
                                    <button class="btn btn-light" id="Decline{{ $i }}">Decline</button>
                                </div>
                                <input type="hidden" id="idContact{{ $i }}" value="{{ $user->_id }}">

                            </div>
                            <script>
                                jQuery(function($) {
                                    $("#Accept{{ $i }}").on("click", () => {
                                        console.log("test");
                                        $.ajax({
                                            type: "post",
                                            url: "{{ url('/ManageRequest') }}",
                                            data: {
                                                id_user: "{{ Session::get('id') }}",
                                                followerRequest: $('#idContact{{ $i }}').val(),
                                                _token: "{{ csrf_token() }}",
                                                query: "Accept"
                                            },
                                            success: function(data) {
                                                alertify.success(data)
                                                setTimeout(() => {
                                                    window.location.href = "{{ url('/home/Contacts') }}"

                                                }, 400);

                                            },
                                            error: function(r) {
                                                alert(r.responseText)
                                            }
                                        });
                                    })
                                    $("#Decline{{ $i }}").on("click", () => {
                                        console.log("test");
                                        $.ajax({
                                            type: "post",
                                            url: "{{ url('/ManageRequest') }}",
                                            data: {
                                                id_user: "{{ Session::get('id') }}",
                                                followerRequest: $('#idContact{{ $i }}').val(),
                                                _token: "{{ csrf_token() }}",
                                                query: "decline"
                                            },
                                            success: function(data) {
                                                alertify.success(data)
                                                setTimeout(() => {
                                                    window.location.href = "{{ url('/home/Contacts') }}"

                                                }, 400);

                                            },
                                            error: function(r) {
                                                alert(r.responseText)
                                            }
                                        });
                                    })
                                })
                            </script>
                        @endif

                    @endforeach
                    @if (count($actor->followersReq) > 2)
                        <script>
                            console.log("{{ count($actor->followersReq) }}");
                        </script>
                        <a href={{ url('home/Requests') }} style="text-decoration: none">see more</a>
                    @endif
                @else
                    <span>You have no requests</span>
                @endif
            @endif
            <br>
            <div class="data" style="height: 40px;width: 100%">
                <div class="avatar">
                    <i class="far fa-globe"></i>
                </div>
                <div class="alt">
                    <h6>Friends Online</h6>
                </div>

            </div>
            <script>
                $(function() {
                    setInterval(() => {
                        Online()
                    }, 500);

                    function Online() {
                        var myid = "{{ Session::get('id') }}";
                        $.ajax({
                            type: "get",
                            url: "{{ url('/GetOnline') }}",
                            dataType: "json",
                            success: function(data) {
                                if (data == 0) {
                                    $("#online").html("").append(
                                        `<div class="alt"><h6>No one is connected right now</h6></div>`);
                                } else {
                                    $("#online").html("").append(`<li class="nav-item" id="">
                                <a class="nav-link" href={{ url('/home/Messages/${data.id}') }}>
                                    <img class="rounded" src="uploads/${data.avatar}" width="25"
                                        height="25" />
                                    <span>${data.nom} <i class="fas fa-circle"
                                            style="color: limegreen"></i></span>
                                </a>

                            </li>`);
                                }

                            },
                            error: (r) => {
                                console.log(r.responseText);
                            }
                        });
                    }
                });
            </script>
            <div class="data">
                <ul class="navbar-nav " id="online">

                </ul>
            </div>

            <!--<div class="text-center d-none d-md-inline "><button
                            class="bg-gradient-primary btn rounded-circle border-0" id="sidebarToggle"
                            type="button"></button></div>-->



        </div>
    </nav>

@else
    {{ redirect()->to('/home') }}
@endif
