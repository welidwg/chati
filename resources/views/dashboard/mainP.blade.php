<?php use App\Models\Actor; ?>
<?php use App\Models\Post; ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - Profile</title>
    <style>
        body {
            margin-top: 60px;
        }

        .page-inner.no-page-title {
            padding-top: 30px;
        }

        .page-inner {
            position: relative;
            min-height: calc(100% - 56px);
            padding: 20px 30px 40px 30px;
            margin-top: 50px
        }

        .card.card-white {
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            box-shadow: 0 0.05rem 0.01rem rgba(75, 75, 90, 0.075);
            padding: 25px;
        }

        .grid-margin {
            margin-bottom: 2rem;
        }

        .profile-timeline ul li .timeline-item-header {
            width: 100%;
            overflow: hidden;
        }

        .profile-timeline ul li .timeline-item-header img {
            width: 40px;
            height: 40px;
            float: left;
            margin-right: 10px;
            border-radius: 50%;
        }

        .profile-timeline ul li .timeline-item-header p {
            margin: 0;
            color: #000;
            font-weight: 500;
        }

        .profile-timeline ul li .timeline-item-header p span {
            margin: 0;
            color: #8e8e8e;
            font-weight: normal;
        }

        .profile-timeline ul li .timeline-item-header small {
            margin: 0;
            color: #8e8e8e;
        }

        .profile-timeline ul li .timeline-item-post {
            padding: 20px 0 0 0;
            position: relative;
        }

        .profile-timeline ul li .timeline-item-post>img {
            width: 100%;
        }

        .timeline-options {
            overflow: hidden;
            margin-top: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #f1f1f1;
            padding: 10px 0 10px 0;
        }

        .timeline-options a {
            display: block;
            margin-right: 20px;
            float: left;
            color: #2b2b2b;
            text-decoration: none;

        }

        .timeline-options a i {
            margin-right: 3px;
        }

        .timeline-options a:hover {
            color: #5369f8;
        }

        .timeline-comment {
            overflow: hidden;
            margin-bottom: 10px;
            width: 100%;
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 5px;
        }

        .timeline-comment .timeline-comment-header {
            overflow: hidden;
        }

        .timeline-comment .timeline-comment-header img {
            width: 30px;
            border-radius: 50%;
            float: left;
            margin-right: 10px;
        }

        .timeline-comment .timeline-comment-header p {
            color: #000;
            float: left;
            margin: 0;
            font-weight: 500;
        }

        .timeline-comment .timeline-comment-header small {
            font-weight: normal;
            color: #8e8e8e;
        }

        .timeline-comment p.timeline-comment-text {
            display: block;
            color: #2b2b2b;
            font-size: 14px;
            padding-left: 40px;
        }

        .post-options {
            overflow: hidden;
            margin-top: 15px;
            margin-left: 15px;
        }

        .post-options a {
            display: block;
            margin-top: 5px;
            margin-right: 20px;
            float: left;
            color: #2b2b2b;
            text-decoration: none;
            font-size: 16px !important;
            text-decoration: none
        }

        .post-options a:hover {
            color: #5369f8;
        }

        .online {
            position: absolute;
            top: 2px;
            right: 2px;
            display: block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #ccc;
        }

        .online.on {
            background: #2ec5d3;
        }

        .online.off {
            background: #ec5e69;
        }

        #cd-timeline::before {
            border: 0;
            background: #f1f1f1;
        }

        .cd-timeline-content p,
        .cd-timeline-content .cd-read-more,
        .cd-timeline-content .cd-date {
            font-size: 14px;
        }

        .cd-timeline-img.cd-success {
            background: #2ec5d3;
        }

        .cd-timeline-img.cd-danger {
            background: #ec5e69;
        }

        .cd-timeline-img.cd-info {
            background: #5893df;
        }

        .cd-timeline-img.cd-warning {
            background: #f1c205;
        }

        .cd-timeline-img.cd-primary {
            background: #9f7ce1;
        }

        .page-inner.full-page {
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
        }

        .user-profile-card {
            text-align: center;
        }

        .user-profile-image {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .team .team-member {
            display: block;
            overflow: hidden;
            margin-bottom: 10px;
            float: left;
            position: relative;
        }

        .team .team-member .online {
            top: 5px;
            right: 5px;
        }

        .team .team-member img {
            width: 40px;
            float: left;
            border-radius: 50%;
            margin: 0 5px 0 5px;
        }

        .label.label-success {
            background: #43d39e;
        }

        .label {
            font-weight: 400;
            padding: 4px 8px;
            font-size: 11px;
            display: inline-block;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25em;
        }

    </style>
</head>


<body>

    @include('dashboard/topnav')
    @include('dashboard/sidebars')

    @if (Session::get('login') != null)
        <script>
            jQuery(function($) {
                $("#profile").addClass("active");
            })
        </script>
        <?php $actor = Actor::where('_id', '=', $id)->first();
        $post = Post::where('from', '=', $id)
            ->orderBy('created_at', 'desc')
            ->get(); ?>
        <div class="clean-block container col-md-8">
            <div class="page-inner no-page-title">
                <!-- start page main wrapper -->
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-lg-5 col-xl-3">
                            <div class="card card-white grid-margin">
                                <div class="card-heading clearfix">
                                    <h4 class="card-title">Profile </h4>
                                </div>
                                <div class="card-body user-profile-card mb-3">
                                    <img src="uploads/{{ $actor->avatar }}" class="user-profile-image rounded-circle"
                                        alt="" />
                                    <h4 class="text-center h6 mt-2">{{ $actor->nom }}</h4>
                                    <p class="text-center small">
                                        @if ($actor['experience'])

                                            @foreach ($actor['experience'] as $k)
                                                @if ($k['current'] == 1)
                                                    {{ $k['nomExp'] }}
                                                @endif

                                            @endforeach

                                        @else
                                            <p><a style="text-decoration: none" href="{{ url('/home/Profile') }}">Add
                                                    Experience</a></p>
                                        @endif
                                    </p>
                                    @if ($actor->_id == Session::get('id'))
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">
                                                Activity status</label>
                                            <input id="status" class="form-check-input" type="checkbox" name="current"
                                                id="flexSwitchCheckDefault">
                                            <script>
                                                jQuery(function($) {
                                                    var log = 1;
                                                    if ({{ $actor->logged }} == 1) {
                                                        $("#status").attr("checked", true)
                                                    }
                                                    $("#status").on("click", function(e) {
                                                        if ($(this).is(':checked')) {
                                                            log = 1
                                                        } else {
                                                            log = 0
                                                        }

                                                        $.ajax({
                                                            type: "post",
                                                            url: "{{ url('/Updatestatus') }}",
                                                            data: {
                                                                logged: log,
                                                                id: "{{ Session::get('id') }}",
                                                                _token: "{{ csrf_token() }}"
                                                            },
                                                            success: function(data) {
                                                                if (data == 0) {
                                                                    alertify.error("Offline Mode Enabled")

                                                                } else if (data == 1) {
                                                                    alertify.success("Back Online")
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
                                        </p>
                                    @endif

                                    @if ($actor->_id != Session::get('id'))

                                        @if ($actor->Friends)
                                            @foreach ($actor->Friends as $item)
                                                @if ($item == Session::get('id'))
                                                    <?php $ok = 'fas fa-user-minus'; ?>
                                                @else

                                                    <?php $ok = 'fas fa-user-plus'; ?>

                                                @endif

                                            @endforeach

                                        @endif
                                        <button class="btn btn-theme btn-sm" id="Follow">
                                            <i class="{{ $ok }}"></i>

                                        </button>
                                        <button class="btn btn-theme btn-sm" style="text-decoration: none">
                                            <a href={{ url('/home/Messages/' . $actor->_id) }}><i
                                                    class="fas fa-comments"></i> </a></button>
                                        <script>
                                            $(document).ready(function() {
                                                $("#Follow").unbind().on("click", () => {
                                                    $.ajax({
                                                        type: "post",
                                                        url: "{{ url('/Follow') }}",
                                                        data: {
                                                            id_user: "{{ Session::get('id') }}",
                                                            following: "{{ $id }}",
                                                            _token: "{{ csrf_token() }}"
                                                        },
                                                        success: function(data) {
                                                            alertify.success(data)
                                                            setInterval(() => {
                                                                window.location.reload()
                                                            }, 500);

                                                        },
                                                        error: function(r) {
                                                            alert(r.responseText)
                                                        }
                                                    });
                                                })
                                            });
                                        </script>
                                    @endif
                                </div>
                                <hr />
                                <div class="card-heading clearfix mt-3">
                                    <h4 class="card-title">Expriences</h4>
                                </div>
                                <div class="card-body mb-3">
                                    @if ($actor['experience'])

                                        @foreach ($actor['experience'] as $k)
                                            @if ($k['nomExp'] != null)

                                                <a href="#" class="label label-success mb-2">{{ $k['nomExp'] }}</a>
                                            @endif
                                        @endforeach

                                    @else
                                        <p><a style="text-decoration: none" href="{{ url('/home/Profile') }}">Add
                                                Experience ?</a></p>
                                    @endif



                                </div>
                                <hr />
                                <div class="card-heading clearfix mt-3">
                                    <h4 class="card-title">About</h4>
                                </div>
                                <div class="card-body mb-3">
                                    <p class="mb-0">
                                        {{ $actor->about }}
                                    </p>
                                </div>
                                <hr />
                                <div class="card-heading clearfix mt-3">
                                    <h4 class="card-title">Contact Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0 text-muted">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Email:</th>
                                                    <td>{{ $actor->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Phone:</th>
                                                    <td>{{ $actor->tel }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Address:</th>
                                                    <td>{{ $actor->address }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-9">
                            @if ($id == Session::get('id'))
                                <div class="card card-white grid-margin">
                                    <div class="card-body">
                                        <div class="post">
                                            <form action="" enctype="multipart/form-data" id="addPost">
                                                <textarea id="t" class="form-control" name="post" placeholder="Post"
                                                    rows="4"></textarea>
                                                <style>
                                                    #div {
                                                        position: relative;
                                                        overflow: hidden;
                                                        width: 20px;
                                                        height: 15px;
                                                        font-size: 10px;

                                                    }

                                                    #input {
                                                        width: 5px
                                                    }

                                                </style>
                                                <div class="post-options">

                                                    <label style="font-size: 19px;color:black" for="input"><i
                                                            class="fa fa-camera-retro"><input id="input" type="file"
                                                                name="file" accept="image/*" hidden /></i></label>

                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button class="btn btn-outline-primary float-right" type="submit"
                                                        style="float: right">Post</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <script>
                                jQuery(function($) {

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
                                                } else {
                                                    alertify.error(data);
                                                }

                                            },
                                            error: function(r) {
                                                alert(r.responseText)
                                            }
                                        })
                                    })
                                })
                            </script>
                            <div class="profile-timeline">
                                <ul class="list-unstyled">
                                    <li class="timeline-item">
                                        @if ($post)
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
                                                <input type="hidden" name="idpost" id="idPost{{ $j }}"
                                                    value={{ $p->_id }}>
                                                <div class="card card-white grid-margin">

                                                    <div class="card-body">
                                                        @if ($p->from == Session::get('id'))
                                                            <a class="btn btn-secondary"
                                                                style="position: absolute;right: 9;top:15;font-size: 12px"
                                                                id="delPost{{ $j }}"><i
                                                                    class="far fa-trash"></i></a>
                                                        @endif

                                                        <div class="timeline-item-header">
                                                            <img src="uploads/{{ $user->avatar }}" alt="avatar" />

                                                            <p>{{ $user->nom }} <span>
                                                                    @if ($p->image)
                                                                        posted a picture
                                                                    @else
                                                                        posted a status
                                                                    @endif
                                                                </span></p>
                                                            <small>
                                                                @foreach ($p['created'] as $item)
                                                                    {{ $item }}
                                                                @endforeach


                                                            </small>

                                                        </div>

                                                        <div class="timeline-item-post">
                                                            <p>{{ $p->content }}</p>
                                                            @if ($p->image)
                                                                <img src="posts/{{ $p->image }}" alt="" />
                                                            @endif

                                                            <div class="timeline-options">

                                                                <a href="javascript:void(0);"
                                                                    id="like{{ $j }}">
                                                                    <i class="fa fa-thumbs-up" @if (Session::has('liked_post'))

                                            @endif ></i> Like
                                            <span id="noLikes{{ $j }}">...</span>
                                            </a>
                                            <a href="#"><i class="fa fa-comment"></i> Comment</a>
                                            <a href="#"><i class="fa fa-share"></i> Share (2)</a>
                            </div>
                            <script>
                                jQuery(function($) {
                                    setInterval(() => {
                                        LikesNumber()
                                    }, 100);

                                    function LikesNumber() {

                                        $.ajax({
                                            url: "{{ url('/GetLikesNumber') }}",
                                            type: "get",
                                            data: {
                                                id_post: $("#idPost{{ $j }}").val(),
                                                _token: "{{ csrf_token() }}",
                                            },
                                            success: function(data) {
                                                $("#noLikes{{ $j }}").html("").append("( " + data + " )");
                                            },

                                        })

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

                                    }
                                    $("#like{{ $j }}").unbind().on('click', function() {
                                        $.ajax({
                                            url: "{{ url('/Like') }}",
                                            type: "post",
                                            data: {
                                                id: "{{ Session::get('id') }}",
                                                id_post: $("#idPost{{ $j }}").val(),
                                                _token: "{{ csrf_token() }}"

                                            },
                                            success: function(data) {
                                                alertify.success(data)
                                                if (data == "like") {
                                                    $("#like{{ $j }}").css("color", "limegreen")
                                                } else if (data == "unlike") {
                                                    $("#like{{ $j }}").css("color", "black")

                                                }


                                            },
                                            error: function(r) {
                                                alert(r.responseText)
                                            }

                                        })
                                    })
                                })
                            </script>
                            @php $i=0 @endphp
                            @if ($p['comments'])

                                @foreach ($p['comments'] as $item)
                                    <?php
                                    $i++;
                                    $comentor = Actor::where('_id', '=', $item['from'])->first();
                                    ?>
                                    <div class="timeline-comment">
                                        <div class="timeline-comment-header">
                                            <input type="hidden" id="idComment{{ $i }}"
                                                value={{ $item['_id'] }}>
                                            <img src="uploads/{{ $comentor->avatar }}" alt="" />
                                            <p>{{ $comentor->nom }} <small>{{ $item['date'] }}
                                                    -
                                                    {{ $item['time'] }}
                                                </small></p>
                                        </div>
                                        <p class="timeline-comment-text">{{ $item['content'] }}
                                        </p>
                                        @if ($comentor->_id == Session::get('id'))
                                            <span id="deleteComment{{ $i }}">
                                                <i class="fa fa-trash"></i></span>
                                        @endif
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $("#deleteComment{{ $i }}").on("click", function(e) {
                                                let id = $("#idComment{{ $i }}").val();
                                                $.ajax({
                                                    type: "post",
                                                    url: "{{ url('/deleteComment') }}",
                                                    data: {
                                                        id_post: $("#idPost").val(),
                                                        _token: "{{ csrf_token() }}",
                                                        id_comment: id
                                                    },
                                                    success: function(data) {
                                                        alert(data)

                                                    },
                                                    error: function(r) {
                                                        alert(r.responseText)
                                                    }
                                                });
                                            })
                                        });
                                    </script>
                                @endforeach

                            @else
                                <p>Not Yet</p>
                            @endif
                            <form id="addComment" method="POST">
                                <textarea class="form-control" id="comment" placeholder="Leave a comment"
                                    name="comment" required></textarea>
                                <input type="submit" value="Comment">
                                @csrf
                            </form>
                            <script>
                                jQuery(function($) {
                                    $("#addComment").on("submit", function(e) {
                                        e.preventDefault();
                                        $.ajax({
                                            type: "post",
                                            url: "{{ url('/addComment') }}",
                                            data: {
                                                id_post: $("#idPost").val(),
                                                comment: $("#comment").val(),
                                                id: "{{ Session::get('id') }}",
                                                _token: "{{ csrf_token() }}"
                                            },

                                            success: function(data) {
                                                alertify.success(data)
                                            },
                                            error: function(r) {
                                                alert(r.responseText)
                                            }

                                        });
                                    })

                                })
                            </script>
                        </div>
                    </div>
                </div>

    @endforeach
@else
    <p>Not yet</p>
    @endif


    </ul>
    </div>
    </div>
    <!--  <div class="col-lg-12 col-xl-3">
        <div class="card card-white grid-margin">
            <div class="card-heading clearfix">
                <h4 class="card-title">Suggestions</h4>
            </div>
            <div class="card-body">
                <div class="team">
                    <div class="team-member">
                        <div class="online on"></div>
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" />
                    </div>
                    <div class="team-member">
                        <div class="online on"></div>
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" />
                    </div>
                    <div class="team-member">
                        <div class="online off"></div>
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-white grid-margin">
            <div class="card-heading clearfix">
                <h4 class="card-title">Some Info</h4>
            </div>
            <div class="card-body">
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                    doloremque
                    laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis
                    architecto.</p>
            </div>
        </div>
    </div>-->
    </div>
    <!-- Row -->
    </div>
    <!-- end page main wrapper -->
    </div>
    </div>
@else
    {{ redirect()->to('/home') }}
    @endif
</body>

</html>
