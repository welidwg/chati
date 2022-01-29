<html lang="en">
<?php
use App\Models\Post;
use App\Models\Actor;
$id = Session::get('id');
$actor = Actor::where('_id', $id)->first();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test page</title>
</head>
<style>
    body {
        margin-top: 20px;

    }

    .profile-header {
        position: relative;
        overflow: hidden
    }

    .profile-header .profile-header-cover {
        background-image: url("uploads/{{ Session::get('avatar') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0
    }

    .profile-header .profile-header-cover:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .75) 100%)
    }

    .profile-header .profile-header-content {
        color: #fff;
        padding: 90px
    }

    .profile-header-img {
        float: left;
        width: 120px;
        height: 120px;
        overflow: hidden;
        position: relative;
        z-index: 10;
        margin: 0 0 -20px;
        padding: 3px;
        border-radius: 4px;
        background: #fff
    }

    .profile-header-img img {
        max-width: 100%
    }

    .profile-header-info h4 {
        font-weight: 500;
        color: #fff
    }

    .profile-header-img+.profile-header-info {
        margin-left: 140px
    }

    .profile-header .profile-header-content,
    .profile-header .profile-header-tab {
        position: relative
    }

    .b-minus-1,
    .b-minus-10,
    .b-minus-2,
    .b-minus-3,
    .b-minus-4,
    .b-minus-5,
    .b-minus-6,
    .b-minus-7,
    .b-minus-8,
    .b-minus-9,
    .b-plus-1,
    .b-plus-10,
    .b-plus-2,
    .b-plus-3,
    .b-plus-4,
    .b-plus-5,
    .b-plus-6,
    .b-plus-7,
    .b-plus-8,
    .b-plus-9,
    .l-minus-1,
    .l-minus-2,
    .l-minus-3,
    .l-minus-4,
    .l-minus-5,
    .l-minus-6,
    .l-minus-7,
    .l-minus-8,
    .l-minus-9,
    .l-plus-1,
    .l-plus-10,
    .l-plus-2,
    .l-plus-3,
    .l-plus-4,
    .l-plus-5,
    .l-plus-6,
    .l-plus-7,
    .l-plus-8,
    .l-plus-9,
    .r-minus-1,
    .r-minus-10,
    .r-minus-2,
    .r-minus-3,
    .r-minus-4,
    .r-minus-5,
    .r-minus-6,
    .r-minus-7,
    .r-minus-8,
    .r-minus-9,
    .r-plus-1,
    .r-plus-10,
    .r-plus-2,
    .r-plus-3,
    .r-plus-4,
    .r-plus-5,
    .r-plus-6,
    .r-plus-7,
    .r-plus-8,
    .r-plus-9,
    .t-minus-1,
    .t-minus-10,
    .t-minus-2,
    .t-minus-3,
    .t-minus-4,
    .t-minus-5,
    .t-minus-6,
    .t-minus-7,
    .t-minus-8,
    .t-minus-9,
    .t-plus-1,
    .t-plus-10,
    .t-plus-2,
    .t-plus-3,
    .t-plus-4,
    .t-plus-5,
    .t-plus-6,
    .t-plus-7,
    .t-plus-8,
    .t-plus-9 {
        position: relative !important
    }

    .profile-header .profile-header-tab {
        background: #fff;
        list-style-type: none;
        margin: -10px 0 0;
        padding: 0 0 0 140px;
        white-space: nowrap;
        border-radius: 0
    }

    .text-ellipsis,
    .text-nowrap {
        white-space: nowrap !important
    }

    .profile-header .profile-header-tab>li {
        display: inline-block;
        margin: 0
    }

    .profile-header .profile-header-tab>li>a {
        display: block;
        color: #929ba1;
        line-height: 20px;
        padding: 10px 20px;
        text-decoration: none;
        font-weight: 700;
        font-size: 12px;
        border: none
    }

    .profile-header .profile-header-tab>li.active>a,
    .profile-header .profile-header-tab>li>a.active {
        color: #242a30
    }

    .profile-content {
        padding: 25px;
        border-radius: 4px
    }

    .profile-content:after,
    .profile-content:before {
        content: '';
        display: table;
        clear: both
    }

    .profile-content .tab-content,
    .profile-content .tab-pane {
        background: 0 0
    }

    .profile-left {
        width: 200px;
        float: left
    }

    .profile-right {
        margin-left: 240px;
        padding-right: 20px
    }

    .profile-image {
        height: 175px;
        line-height: 175px;
        text-align: center;
        font-size: 72px;
        margin-bottom: 10px;
        border: 2px solid #E2E7EB;
        overflow: hidden;
        border-radius: 4px
    }

    .profile-image img {
        display: block;
        max-width: 100%
    }

    .profile-highlight {
        padding: 12px 15px;
        background: #FEFDE1;
        border-radius: 4px
    }

    .profile-highlight h4 {
        margin: 0 0 7px;
        font-size: 12px;
        font-weight: 700
    }

    .table.table-profile>thead>tr>th {
        border-bottom: none !important
    }

    .table.table-profile>thead>tr>th h4 {
        font-size: 20px;
        margin-top: 0
    }

    .table.table-profile>thead>tr>th h4 small {
        display: block;
        font-size: 12px;
        font-weight: 400;
        margin-top: 5px
    }

    .table.table-profile>tbody>tr>td,
    .table.table-profile>thead>tr>th {
        border: none;
        padding-top: 7px;
        padding-bottom: 7px;
        color: #242a30;
        background: 0 0
    }

    .table.table-profile>tbody>tr>td.field {
        width: 20%;
        text-align: right;
        font-weight: 600;
        color: #2d353c
    }

    .table.table-profile>tbody>tr.highlight>td {
        border-top: 1px solid #b9c3ca;
        border-bottom: 1px solid #b9c3ca
    }

    .table.table-profile>tbody>tr.divider>td {
        padding: 0 !important;
        height: 10px
    }

    .profile-section+.profile-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #b9c3ca
    }

    .profile-section:after,
    .profile-section:before {
        content: '';
        display: table;
        clear: both
    }

    .profile-section .title {
        font-size: 20px;
        margin: 0 0 15px
    }

    .profile-section .title small {
        font-weight: 400
    }

    body.flat-black {
        background: #E7E7E7
    }

    .flat-black .navbar.navbar-inverse {
        background: #212121
    }

    .flat-black .navbar.navbar-inverse .navbar-form .form-control {
        background: #4a4a4a;
        border-color: #4a4a4a
    }

    .flat-black .sidebar,
    .flat-black .sidebar-bg {
        background: #3A3A3A
    }

    .flat-black .page-with-light-sidebar .sidebar,
    .flat-black .page-with-light-sidebar .sidebar-bg {
        background: #fff
    }

    .flat-black .sidebar .nav>li>a {
        color: #b2b2b2
    }

    .flat-black .sidebar.sidebar-grid .nav>li>a {
        border-bottom: 1px solid #474747;
        border-top: 1px solid #474747
    }

    .flat-black .sidebar .active .sub-menu>li.active>a,
    .flat-black .sidebar .nav>li.active>a,
    .flat-black .sidebar .nav>li>a:focus,
    .flat-black .sidebar .nav>li>a:hover,
    .flat-black .sidebar .sub-menu>li>a:focus,
    .flat-black .sidebar .sub-menu>li>a:hover,
    .sidebar .nav>li.nav-profile>a {
        color: #fff
    }

    .flat-black .sidebar .sub-menu>li>a,
    .flat-black .sidebar .sub-menu>li>a:before {
        color: #999
    }

    .flat-black .page-with-light-sidebar .sidebar .active .sub-menu>li.active>a,
    .flat-black .page-with-light-sidebar .sidebar .active .sub-menu>li.active>a:focus,
    .flat-black .page-with-light-sidebar .sidebar .active .sub-menu>li.active>a:hover,
    .flat-black .page-with-light-sidebar .sidebar .nav>li.active>a,
    .flat-black .page-with-light-sidebar .sidebar .nav>li.active>a:focus,
    .flat-black .page-with-light-sidebar .sidebar .nav>li.active>a:hover {
        color: #000
    }

    .flat-black .page-sidebar-minified .sidebar .nav>li.has-sub:focus>a,
    .flat-black .page-sidebar-minified .sidebar .nav>li.has-sub:hover>a {
        background: #323232
    }

    .flat-black .page-sidebar-minified .sidebar .nav li.has-sub>.sub-menu,
    .flat-black .sidebar .nav>li.active>a,
    .flat-black .sidebar .nav>li.active>a:focus,
    .flat-black .sidebar .nav>li.active>a:hover,
    .flat-black .sidebar .nav>li.nav-profile,
    .flat-black .sidebar .sub-menu>li.has-sub>a:before,
    .flat-black .sidebar .sub-menu>li:before,
    .flat-black .sidebar .sub-menu>li>a:after {
        background: #2A2A2A
    }

    .flat-black .page-sidebar-minified .sidebar .sub-menu>li:before,
    .flat-black .page-sidebar-minified .sidebar .sub-menu>li>a:after {
        background: #3e3e3e
    }

    .flat-black .sidebar .nav>li.nav-profile .cover.with-shadow:before {
        background: rgba(42, 42, 42, .75)
    }

    .bg-white {
        background-color: #fff !important;
    }

    .p-10 {
        padding: 10px !important;
    }

    .media.media-xs .media-object {
        width: 32px;
    }

    .m-b-2 {
        margin-bottom: 2px !important;
    }

    .media>.media-left,
    .media>.pull-left {
        padding-right: 15px;
    }

    .media-body,
    .media-left,
    .media-right {
        display: table-cell;
        vertical-align: top;
    }

    select.form-control:not([size]):not([multiple]) {
        height: 34px;
    }

    .form-control.input-inline {
        display: inline;
        width: auto;
        padding: 0 7px;
    }


    .timeline {
        list-style-type: none;
        margin: 0;
        padding: 0;
        position: relative
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 5px;
        bottom: 5px;
        width: 5px;
        background: #2d353c;
        left: 20%;
        margin-left: -2.5px
    }

    .timeline>li {
        position: relative;
        min-height: 50px;
        padding: 20px 0
    }

    .timeline .timeline-time {
        position: absolute;
        left: 0;
        width: 18%;
        text-align: right;
        top: 30px
    }

    .timeline .timeline-time .date,
    .timeline .timeline-time .time {
        display: block;
        font-weight: 600
    }

    .timeline .timeline-time .date {
        line-height: 16px;
        font-size: 12px
    }

    .timeline .timeline-time .time {
        line-height: 24px;
        font-size: 20px;
        color: #242a30
    }

    .timeline .timeline-icon {
        left: 15%;
        position: absolute;
        width: 10%;
        text-align: center;
        top: 40px
    }

    .timeline .timeline-icon a {
        text-decoration: none;
        width: 20px;
        height: 20px;
        display: inline-block;
        border-radius: 20px;
        background: #d9e0e7;
        line-height: 10px;
        color: #fff;
        font-size: 14px;
        border: 5px solid #2d353c;
        transition: border-color .2s linear
    }

    .timeline .timeline-body {
        margin-left: 23%;
        margin-right: 17%;
        background: #fff;
        position: relative;
        padding: 20px 25px;
        border-radius: 6px
    }

    .timeline .timeline-body:before {
        content: '';
        display: block;
        position: absolute;
        border: 10px solid transparent;
        border-right-color: #fff;
        left: -20px;
        top: 20px
    }

    .timeline .timeline-body>div+div {
        margin-top: 15px
    }

    .timeline .timeline-body>div+div:last-child {
        margin-bottom: -20px;
        padding-bottom: 20px;
        border-radius: 0 0 6px 6px
    }

    .timeline-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e7eb;
        line-height: 30px
    }

    .timeline-header .userimage {
        float: left;
        width: 34px;
        height: 34px;
        border-radius: 40px;
        overflow: hidden;
        margin: -2px 10px -2px 0
    }

    .timeline-header .username {
        font-size: 16px;
        font-weight: 600
    }

    .timeline-header .username,
    .timeline-header .username a {
        color: #2d353c
    }

    .timeline img {
        max-width: 100%;
        display: block
    }

    .timeline-content {
        letter-spacing: .25px;
        line-height: 18px;
        font-size: 13px
    }

    .timeline-content:after,
    .timeline-content:before {
        content: '';
        display: table;
        clear: both
    }

    .timeline-title {
        margin-top: 0
    }

    .timeline-footer {
        background: #fff;
        border-top: 1px solid #e2e7ec;
        padding-top: 15px
    }

    .timeline-footer a:not(.btn) {
        color: #575d63
    }

    .timeline-footer a:not(.btn):focus,
    .timeline-footer a:not(.btn):hover {
        color: #2d353c
    }

    .timeline-likes {
        color: #6d767f;
        font-weight: 600;
        font-size: 12px
    }

    .timeline-likes .stats-right {
        float: right
    }

    .timeline-likes .stats-total {
        display: inline-block;
        line-height: 20px
    }

    .timeline-likes .stats-icon {
        float: left;
        margin-right: 5px;
        font-size: 9px
    }

    .timeline-likes .stats-icon+.stats-icon {
        margin-left: -2px
    }

    .timeline-likes .stats-text {
        line-height: 20px
    }

    .timeline-likes .stats-text+.stats-text {
        margin-left: 15px
    }

    .timeline-comment-box {
        background: #f2f3f4;
        margin-left: -25px;
        margin-right: -25px;
        padding: 20px 25px
    }

    .timeline-comment-box .user {
        float: left;
        width: 34px;
        height: 34px;
        overflow: hidden;
        border-radius: 30px
    }

    .timeline-comment-box .user img {
        max-width: 100%;
        max-height: 100%
    }

    .timeline-comment-box .user+.input {
        margin-left: 44px
    }

    .lead {
        margin-bottom: 20px;
        font-size: 21px;
        font-weight: 300;
        line-height: 1.4;
    }

    .text-danger,
    .text-red {
        color: #ff5b57 !important;
    }

