<html lang="en">
<?php use App\Models\Actor;
$member = Actor::where('_id', '=', $id)->first();
$me = Actor::where('_id', '=', Session::get('id'))->first();
$ok = false;
$idchat = uniqid();
if ($member->chats && $me->chats) {
    foreach ($me->chats as $k => $v) {
        foreach ($member->chats as $key => $val) {
            if ($me->chats[$k]['id'] == $member->chats[$key]['id']) {
                $idchat = $me->chats[$k]['id'];
                break;
            }
            # code...
        }
        # code...
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chati - Messages</title>
    <style>
        .chatHeader {
            display: flex;
            flex-direction: row;
            text-align: left;
            align-content: flex-end;
            padding: 18px;
        }

        .chatHeader img {

            width: 50px;
            height: 50px;
            max-height: 100%;
            border-radius: 50%;
        }

        body {
            padding-top: 0;
            font-size: 12px;
            color: #777;
            background: #f9f9f9;
            font-family: 'Open Sans', sans-serif;
            margin-top: 20px;
        }

        .bg-white {
            background-color: #fff;
        }

        .friend-list {
            list-style: none;
            margin-left: -40px;
        }

        .friend-list li {
            border-bottom: 1px solid #eee;
        }

        .friend-list li a img {
            float: left;
            width: 45px;
            height: 45px;
            margin-right: 10px;
        }

        .friend-list li a {
            position: relative;
            display: block;
            padding: 10px;
            transition: all .2s ease;
            -webkit-transition: all .2s ease;
            -moz-transition: all .2s ease;
            -ms-transition: all .2s ease;
            -o-transition: all .2s ease;
        }

        .friend-list li.active a {
            background-color: #f1f5fc;
        }

        .friend-list li a .friend-name,
        .friend-list li a .friend-name:hover {
            color: #777;
        }

        .friend-list li a .last-message {
            width: 65%;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .friend-list li a .time {
            position: absolute;
            top: 10px;
            right: 8px;
        }

        small,
        .small {
            font-size: 85%;
        }

        .friend-list li a .chat-alert {
            position: absolute;
            right: 8px;
            top: 27px;
            font-size: 10px;
            padding: 3px 5px;
        }

        .chat-message {}

        .chat {
            list-style: none;
            margin: 0;
            overflow-y: auto;
            max-height: 350px;
            height: 100%;
        }

        .chat-message {
            background: #f9f9f9;
        }

        .chat li #img {
            width: 45px;
            height: 45px;
            border-radius: 50em;
            -moz-border-radius: 50em;
            -webkit-border-radius: 50em;
        }



        .left img {
            float: left;
        }

        .right img {
            float: right;
        }

        .chat-body {
            padding-bottom: 20px;
        }

        .chat li.left .chat-body {
            margin-left: 70px;
            background-color: #fff;
            width: 50%;
            font-size: 14px
        }

        .chat li .chat-body {
            position: relative;
            font-size: 11px;
            padding: 10px;
            border: 1px solid #f1f5fc;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .chat li .chat-body .header {
            padding-bottom: 5px;
            border-bottom: 1px solid #f1f5fc;
        }

        .chat li .chat-body p {
            margin: 0;
        }

        .chat li.left .chat-body:before {
            position: absolute;
            top: 10px;
            left: -8px;
            display: inline-block;
            background: #fff;
            width: 16px;
            height: 16px;
            border-top: 1px solid #f1f5fc;
            border-left: 1px solid #f1f5fc;
            content: '';
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
        }

        .chat li.right .chat-body:before {
            position: absolute;
            top: 10px;
            right: -8px;
            display: inline-block;
            background: #ece7e7;
            width: 16px;
            height: 16px;
            border-top: 1px solid #f1f5fc;
            border-right: 1px solid #f1f5fc;
            content: '';
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -o-transform: rotate(45deg);

        }

        .chat li {
            margin: 15px 0;
        }

        .chat li.right .chat-body {
            margin-right: 70px;
            background-color: #fff;
            width: 50%;
            font-size: 14px;
            float: right
        }

        .chat-box {
            /*
  position: fixed;
  bottom: 0;
  left: 444px;
  right: 0;
*/
            padding: 15px;
            border-top: 1px solid #eee;
            transition: all .5s ease;
            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            -ms-transition: all .5s ease;
            -o-transition: all .5s ease;
        }

        .primary-font {
            color: #3c8dbc;
        }

        a:hover,
        a:active,
        a:focus {
            text-decoration: none;
            outline: 0;
        }

    </style>
</head>

<body id="body">
    @if (Session::has('login'))
        @include('dashboard/topnav')


        <br><br><br><br>

        <div class="container bootstrap snippets bootdey">
            <div class="row" style="width: 60%;margin:0 auto;zoom:0.9;">

                <style>
                    .msgImg {
                        position: relative;
                        width: 100px;
                        height: 100px;

                    }

                    .msgImg img {
                        position: relative;
                        border: none;
                        border-radius: 0%;
                        width: 100px;
                        height: 100px;
                        border-radius: 4px;

                    }

                    .msgImg img:hover {
                        margin-top: -50px;
                        height: 300px;
                        width: 300px;
                        transition: 0.5s;
                        z-index: 99999999;


                    }

                </style>
                <div class="chat-box bg-transparent" style="border:none">
                    <div class=" chatHeader bg-gradient-dark">
                        <img src="uploads/{{ $member->avatar }}" alt="">

                        <h4 style="margin-left: 10px" ><a style="color: white;text-decoration: none" href={{ url('/home/mainProfile/' . $id) }}>{{ $member->nom }}</a>
                            <br> <span style="font-size: 10px"><i id="status" class="fas fa-circle"></i></span></h4><br>

                        <h6></h6>
                    </div>
                </div>
                </header>
                <!--=========================================================-->
                <!-- selected chat -->
                <input type="hidden" id="checkID" value={{ $idchat }}>

                <div class=" ">
                    <div class="chat-message">
                        <input type="hidden" disabled value="{{ Session::get('id') }}" name="" id="from">
                        <input type="hidden" disabled value="{{ $member->_id }}" name="" id="user2">
                        <script src="intense/intense.min.js"></script>


                        <ul class="chat bg-gradient-light" id="{{ $idchat }}" class="">




                        </ul>
                        <div id="typing">
                        </div>
                    </div>
                    <script>
                        window.onload = function() {
                            // Intensify all images on the page.
                            var element = document.getElementById('intense');
                            Intense(element);
                            console.log("intense");
                        }
                    </script>

                    <script>
                        $(document).ready(function() {


                            var checkId = $("#checkID").val();
                            $("#messagesP").addClass("active");
                            var status = $("#status");
                            var clear = $("#clear");
                            let ip_address = "127.0.0.1";
                            let socket_port = "3000";
                            let socket = io(ip_address + ':' + socket_port);
                            setInterval(() => {
                                socket.emit("checkStatus", "{{ $id }}");

                            }, 500);

                            socket.on("online", (status) => {
                                if (status == 1) {
                                    $("#status").css("color", "limegreen");
                                } else {
                                    $("#status").css("color", "red");

                                }
                            })
                            socket.emit("showMsg", {
                                idchat: checkId
                            }, checkId);

                            socket.emit('join', {
                                room: checkId

                            });
                            let sender = "";


                            socket.on("Init", (data) => {

                                let color = "";
                                $("#" + checkId).html("")
                                console.log(data);
                                if (data.length != 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        data[i].messages.forEach(element => {
                                            if (element.from === "{{ Session::get('id') }}") {
                                                pos = "right";
                                                sender = element.from;
                                                img = "{{ Session::get('avatar') }}";
                                                nom = "{{ Session::get('nom') }}";
                                                bg = "#ece7e7";
                                                textalign = "right";
                                            } else {
                                                pos = "left";
                                                sender = element.to;
                                                img = "{{ $member->avatar }}";
                                                nom = "{{ $member->nom }}";
                                                bg = "#f9f9f9";
                                                textalign = "left";



                                            }
                                            if (element.image && element.image != "") {
                                                src =
                                                    `<li class="${pos} clearfix" style="text-align:${textalign}" > 
                                                        <span class="chat-img pull-left">
                    	                            	            <img id="img" style="opacity:0" src="uploads/" alt="User Avatar">
                    	                                       </span>
                                                        	<div class="chat-body clearfix" style="background-color:${bg};">
                                                                
                                                        <p style="float:${pos}" class="msgImg"><img  src="messages/${element.image}"/></p>
                                                        </div>
                                                        </li>`
                                            } else {
                                                src = "";
                                            }
                                            $('#' + checkId).append(
                                                ` <li class="${pos} clearfix" style="text-align:${textalign}" >
                        <span class="chat-img pull-left">
                    		<img id="img" src="uploads/${img}" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix" style="background-color:${bg};">
                    		<div class="header">
                    			<strong class="primary-font">${nom}</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i>${element.date} , ${element.time} </small>
                    		</div>
                    		<p>
                    			${element.content} <br>
                                
                    		</p>
                           
                    	</div>
                         
                    </li>
                        ${src}`)

                                        });

                                    }


                                } else {
                                    $("#" + checkId).append("You have not started a conversation yet")
                                }
                            });
                            socket.on("outputS", (data) => {
                                $(".chat").stop().animate({
                                    scrollTop: 66666666
                                }, 800);
                                console.log(data);
                                if (data.length != 0) {
                                    for (var j = 0; j < data.length; j++) {
                                        if (data[j].from === "{{ Session::get('id') }}") {
                                            pos = "right";
                                            img = "{{ Session::get('avatar') }}";
                                            nom = "{{ Session::get('nom') }}";
                                            bg = "#ece7e7";
                                            textalign = "right";


                                        } else {
                                            pos = "left";
                                            img = "{{ $member->avatar }}";
                                            nom = "{{ $member->nom }}";
                                            bg = "#f9f9f9";
                                            textalign = "left";


                                        }
                                        if (data[j].image && data[j].image != "") {
                                            src =
                                                `<li class="${pos} clearfix" style="text-align:${textalign}" > 
                                                        <span class="chat-img pull-left">
                    	                            	            <img id="img" style="opacity:0" src="uploads/" alt="User Avatar">
                    	                                       </span>
                                                        	<div class="chat-body clearfix" style="background-color:${bg};">
                                                                
                                                        <p style="float:${pos}" class="msgImg"><img  src="messages/${data[j].image}"/></p>
                                                        </div>
                                                        </li>`

                                        } else {
                                            src = "";
                                        }

                                        $('#' + checkId).append(
                                            `<li class="${pos} clearfix" >
                        <span class="chat-img pull-left">
                    		<img id="img" src="uploads/${img}" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix" style="background-color:${bg}">
                    		<div class="header">
                    			<strong class="primary-font">${nom}</strong>
                    			<small class="pull-right text-muted">${moment(data[j].date).format("dddd ll")} , ${moment(new Date()).format("h:m a")} <i class="fa fa-clock-o"></i> </small>
                    		</div>
                    		<p>
                    			${data[j].content} <br>
                                

                    		</p>
                         

                          
                    	</div>
                    </li>
                    ${src} `)

                                    }

                                }

                            });

                            $(window).on("load", function() {


                            });
                            $(".chat").stop().animate({
                                scrollTop: 66666666
                            }, 800);



                            socket.on("isTyping", data => {
                                $("#typing").html("")

                                if (data) {
                                    $("#typing").append("User Is Typing");
                                }

                                setTimeout(() => {
                                    $("#typing").html("")

                                }, 1500);



                            })

                            let img1 = ""

                            $("#submit").on("click", () => {
                                if ($("#image").val() != "") {
                                    img1 = $("#image")[0].files[0].name;
                                }
                                console.log(img1);

                                try {
                                    let message = $("#chatInput").val();
                                    console.log(message);
                                    socket.emit("typing", checkId);


                                    socket.emit('input', {
                                        id: $("#checkID").val(),
                                        from: $("#from").val(),
                                        to: $("#user2").val(),
                                        content: $("#chatInput").val(),
                                        date: new Date(),
                                        image: img1


                                    }, checkId);
                                    $("#chatInput").val("");
                                    $('#uploadF').submit()
                                    $("#" + checkId).animate({
                                        scrollTop: $("#" + checkId).prop("scrollHeight")
                                    }, 500);
                                    return false;

                                } catch (error) {
                                    console.log(error.message)
                                }
                                $(".chat").stop().animate({
                                    scrollTop: $(".chat")[0].scrollHeight
                                }, 800);
                            })
                            $("#chatInput").keypress(function(e) {
                                if ($("#image").val() != "") {
                                    img1 = $("#image")[0].files[0].name;
                                }
                                console.log(img1);

                                try {
                                    let message = $(this).val();
                                    console.log(message);
                                    socket.emit("typing", checkId);



                                    if (e.which === 13 && !e.shiftKey) {
                                        socket.emit('input', {
                                            id: $("#checkID").val(),
                                            from: $("#from").val(),
                                            to: $("#user2").val(),
                                            content: $("#chatInput").val(),
                                            date: new Date(),
                                            image: img1


                                        }, checkId);
                                        $(this).val("");
                                        $('#uploadF').submit()
                                        $("#" + checkId).animate({
                                            scrollTop: $("#" + checkId).prop("scrollHeight")
                                        }, 500);
                                        return false;
                                    }
                                } catch (error) {
                                    console.log(error.message)
                                }
                                $(".chat").stop().animate({
                                    scrollTop: $(".chat")[0].scrollHeight
                                }, 800);
                            });


                        });
                    </script>
                    <script>
                        $(document).ready(function() {


                        });
                    </script>
                    <div class="chat-box bg-gradient-dark">
                        <div class="input-group">
                            <form enctype="multipart/form-data" style="width: 100%" id="uploadF">
                                <input class="form-control border no-shadow no-rounded"
                                    placeholder="Type your message here" id="chatInput" name="msg">
                                <input class="form-control border no-shadow no-rounded" name="image" id="image"
                                    type="file" style="width: 10px" hidden>

                                <span class="input-group-btn">
                                    <button class="btn btn-primary rounded" style="float:right;margin: 9px"
                                        type="submit" id="submit">Send</button>
                                </span>
                                <style>
                                    .emojyB {
                                        font-size: 25px;
                                        padding: 20px;
                                        float: right;
                                    }

                                    .emojyList {
                                        display: none;
                                        widows: 250px;
                                        height: 250px;
                                        max-height: 250px;
                                        min-height: 250px;
                                        min-width: 250px;
                                        position: absolute;
                                        background: #ccc;
                                        border: none;
                                        border-radius: 20px;
                                        box-shadow: 4px 2px 8px rgba(0, 0, 0, .5);
                                        overflow-y: auto;
                                        bottom: 90;
                                        left: 60%;
                                        transition: .3s;
                                        flex-direction: column;
                                        flex-wrap: wrap;

                                    }

                                </style>
                                <script>
                                    $(function() {

                                        var emojRange = [
                                            [128513, 128591],
                                            [9986, 10160],
                                            [128640, 128704]
                                        ];
                                        var newOption;
                                        var mySelect = document.getElementById('listEM')


                                        for (var i = 0; i < emojRange.length; i++) {
                                            var range = emojRange[i];
                                            for (var x = range[0]; x < range[1]; x++) {

                                                newOption = document.createElement('p');

                                                newOption.value = x;
                                                newOption.id = x;
                                                newOption.style.cursor = "pointer";

                                                newOption.innerHTML = "&#" + x + ";";

                                                mySelect.appendChild(newOption);
                                                let test = document.getElementById(x)
                                                test.onclick = () => {
                                                    $("#chatInput").val($("#chatInput").val() + test.innerHTML)
                                                }



                                            }

                                        }




                                        function showList() {
                                            let list = document.getElementById("listEM");
                                            if (list.style.display === "none") {
                                                $("#listEM").css("display", "flex");
                                            } else {
                                                $("#listEM").css("display", "none")

                                            }

                                        }
                                        $("#show").unbind().on("click", () => {
                                            showList()
                                        })
                                    });
                                </script>
                                <label class="emojyB" id="show"><i class="fas fa-smile "></i></label>

                                <div class="emojyList" id="listEM"></div>
                                <label style="font-size: 25px;padding:20px;float: right;" for="image"><i
                                        class="fas fa-camera"></i></label>
                                @csrf
                            </form>
                            <script>
                                jQuery(function($) {
                                    $('#uploadF').on("submit", function(e) {
                                        e.preventDefault();
                                        var form = $(this)[0];
                                        var formData = new FormData(form);
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ url('/uploadimg') }}",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(data) {
                                                console.log(data);
                                            },
                                            error: (r) => {
                                                console.log(r.responseText);
                                            }
                                        });
                                    })
                                })
                            </script>


                        </div><!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>
    @else
        <?php echo redirect('/'); ?>
    @endif


</body>

</html>
