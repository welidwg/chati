<html lang="en">
<?php use App\Models\Actor; ?>
<?php use App\Models\Post; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - Search</title>
</head>
<style>
    /* ===== Career ===== */
    .career-form {
        background-color: white;
        border-radius: 5px;
        padding: 0 16px;
        position: sticky
    }

    .career-form .form-control {
        background-color: rgba(255, 255, 255, 0.2);
        border: 0;
        padding: 12px 15px;
        color: gray;
    }

    .career-form .form-control::-webkit-input-placeholder {
        /* Chrome/Opera/Safari */
        color: gray;
    }

    .career-form .form-control::-moz-placeholder {
        /* Firefox 19+ */
        color: gray;
    }

    .career-form .form-control:-ms-input-placeholder {
        /* IE 10+ */
        color: gray;
    }

    .career-form .form-control:-moz-placeholder {
        /* Firefox 18- */
        color: gray;
    }

    .career-form .custom-select {
        background-color: rgba(255, 255, 255, 0.2);
        border: 0;
        padding: 12px 15px;
        color: #fff;
        width: 100%;
        border-radius: 5px;
        text-align: left;
        height: auto;
        background-image: none;
    }

    .career-form .custom-select:focus {
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .career-form .select-container {
        position: relative;
    }

    .career-form .select-container:before {
        position: absolute;
        right: 15px;
        top: calc(50% - 14px);
        font-size: 10px;
        color: #ffffff;
        content: '\F2F9';
        font-family: "Material-Design-Iconic-Font";
    }

    .filter-result .job-box {
        -webkit-box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
        box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
        border-radius: 10px;
        padding: 10px 35px;
    }

    ul {
        list-style: none;
    }

    .list-disk li {
        list-style: none;
        margin-bottom: 12px;
    }

    .list-disk li:last-child {
        margin-bottom: 0;
    }

    .job-box .img-holder {
        height: 65px;
        width: 65px;

        border-radius: 65px;
    }

    .career-title {
        background-color: #f9f9f9;
        color: #fff;
        padding: 15px;
        text-align: center;
        border-radius: 10px 10px 0 0;
    }

    .job-overview {
        -webkit-box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
        box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
        border-radius: 10px;
    }

    @media (min-width: 992px) {
        .job-overview {
            position: -webkit-sticky;
            position: sticky;
            top: 70px;
        }
    }

    .job-overview .job-detail ul {
        margin-bottom: 28px;
    }

    .job-overview .job-detail ul li {
        opacity: 0.75;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .job-overview .job-detail ul li i {
        font-size: 20px;
        position: relative;
        top: 1px;
    }

    .job-overview .overview-bottom,
    .job-overview .overview-top {
        padding: 35px;
    }

    .job-content {
        margin-left: 20px
    }

    .job-content ul li {
        font-weight: 600;
        opacity: 0.75;
        border-bottom: 1px solid #ccc;
        padding: 10px 5px;
    }

    @media (min-width: 768px) {
        .job-content ul li {
            border-bottom: 0;
            padding: 0;
        }
    }

    .job-content ul li i {
        font-size: 20px;
        position: relative;
        top: 1px;
    }

    .mb-30 {
        margin-bottom: 30px;
    }

</style>

<body>

    @include('dashboard/topnav')
    @include('dashboard/sidebars')

    <br><br><br><br>
    <script>
        jQuery(function($) {
            $("#SearchUser").addClass("active");
        })
    </script>
    <?php $id = Session::get('id');
    $actor = Actor::where('_id', '!=', $id)->get();
    
    ?>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"
        integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />

    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mb-4">
                <div class="section-title text-center ">
                    <h3 class="top-c-sep">Users List</h3>

                </div>
            </div>
        </div>

        <div class="row" style="zoom: 0.8">
            <div class="col-lg-8 mx-auto">
                <div class="career-search mb-60">

                    <form action="#" class="career-form mb-60">
                        <div class="row">
                            <div class="col-md-5 col-lg-9 my-3">
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control" placeholder="Enter Your Keywords"
                                        id="keywords">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3 my-3">
                                <button type="button" class="btn btn-lg btn-block btn-light btn-custom"
                                    id="contact-submit">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="filter-result">

                        <?php $i = 0; ?>
                        @foreach ($actor as $contact)

                            <?php
                            $i++;
                            $ok = false;
                            $req = false;
                            $ic = 'fas fa-user-plus';
                            
                            $id = 'Unfollow' . $i;
                            
                            ?>
                            @if ($contact->followersReq)
                                @foreach ($contact->followersReq as $it1)

                                    @if ($it1 === Session::get('id'))


                                        <?php $req = true;
                                        $id = 'Unfollow' . $i;
                                        
                                        ?>
                                    @else
                                        <?php $req = false;
                                        
                                        ?>

                                    @endif

                                @endforeach
                            @endif
                            @if ($contact->Friends)
                                @foreach ($contact->Friends as $it)

                                    @if ($it === Session::get('id'))
                                        <?php $ok = true;
                                        $id = 'UnFriend' . $i;
                                        
                                        ?>
                                    @else
                                        <?php $ok = false;
                                        
                                        ?>

                                    @endif

                                @endforeach

                            @endif
                            <?php
                            if ($ok || $req) {
                                $ic = 'fas fa-user-minus';
                            } else {
                                $ic = 'fas fa-user-plus';
                            }
                            ?>

                            <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                                <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                    <img class="rounded" width="75 " height="75"
                                        src="uploads/{{ $contact->avatar }}" alt="">
                                    <h5 class="text-center  ml-6">&nbsp;&nbsp;
                                        <a style="text-decoration: none"
                                            href={{ url('home/mainProfile') . '/' . $contact->_id }}>{{ $contact->nom }}</a>
                                    </h5>


                                </div>
                                <div class="job-content">
                                    <button id="{{ $id }}"
                                        class="btn d-block w-50 d-sm-inline-block btn-light border"><i
                                            class="{{ $ic }}"></i></button>
                                    <a href="{{ url('/home/Messages/' . $contact->_id) }}"
                                        class="btn d-block w-50 d-sm-inline-block btn-primary"><i
                                            class="far fa-comment-alt-lines"></i></a>

                                </div>
                                <input type="hidden" value="{{ $contact->_id }}" id="idContact{{ $i }}">

                            </div>
                            <script>
                                $("#Unfollow{{ $i }}").unbind().on("click", () => {
                                    $.ajax({
                                        type: "post",
                                        url: "{{ url('/Follow') }}",
                                        data: {
                                            id_user: "{{ Session::get('id') }}",
                                            following: $('#idContact{{ $i }}').val(),
                                            _token: "{{ csrf_token() }}"
                                        },
                                        success: function(data) {
                                            alertify.success(data)
                                            setTimeout(() => {
                                                window.location.reload()

                                            }, 400);

                                        },
                                        error: function(r) {
                                            alert(r.responseText)
                                        }
                                    });
                                })
                                $("#UnFriend{{ $i }}").unbind().on("click", () => {
                                    $.ajax({
                                        type: "post",
                                        url: "{{ url('/UnFriend') }}",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            id_user: "{{ Session::get('id') }}",
                                            other: $('#idContact{{ $i }}').val(),

                                        },

                                        success: function(data) {
                                            alertify.success(data);
                                            setTimeout(() => {
                                                window.location.reload();
                                            }, 400);

                                        },
                                        error: function(r) {
                                            alert(r.responseText)
                                        }
                                    });
                                })
                            </script>

                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