</style>

<body>
    @include('dashboard/topnav')
    <style>
        a {
            text-decoration: none
        }

    </style>
    <div class="container " style="margin-top: 80px">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">
                    <!-- begin profile -->
                    <div class="profile">
                        <div class="profile-header">
                            <!-- BEGIN profile-header-cover -->
                            <div class="profile-header-cover"></div>
                            <!-- END profile-header-cover -->
                            <!-- BEGIN profile-header-content -->
                            <div class="profile-header-content">
                                <!-- BEGIN profile-header-img -->
                                <div class="profile-header-img">
                                    <img src="uploads/{{ Session::get('avatar') }}" alt="">
                                </div>
                                <!-- END profile-header-img -->
                                <!-- BEGIN profile-header-info -->
                                <div class="profile-header-info">
                                    <h4 class="m-t-10 m-b-5">{{ Session::get('nom') }}</h4>
                                    <p class="m-b-10">@ {{ Session::get('username') }}</p>
                                    <a href="#" class="btn btn-sm btn-info mb-2">Edit Profile</a>
                                </div>
                                <!-- END profile-header-info -->
                            </div>
                            <!-- END profile-header-content -->
                            <!-- BEGIN profile-header-tab -->
                            <ul class="profile-header-tab nav nav-tabs">
                                <li class="nav-item ">
                                    <a class="nav-link show" href={{ url('/home') }} data-toggle="tab">Back to
                                        home</a>
                                </li>
                                <li class="nav-item active" onclick="openCity(this,'POST')">
                                    <a class="nav-link show" data-toggle="tab">POSTS</a>
                                </li>
                                <li class="nav-item" onclick="openCity(this,'ABOUT')"> <a class="nav-link"
                                        data-toggle="tab">ABOUT</a></li>
                                <li class="nav-item"><a href="#profile-photos" class="nav-link"
                                        data-toggle="tab">PHOTOS</a></li>
                                <li class="nav-item"><a href="#profile-videos" class="nav-link"
                                        data-toggle="tab">VIDEOS</a></li>
                                <li class="nav-item"><a href="#profile-friends" class="nav-link"
                                        data-toggle="tab">FRIENDS</a></li>
                            </ul>
                            <!-- END profile-header-tab -->
                        </div>
                        <script>
                            function openCity(evt, cityName) {
                                console.log(cityName);
                                var i, tabcontent, tablinks;
                                tabcontent = document.getElementsByClassName("tab-pane");
                                for (i = 0; i < tabcontent.length; i++) {
                                    tabcontent[i].classList.remove("active");
                                }
                                tablinks = document.getElementsByClassName("nav-item");
                                for (i = 0; i < tablinks.length; i++) {
                                    tablinks[i].classList.remove("active");
                                }
                                document.getElementById(cityName).className += " active";
                                evt.className += " active";
                            }
                        </script>
                    </div>
                    <!-- end profile -->
                    <!-- begin profile-content -->
                    <div class="profile-content">
                        <!-- begin tab-content -->
                        <div class="tab-content p-0">
                            <!-- begin #profile-post tab -->
                            <div class="tab-pane fade show " id="ABOUT">
                                <ul class="timeline">
                                    <li>
                                        <div class="timeline-body">
                                            <div class="timeline-header">
                                                Experience
                                            </div>
                                            <div class="timeline-content">
                                                @if ($actor->experience)
                                                    @foreach ($actor->experience as $item)

                                                        <p>
                                                            {{ $item['nomExp'] }}
                                                        </p>
                                                    @endforeach

                                                @else
                                                    @if (Session::get('id') == $id)
                                                        <p>You have not added your experience yet , <a
                                                                href={{ url('home/Profile') }}>do you
                                                                want to ?</a></p>

                                                    @else
                                                        <p>{{ $actor->nom }} have not added experiences yet</p>

                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                    </li>
                                </ul>
                            </div>

                            <div class="tab-pane fade show active" id="POST">
                                <!-- begin timeline -->

                                <ul class="timeline">
                                    <div class="timeline-body">

                                        <div class="timeline-content">
                                            <form id="addPost" enctype="multipart/form-data" style="display: flex">
                                                <input type="hidden" name="id" value="{{ Session::get('id') }}">

                                                <div class="d-flex flex-row align-items-center feed-text px-1">
                                                    <input class="form-control" style="width: 100%;border:none"
                                                        type="text" name="post" placeholder="What is your mind ?" id="">
                                                </div>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <label style="font-size: 19px;color:black" for="input"><i
                                                        class="fa fa-camera-retro"><input id="input" type="file"
                                                            name="file" accept="image/*" hidden /></i></label>

                                                @csrf
                                                <div class="d-flex flex-row align-items-center feed-text px-4">
                                                    <button class="btn btn-primary">Post <i
                                                            class="far fa-paper-plane"></i></button>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $("#addPost").on("submit", function(e) {
                                                        e.preventDefault();
                                                        var form = $(this)[0];
                                                        var formData = new FormData(form);

                                                        $.ajax({
                                                            type: "post",
                                                            url: "{{ url('/AddPost') }}",
                                                            data: formData,
                                                            processData: false,
                                                            contentType: false,
                                                            success: function(data) {
                                                                if (data == 1) {
                                                                    alertify.success("Post added")
                                                                    setTimeout(() => {
                                                                        window.location.reload()
                                                                    }, 400);
                                                                } else {
                                                                    alertify.error(data);
                                                                }

                                                            },
                                                            error: function(r) {
                                                                console.log(r.responseText)
                                                            }
                                                        })
                                                    })
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <style>
                                        .feed-image img {
                                            width: 100%;
                                            height: auto;


                                        }

                                    </style>
                                    <?php
                                    $post = Post::where('from', '=', $id)
                                        ->orderBy('created_at', 'desc')
                                        ->get(); ?>
                                    @if (count($post) > 0)
                                        <?php $j = 0; ?>

                                        @foreach ($post as $p)
                                            @php
                                                if ($p->from != $id) {
                                                    $user = Actor::where('_id', '=', $p->from);
                                                } else {
                                                    $user = $actor;
                                                }
                                                $j++;
                                            @endphp
                                            <li>
                                                <!-- begin timeline-time -->
                                                <div class="timeline-time">
                                                    <span class="date" id="date{{ $j }}">
                                                        @if ($p->created['date'] == date('Y-m-d'))
                                                            Today
                                                        @elseif($p->created['date'] == date('Y-m-d', strtotime('-1 days')))
                                                            Yesterday
                                                        @else
                                                            <script>
                                                                $("#date{{ $j }}").append(moment("{{ $p->created['date'] }}").format("ll "))
                                                            </script>

                                                        @endif
                                                    </span>
                                                    <span class="time">{{ $p->created['time'] }}</span>
                                                </div>

                                                <!-- end timeline-time -->
                                                <!-- begin timeline-icon -->
                                                <div class="timeline-icon">
                                                    <a href="javascript:;">&nbsp;</a>
                                                </div>
                                                <!-- end timeline-icon -->
                                                <!-- begin timeline-body -->
                                                <div class="timeline-body">
                                                    <div class="timeline-header">
                                                        <span class="userimage"><img
                                                                src="uploads/{{ $user->avatar }}" alt=""></span>
                                                        <span class="username"><a
                                                                href="javascript:;">{{ $user->nom }}</a>
                                                            <small></small></span>
                                                        <span>
                                                            @if ($p->image)
                                                                posted a picture
                                                            @else
                                                                posted a status
                                                            @endif
                                                        </span>
                                                        @if ($user->_id == Session::get('id'))
                                                            <button
                                                                style="float: right;background:transparent;border:none"
                                                                id="delPost{{ $j }}"><i
                                                                    class="fad fa-trash"></i></button>
                                                            <script>
                                                                $(function() {
                                                                    $("#delPost{{ $j }}").unbind().on('click', function() {
                                                                        alertify.confirm("Confirmation", "Are you sure to delete this post ?", function() {
                                                                            let idpost = $("#idPost{{ $j }}").val();
                                                                            $.ajax({
                                                                                type: "delete",
                                                                                url: "{{ url('/DeletePost') }}",
                                                                                data: {
                                                                                    id: idpost,
                                                                                    _token: "{{ csrf_token() }}"
                                                                                },
                                                                                success: function(data) {
                                                                                    alertify.success(data)
                                                                                    setTimeout(() => {
                                                                                        window.location.reload();
                                                                                    }, 500);
                                                                                },
                                                                                error: (r) => {
                                                                                    alert(r.responseText)
                                                                                }
                                                                            });
                                                                        }, function() {})
                                                                    })
                                                                });
                                                            </script>
                                                        @endif
                                                        <!--<span class="pull-right text-muted">18 Views</span>-->
                                                    </div>
                                                    <div class="timeline-content">
                                                        <p style="font-size: 18px">
                                                            {{ $p->content }}
                                                        </p>
                                                        @if ($p->image)
                                                            <div class="feed-image" style="padding: 8px">
                                                                <img src="posts/{{ $p->image }}" alt=""
                                                                    class="rounded">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="" value="{{ $p->_id }}"
                                                        id="idPost{{ $j }}">
                                                    <div class="timeline-likes">
                                                        <div class="stats-right">
                                                            <span class="stats-text">259 Shares</span>
                                                            <span class="stats-text">{{ count($p->comments) }}
                                                                Comments</span>
                                                        </div>
                                                        <div class="stats">

                                                            <span class="fa-stack fa-fw stats-icon">
                                                                <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                                <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                                            </span>
                                                            <script>
                                                                $(function() {
                                                                    setInterval(() => {
                                                                        socket.emit("like1", {
                                                                            id_post: $("#idPost{{ $j }}").val(),
                                                                            iddiv: "#noLikes{{ $j }}"
                                                                        })
                                                                    }, 500);
                                                                    $("#like{{ $j }}").on("click ", () => {
                                                                        $("#like{{ $j }}").attr("disabled", true)
                                                                        setTimeout(() => {
                                                                            $("#like{{ $j }}").attr("disabled", false)

                                                                        }, 400);
                                                                        socket.emit("checkLike", {
                                                                            id_post: $("#idPost{{ $j }}").val(),
                                                                            id: "{{ Session::get('id') }}",
                                                                            iddiv: "#like{{ $j }}"
                                                                        });
                                                                    })
                                                                });
                                                            </script>
                                                            <span class="stats-total"
                                                                id="noLikes{{ $j }}"></span>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <?php
                                                        $color = '';
                                                        
                                                        if ($p->liked_by && count($p->liked_by['_id']) > 0) {
                                                            foreach ($p->liked_by['_id'] as $k) {
                                                                if ($k == Session::get('id')) {
                                                                    $color = '#4892ee';
                                                                } else {
                                                                    $color = '';
                                                                }
                                                                # code...
                                                            }
                                                        } ?>
                                                        <button
                                                            style="border: none;background:transparent;color:{{ $color }}"
                                                            href="javascript:;" id="like{{ $j }}"
                                                            class="m-r-15 text-inverse-lighter"><i
                                                                class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i>
                                                            Like</button>
                                                        <a href="javascript:;" id="commentClick{{ $j }}"
                                                            class="m-r-15 text-inverse-lighter"><i
                                                                class="fa fa-comments fa-fw fa-lg m-r-3"></i>
                                                            Comment</a>
                                                        <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i
                                                                class="fa fa-share fa-fw fa-lg m-r-3"></i> Share</a>
                                                    </div>
                                                    <div class="timeline-comment-box">
                                                        <div class="user"><img
                                                                src="uploads/{{ $user->avatar }}">
                                                        </div>
                                                        <div class="input">
                                                            <form id="addComment{{ $j }}" method="POST">
                                                                <div class="input-group">
                                                                    <input type="text" name="comment"
                                                                        id="comment{{ $j }}"
                                                                        class="form-control rounded-corner"
                                                                        placeholder="Write a comment...">
                                                                    <span class="input-group-btn p-l-10">
                                                                        <button id="submitF{{ $j }}"
                                                                            class="btn btn-primary f-s-12 rounded-corner"
                                                                            type="button">Comment</button>
                                                                    </span>
                                                                </div>
                                                            </form>

                                                            <script>
                                                                $(function() {
                                                                    $("#commentClick{{ $j }}").on("click", function() {
                                                                        $("#comment{{ $j }}").focus()
                                                                    })
                                                                    $("#comment{{ $j }}").keypress(function(e) {
                                                                        if (e.which === 13) {
                                                                            $("#addComment{{ $j }}").submit();

                                                                        }

                                                                    });
                                                                    $("#submitF{{ $j }}").on("click", function() {
                                                                        $("#addComment{{ $j }}").submit();


                                                                    });
                                                                    $("#addComment{{ $j }}").on("submit", function(e) {
                                                                        e.preventDefault();
                                                                        if ($("#comment{{ $j }}").val() == "") {
                                                                            alertify.error("You should add a comment");
                                                                            return false;
                                                                        }
                                                                        $.ajax({
                                                                            type: "post",
                                                                            url: "{{ url('/addComment') }}",
                                                                            data: {
                                                                                id_post: $("#idPost{{ $j }}").val(),
                                                                                comment: $("#comment{{ $j }}").val(),
                                                                                id: "{{ Session::get('id') }}",
                                                                                _token: "{{ csrf_token() }}"
                                                                            },
                                                                            dataType: "json",

                                                                            success: function(data) {
                                                                                alertify.success("Commented Successfully");
                                                                                $("#comment{{ $j }}").val("");
                                                                                $('#contComment{{ $j }}').append(`
                                                                                              <div class="user"><img
                                                                            src="uploads/${data.avatar}">
                                                                    </div>


                                                                    <div class="input">
                                                                        <span style="font-weight: bolder;color:#4892ee">
                                                                            ${data.from} </span>
                                                                        <input type="text"
                                                                            class="form-control rounded-corner"
                                                                            value="${data.content}" disabled
                                                                            style="border:none;width:auto;padding:15px">

                                                                    </div>
                                                                    <div class="dates">
                                                                            Today
                                                                        ,
                                                                        ${data.time}


                                                                    </div>
                                                    `)


                                                                            },
                                                                            error: function(r) {
                                                                                console.log(r.responseText)
                                                                            }

                                                                        });
                                                                    })
                                                                });
                                                            </script>
                                                        </div>
                                                        <?php $i = 0; ?>

                                                        @if ($p->comments)
                                                            @foreach ($p->comments as $item)
                                                                <?php
                                                                $commentor = Actor::where('_id', '=', $item['from'])->first();
                                                                $i++;
                                                                
                                                                ?>
                                                                <div class="timeline-comment-box"
                                                                    id="contComment{{ $j }}"
                                                                    style="border-top: 1px solid #ccc">
                                                                    <div class="user"><img
                                                                            src="uploads/{{ $commentor->avatar }}">
                                                                    </div>


                                                                    <div class="input">
                                                                        <span style="font-weight: bolder;color:#4892ee">
                                                                            {{ $commentor->nom }} </span>
                                                                        <input type="text"
                                                                            class="form-control rounded-corner"
                                                                            value="{{ $item['content'] }}" disabled
                                                                            style="border:none;width:auto;padding:15px">

                                                                    </div>
                                                                    <div class="dates">
                                                                        @if ($item['date'] == date('Y-m-d'))
                                                                            Today
                                                                        @else
                                                                            {{ $item['date'] }}
                                                                        @endif
                                                                        ,
                                                                        {{ $item['time'] }}


                                                                    </div>
                                                                    @if ($commentor->_id == Session::get('id'))
                                                                        <div class="delete">
                                                                            <button
                                                                                id="deleteComment{{ $j . $i }}"
                                                                                style="background: transparent;border:none">
                                                                                <i class="fad fa-trash"></i></button>

                                                                        </div>
                                                                    @endif

                                                                    <input type="hidden"
                                                                        id="idComment{{ $j . $i }}"
                                                                        value={{ $item['_id'] }} />
                                                                </div>
                                                                <script>
                                                                    $(function() {

                                                                        $("#deleteComment{{ $j . $i }}").on("click", function(e) {
                                                                            alertify.confirm("Confirmation", "Are you sure you want to delete this comment ?", function(
                                                                                param) {
                                                                                let id = $("#idComment{{ $j . $i }}").val();
                                                                                $.ajax({
                                                                                    type: "post",
                                                                                    url: "{{ url('/deleteComment') }}",
                                                                                    data: {
                                                                                        id_post: $("#idPost{{ $j }}").val(),
                                                                                        _token: "{{ csrf_token() }}",
                                                                                        id_comment: id
                                                                                    },
                                                                                    success: function(data) {
                                                                                        if (data == 1) {
                                                                                            alertify.success("deleted successfully");
                                                                                            setTimeout(() => {
                                                                                                window.location.reload()
                                                                                            }, 400);
                                                                                        }

                                                                                    },
                                                                                    error: function(r) {
                                                                                        console.log(r.responseText)
                                                                                    }
                                                                                });
                                                                            }, function(params) {

                                                                            })

                                                                        })
                                                                    });
                                                                </script>
                                                            @endforeach
                                                            <style>
                                                                .delete {
                                                                    float: right
                                                                }

                                                                .dates {
                                                                    float: right;
                                                                    font-size: 12px
                                                                }

                                                            </style>
                                                        @else
                                                        @endif


                                                    </div>
                                                </div>
                                                <!-- end timeline-body -->
                                            </li>
                                        @endforeach
                                        <script>
                                            $(function() {
                                                socket.on("like", (div) => {
                                                    alertify.success("liked");
                                                    $(`${div}`).css("color", "#4892ee")
                                                })
                                                socket.on("dislike", (div) => {
                                                    alertify.success("disliked");
                                                    $(`${div}`).css("color", "")

                                                })
                                                socket.on("likeNo", data => {
                                                    $(`${data.div}`).html("").append("" + data.likes + "");

                                                });
                                            });
                                        </script>

                                    @else
                                        <li>
                                            <div class="timeline-body">You have no posts yet</div>
                                        </li>
                                    @endif



                                    <li>
                                        <!-- begin timeline-icon -->
                                        <div class="timeline-icon">
                                            <a href="javascript:;">&nbsp;</a>
                                        </div>
                                        <!-- end timeline-icon -->
                                        <!-- begin timeline-body -->
                                        <div class="timeline-body">
                                            Loading...
                                        </div>
                                        <!-- begin timeline-body -->
                                    </li>
                                </ul>
                                <!-- end timeline -->
                            </div>
                            <!-- end #profile-post tab -->
                        </div>
                        <!-- end tab-content -->
                    </div>
                    <!-- end profile-content -->
                </div>
            </div>
        </div>
    </div>

</body>


</html>
