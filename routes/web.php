<?php

use App\Events\webSocketDemo;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\NotificationController;
use App\Models\Actor;
use App\Models\Post;
use App\Models\Chat;
use App\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('index');
});
Route::get("/login", function () {
    return view("Auth/login");
});
Route::get("/register", function () {
    return view("Auth/register");
});
Route::get("/nav", function () {
    return view("navigation");
});

Route::get("/home", function () {
    return view("dashboard/home");
});
Route::get("/home/Profile", function () {
    return view("dashboard/profile");
});
Route::get("/home/mainProfile/{id}", function ($id) {
    return view("dashboard/mainP", ["id" => $id]);
});
Route::get("/home/Messages/{id}", function ($id) {
    return view("dashboard/messages", ["id" => $id]);
});
Route::get("/test", function () {
    return view("dashboard/test",);
});


Route::get("/home/Contacts", function () {

    $actor = Actor::where("_id", "=", Session::get("id"))->first();
    /* foreach ($actor->following as $item) {
        $con = Actor::where("_id", "=", $item)->simplePaginate(2);
        # code...
    }*/
    return view("dashboard/Contacts");
});
Route::get("/home/SearchUser", function () {
    return view("dashboard/SearchUsers");
});
Route::get("/logout/{id}", function ($id) {

    Session::flush();
    $actor = Actor::where("_id", '=', $id)->first();
    $actor->logged = 0;
    $actor->save();
    return redirect(url('/?logout'));
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/home/Requests', function () {
    $actor = Actor::where("_id", "=", Session::get("id"))->first();
    return view("dashboard/requests", ["actor" => $actor]);
});

//Route::post("/addUser","App\Http\Controllers\dataB@addUser");
Route::post("/addUser", "App\Http\Controllers\ActorController@addActor");
Route::post("/verifyName", "App\Http\Controllers\ActorController@verifUsername");
Route::post("/verifyProfile", "App\Http\Controllers\ActorController@verifProfile");
Route::post("/SendConfirm", "App\Http\Controllers\ActorController@SendMail");
Route::post("/UpdateProfile", "App\Http\Controllers\ActorController@UpdateProfile");
Route::post("/AddExp", "App\Http\Controllers\ActorController@AddExp");


