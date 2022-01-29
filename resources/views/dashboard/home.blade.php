<html lang="en">
<?php use App\Models\Actor; ?>
<?php use App\Models\Post;
$j = 0; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - home</title>

</head>
<style>
    .row {
        background-color: transparent
    }

    .time {
        font-size: 13px !important
    }



    .socials i {
        margin-right: 14px;
        font-size: 17px;
        color: #d2c8c8;
        cursor: pointer
    }

    .feed-image img {
        width: 100%;
        height: auto
    }

</style>

<body>
    @include('dashboard/topnav')
    <br><br><br><br>
    @include('dashboard/sidebars')

    <script>
        jQuery(function($) {
            $("#home").addClass("active");
        })
    </script>

    <div class="d-flex  row" style="">

        <div class="col-md-6" style="margin:  0 auto;">
            <div class="bg-white  mt-2"
                style="border-radius: 15px;padding: 9px;box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.05);zoom:0.8 ;">
                <div>
                    <div class="d-flex flex-row justify-content-between align-items-center p-2 ">
                        <div class="d-flex flex-row align-items-center feed-text px-1">
                            <img class="rounded" style="margin-right: 8px"
                                src="uploads/{{ Session::get('avatar') }}" width="45">

                        </div>
                        <form id="addPost" enctype="multipart/form-data" style="display: flex">
                            <input type="hidden" name="id" value="{{ Session::get('id') }}">

                            <div class="d-flex flex-row align-items-center feed-text px-4">
                                <input class="form-control" style="width: 500px;border:none" type="text" name="post"
                                    placeholder="What is your mind ?" id="">
                            </div>
                            <label style="font-size: 19px;color:black" for="input"><i class="fa fa-camera-retro"><input
                                        id="input" type="file" name="file" accept="image/*" hidden /></i></label>

                            @csrf
                            <div class="d-flex flex-row align-items-center feed-text px-4">
                                <button class="btn btn-primary">Post <i class="far fa-paper-plane"></i></button>
                            </div>
                        </form>
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
                            })
                        </script>
                    </div>
                </div>
            </div>
            <!-- <div class="feed p-2">
                    <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white border">
                        <div class="feed-text px-2">
                            <h6 class="text-black-50 mt-2">What's on your mind</h6>
                        </div>
                        <div class="feed-icon px-2"><i class="fa fa-long-arrow-up text-black-50"></i></div>
                </div>-->
            <?php $posts = Post::where('from', '!=', Session::get('id'))
                ->orderBy('created_at', 'desc')
                ->get();
            $i = 0;
            ?>
            @if ($posts)
                @foreach ($posts as $post)
                    <?php $owner = Actor::where('_id', '=', $post->from)->first();
                    
                    $i++; ?>
                    <input type="hidden" name="" id="idPost{{ $i }}" value="{{ $post->_id }}">


                    <div class="bg-white  mt-2" id="post{{ $i }}"
                        style="border-radius: 15px;padding: 9px;box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.05);zoom:0.8 ">
                        <div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-2 ">
                                <div class="d-flex flex-row align-items-center feed-text px-2"><img
                                        class="rounded" style="margin-right: 8px"
                                        src="uploads/{{ $owner->avatar }}" width="45">
                                    <div class="d-flex flex-column flex-wrap ml-2"><span class="font-weight-bold">
                                            <a style="text-decoration: none;font-weight: bolder"
                                                href={{ url('home/mainProfile/' . $owner->_id) }}>{{ $owner->nom }}</a></span><span
                                            class="text-black-50 time">
                                            @foreach ($post['created'] as $d)
                                                {{ $d }}
                                            @endforeach
                                        </span></div>
                                </div>
                                <div class="feed-icon px-2"><i class="fa fa-ellipsis-v text-black-50"></i></div>
                            </div>
                        </div>
                        <div class="p-2 px-3"><span
                                style="font-size: 19px;color:black;letter-spacing: 0.8">{{ $post->content }}</span>
                        </div>
                        <div class="feed-image p-2 px-3">
                            @if ($post->image)
                                <img class="img-fluid img-responsive" src="posts/{{ $post->image }}">
                            @endif
                        </div>
                        <?php
                        $color = '';
                        
                        if ($post->liked_by && count($post->liked_by['_id']) > 0) {
                            foreach ($post->liked_by['_id'] as $k) {
                                if ($k == Session::get('id')) {
                                    $color = '#4892ee';
                                } else {
                                    $color = '';
                                }
                                # code...
                            }
                        } ?>
                        <div style="font-size: 12px">
                            <span class="fa-stack fa-fw stats-icon">
                                <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                            </span>
                            <span class="stats-total" id="noLikes{{ $i }}"></span>
                        </div>

                        <div class="timeline-footer">
                            <button style="border: none;background:transparent;color:{{ $color }}"
                                href="javascript:;" id="like{{ $i }}" class="m-r-15 text-inverse-lighter"><i
                                    class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i>
                                Like</button>
                            <a href="javascript:;" id="commentClick{{ $i }}"
                                class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i>
                                Comment</a>
                            <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i
                                    class="fa fa-share fa-fw fa-lg m-r-3"></i> Share</a>

                        </div>
                        <script>
                            $(function() {

                                $("#like{{ $i }}").on('click', function(e) {
                                    $(this).attr("disabled", true);
                                    setTimeout(function() {
                                        $("#like{{ $i }}").attr("disabled", false);

                                    }, 400);

                                    socket.emit("checkLike", {
                                        id_post: $("#idPost{{ $i }}").val(),
                                        id: "{{ Session::get('id') }}",
                                        iddiv: "#like{{ $i }}"

                                    });



                                    /* $.ajax({
                                         url: "{{ url('/Like') }}",
                                         type: "post",
                                         data: {
                                             id: "{{ Session::get('id') }}",
                                             id_post: $("#idPost{{ $i }}").val(),
                                             _token: "{{ csrf_token() }}"

                                         },
                                         success: function(data) {
                                             alertify.success(data)
                                             if (data == "like") {
                                                 $("#colorize{{ $i }}").css("color", "limegreen")
                                             } else if (data == "unlike") {
                                                 $("#colorize{{ $i }}").css("color", "black")

                                             }


                                         },
                                         error: function(r) {
                                             alert(r.responseText)
                                         }

                                     })*/
                                })

                                setInterval(() => {
                                    socket.emit("like1", {
                                        id_post: $("#idPost{{ $i }}").val(),
                                        iddiv: "#noLikes{{ $i }}"
                                    })
                                }, 500);


                                function LikesNumber() {

                                    $.ajax({
                                        url: "{{ url('/GetLikesNumber') }}",
                                        type: "post",
                                        data: {
                                            id_post: $("#idPost{{ $i }}").val(),
                                            _token: "{{ csrf_token() }}",
                                        },
                                        success: function(data) {
                                            $("#noLikes{{ $i }}").html("").append("" + data + "");
                                        },
                                        error: function(r, v, e) {
                                            console.log(r.responseText);
                                        }

                                    })

                                }
                            });
                        </script>
                        <style>
                            a {
                                text-decoration: none
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

                        </style>
                        <div style="background: whitesmoke">

                            <form id="addComment{{ $i }}" method="POST">
                                <div
                                    class="d-flex flex-row justify-content-between align-items-center p-2 border-top border-bottom">
                                    <div class="d-flex flex-row align-items-center feed-text px-2"><img
                                            class="rounded-circle" src="uploads/{{ Session::get('avatar') }}"
                                            width="45">
                                        <div class="d-flex flex-column flex-wrap ml-2">
                                            <textarea
                                                style="border-radius: 11px;margin-left:25px;padding:6px;resize: unset"
                                                name="comment" class="form-control" id="comment{{ $i }}"
                                                cols="50" rows="1" placeholder="Leave a comment" required></textarea>
                                        </div>
                                    </div>
                                    <button class="feed-icon px-2 btn btn-primary" id="submitF{{ $i }}"
                                        type="submit"><i class="fad fa-paper-plane"></i></button>
                                </div>
                            </form>

                            <?php $j = 0; ?>
                            <div id="contComment{{ $i }}">
                                @if ($post->comments)

                                    @foreach ($post->comments as $item)
                                        <?php
                                        $comentor = Actor::where('_id', '=', $item['from'])->first();
                                        $j++;
                                        
                                        ?>
                                        <div
                                            class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                                            <div class="d-flex flex-row align-items-center feed-text px-2">
                                                <img class="rounded-circle" src="uploads/{{ $comentor->avatar }}"
                                                    width="45">
                                                <div class="d-flex flex-column flex-wrap ml-2"
                                                    style="margin-left: 20px">
                                                    <span class="font-weight-bold"
                                                        style="color:#4892ee">{{ $comentor->nom }}</span>
                                                    <span class="text-black-50 time">
                                                        @if ($item['date'] == date('Y-m-d'))
                                                            Today
                                                        @else
                                                            {{ $item['date'] }}
                                                        @endif
                                                        ,

                                                        {{ $item['time'] }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <input type="text"
                                                        style="border-radius: 11px;margin-left:25px;padding:6px;border:none;resize: none;width: auto"
                                                        disabled class="form-control" name="" id="" rows="1"
                                                        value="{{ $item['content'] }}" />


                                                </div>
                                                <div style="font-size: 13px">
                                                </div>
                                            </div>
                                            <input type="hidden" id="idComment{{ $j }}"
                                                value={{ $item['_id'] }} />

                                            @if ($comentor->_id == Session::get('id'))
                                                <div id="deleteComment{{ $j }}" class=" feed-icon px-2">
                                                    <i class="fa fa-trash text-black-50"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("#deleteComment{{ $j }}").on("click", function(e) {
                                                    alertify.confirm("Confirmation", "Are you sure you want to delete this ?", function(param) {
                                                        let id = $("#idComment{{ $j }}").val();
                                                        $.ajax({
                                                            type: "post",
                                                            url: "{{ url('/deleteComment') }}",
                                                            data: {
                                                                id_post: $("#idPost{{ $i }}").val(),
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

                                @else
                                    <div class="d-flex flex-row justify-content-between align-items-center p-2 ">
                                        <div class="d-flex flex-row align-items-center feed-text px-2">
                                            Post have no comments yet , be the first.
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#comment{{ $i }}").keypress(function(e) {
                                if (e.which === 13) {
                                    $("#addComment{{ $i }}").submit();

                                }

                            });
                            $("#submitF{{ $i }}").on("click", function() {
                                $("#addComment{{ $i }}").submit();


                            });
                            $("#addComment{{ $i }}").on("submit", function(e) {
                                e.preventDefault();
                                if ($("#comment{{ $i }}").val() == "") {
                                    alertify.error("You should add a comment");
                                    return false;
                                }
                                $.ajax({
                                    type: "post",
                                    url: "{{ url('/addComment') }}",
                                    data: {
                                        id_post: $("#idPost{{ $i }}").val(),
                                        comment: $("#comment{{ $i }}").val(),
                                        id: "{{ Session::get('id') }}",
                                        _token: "{{ csrf_token() }}"
                                    },
                                    dataType: "json",

                                    success: function(data) {
                                        alertify.success("Commented Successfully");
                                        $("#comment{{ $i }}").val("");
                                        $('#contComment{{ $i }}').append(`
                                                       <div
                                            class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                                            <div class="d-flex flex-row align-items-center feed-text px-2">
                                                <img class="rounded-circle" src="uploads/${data.avatar}"
                                                    width="45">
                                                <div class="d-flex flex-column flex-wrap ml-2"
                                                    style="margin-left: 20px">
                                                    <span class="font-weight-bold">${data.from}</span>
                                                    <span class="text-black-50 time">
                                                       Today

                                                    </span>
                                                </div>
                                                <div>
                                                    <textarea
                                                        style="border-radius: 11px;margin-left:25px;padding:6px;border:none;resize: none"
                                                        disabled name="" id="" cols="50"
                                                        rows="1">${data.content}</textarea>


                                                </div>
                                                <div style="font-size: 13px">
                                                    ${data.time}
                                                </div>
                                            </div>
                                            

                                            
                                                <div id="deleteComment{{ $j }}" class=" feed-icon px-2">
                                                    <i class="fa fa-trash text-black-50"></i>
                                                </div>
                                          
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
                @endforeach
            @else
                <div class="d-flex justify-content-end socials p-2 py-3">There is no posts YET</div>
            @endif


        </div>
    </div>
    </div>
    </div>

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
</body>

</html>