Route::post("/Follow", function (Request $req) {
    try {
        $id_user = $req->input("id_user");
        $following = $req->input("following");
        $source = Actor::where("_id", "=", $id_user)->first();
        $dest = Actor::where("_id", "=", $following)->first();
        $notif = new NotificationController;

        if ($source->followingReq) {
            foreach ($source->followingReq as $id) {
                if ($id == $following) {
                    $dest->pull("followersReq", $id_user);
                    $source->pull("followingReq", $id);
                    $source->save();
                    $dest->save();
                    return "un requested";
                }
                # code...
            }
        }
        $source->push("followingReq", [$following]);
        $dest->push("followersReq", [$id_user]);
        $subject = "$source->nom wants to add you as friend";
        $notif->SendNotif("Friend Request", $id_user, $following, $subject);
        $source->save();
        $dest->save();
        return "requested";
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
});

Route::post("/Updatestatus", function (Request $req) {
    $id = $req->input("id");
    $log = $req->input("logged");
    $actor = Actor::where("_id", "=", $id)->first();
    $actor->logged = $log;
    $actor->save();
    return $log;
});

Route::post(
    "/uploadimg",
    function (Request $req) {
        if ($req->hasFile("image")) {
            $avatar = $req->file("image");
            $newname =  $avatar->getClientOriginalName();
            $avatar->move(base_path() . '/public/messages/', $newname);
            return "uploaded";
        }
        return 0;
    }
);

Route::post(
    "/ManageRequest",
    function (Request $req) {
        $query = $req->input("query");
        $notif = new NotificationController;
        $iduser = Session::get("id");
        $foll = $req->input("followerRequest");
        $actor = Actor::where("_id", "=", $iduser)->first();
        $requester = Actor::where("_id", "=", $foll)->first();
        $title = "";
        $from = "";
        $to = "";
        $subject = "";
        if ($query == "Accept") {
            $actor->push("Friends", [$foll]);
            $requester->push("Friends", [$iduser]);
            $actor->pull("followersReq", $foll);
            $requester->pull("followingReq", $iduser);
            $actor->save();
            $requester->save();
            $title = "Friend Request Accepted";
            $from = $iduser;
            $to = $foll;
            $subject = "$actor->nom has accepted your friend request";
            $notif->SendNotif($title, $from, $to, $subject);
            return "accepted";
        } else {
            $actor->pull("followersReq", $foll);
            $requester->pull("followingReq", $iduser);
            $actor->save();
            $requester->save();
            return "declined";
        }
    }
);
Route::post(
    "/UnFriend",
    function (Request $req) {
        $user = Session::get("id");
        $other = $req->input("other");
        $me = Actor::where("_id", "=", $user)->first();
        $oth = Actor::where("_id", "=", $other)->first();
        $me->pull("Friends", $other);
        $oth->pull("Friends", $user);
        $me->save();
        $oth->save();
        return "unfriended";
    }

);

Route::delete(
    "/DeletePost",
    function (Request $req) {
        $id =
            $req->input("id");
        Post::where("_id", $id)->delete();
        return "Post deleted";
    }
);

Route::post(
    "/GetNotif",
    function (Request $req) {
        $data = array();
        $sender = "";
        $notif = notification::where("to", Session::get("id"))->orderBy("created_at", "asc")->get();
        foreach ($notif as $item) {
            $sender = Actor::where("_id", $item->from)->first();
            # code...
            array_push($data, ["_id" => $item->_id, "from" => $sender->nom, "title" => $item->title, "subject" => $item->subject, "avatar" => $sender->avatar]);
        }

        return json_encode($data);
    }
);
Route::post("/AddPost", function (Request $req) {
    $id = $req->input("id");
    $content = $req->input("post");
    $ActorController = new ActorController;

    $post = new Post;
    $post->content = $content;
    $post->from = $id;
    $post->comments = [];
    if ($req->hasFile("file")) {
        $avatar = $req->file('file');
        $file = $avatar;
        $file_name = $file->getClientOriginalName();
        $newname = $ActorController->random() . $file_name;
        $file->move(base_path() . '/public/posts/', $newname);
        $post->image = $newname;
    }
    /*$post->likes=[
    "liked_by"=>[],
    "likes"=>0
    ];*/
    $post->created = [
        "date" => date("Y-m-d"),
        "time" => date("H:i"),
    ];
    $post->likes = 0;
    $post->save();

    return 1;
});

Route::post("/GetLikesNumber", function (Request $req) {
    $idPost = $req->input("id_post");
    $post = Post::where("_id", '=', $idPost)->first();
    if ($post->likes) {
        return $post->likes;
    } else {
        return 0;
    }
});
Route::post("/Like", function (Request $req) {
    try {

        $id = $req->input("id");
        $idPost = $req->input("id_post");
        $user = Actor::where("_id", '=', $id)->first();
        $post = Post::where("_id", '=', $idPost)->first();
        $notif = new NotificationController;
        $subject = "$user->nom have liked your post";

        $ok = false;
        if ($post->likes != 0) {
            foreach ($post["liked_by._id"] as $item) {
                if ($item == $id) {
                    $post->pull("liked_by._id", [$item]);
                    $post->decrement("likes");
                    $post->save();
                    $ok = true;
                    return "unlike";
                }
            }
            if ($ok == false) {
                $post->push("liked_by._id", $id);
                $post->increment("likes");
                $post->save();
                Session::push("liked_post", [$id]);
                $notif->SendNotif("New Like", $user->_id, $post->from, $subject);
                return "like";
            }
        } else {
            $post->likes = 1;
            $post->push("liked_by._id", $id);
            $notif->SendNotif("New Like", $user->_id, $post->from, $subject);
            $post->save();
            return "like";
        }

        //code...
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
});

Route::post("/deleteComment", function (Request $req) {
    try {
        $idPost = $req->input("id_post");
        $idComment = $req->input("id_comment");
        $posts = Post::where("_id", "=", $idPost)->first();
        foreach ($posts["comments"] as $k => $v) {
            if ($posts["comments"][$k]["_id"] == $idComment) {
                $posts->pull("comments", ["_id" => $idComment]);
                return 1;
            }

            # code...

        }
        return 0;
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
});
Route::post("/addComment", function (Request $req) {
    try {
        $id = $req->input("id");
        $idPost = $req->input("id_post");
        $comment = $req->input("comment");
        $date = date("Y-m-d");
        $time = date("H:i");
        $posts = Post::where("_id", "=", $idPost)->first();
        $user = Actor::where("_id", "=", $id)->first();
        $posts->push("comments", [
            "_id" => uniqid(),
            "from" => $id,
            "content" => $comment,
            "date" => $date,
            "time" => $time
        ]);
        $posts->save();
        return json_encode(["id" => $id, "from" => $user->nom, "avatar" => $user->avatar, "content" => $comment, "date" => $date, "time" => $time]);
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
});

Route::post("/Session/{id}", function ($id) {
    if (Session::has("LAST_ACTIVITY") && (time() - Session::get("LAST_ACTIVITY") > 800)) {
        Session::flush();
        $actor = Actor::where("_id", '=', $id)->first();
        $actor->logged = 0;
        $actor->save();
        return 1;
    }
});
Route::post("/verifLogin", "App\Http\Controllers\ActorController@login");
Route::get("/GetOnline", function (Request $req) {
    $id = Session::get("id");
    $actor = Actor::where("_id", $id)->first();
    if ($actor->Friends) {
        foreach ($actor->Friends as $item) {
            $friend = Actor::where('_id', $item)->first();
            if ($friend->logged == 1) {
                return json_encode(["nom" => $friend->nom, "avatar" => $friend->avatar, "id" => $friend->_id]);
            }

            # code...
        }
        return 0;
    } else {
        return 0;
    }
});

Route::post("/NewPass", "App\Http\Controllers\ActorController@UpdatePass");
Route::post("/getUserByID", function (Request $req) {
    $id = $req->input("iduser");
    $actor = Actor::where("_id", "=", $id)->first();
    $chat = Chat::where("between.user2", "=", $id)->orWhere("between.user1", "=", $id)->orderBy("id", "asc")->get();
    $msg = "";
    $time = "";
    $from = "";
    foreach ($chat as $item) {
        if ($item->messages) {
            foreach ($item->messages as $k => $v) {
                $msg = $item->messages[$k]["content"];
                $time = $item->messages[$k]["time"];
                $from = $item->messages[$k]["from"];
            }
        }
        # code...
    }
    return json_encode([
        $actor,
        "lastmsg" => $msg, "time" => $time, "from" => $from
    ]);
});
