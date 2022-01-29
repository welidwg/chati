<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Http\Input;
use Session;
use App\Http\Controllers\PhpmailerController;

class ActorController extends Controller
{

    function random($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function SendMail(Request $req)
    {
        $email = $req->input("email");
        $actor = Actor::where("email", "=", $email)->first();
        if ($actor) {
            $code = $this->random();

            $mail = new PhpmailerController;
            $subject = "Password Recovery";
            $body = "Your code is " . $code;
            $mail->sendEmail($email, $subject, $body);
            return $code;
        } else {
            return 0;
        }
    }
    //
    public function UpdatePass(Request $req)
    {
        try {
            $newPass = bcrypt($req->input("password"));
            $email = $req->input("email");
            $actor = Actor::where("email", "=", $email)->first();
            $actor->password = $newPass;
            $actor->save();
            return 1;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function verifProfile(Request $req)
    {
        $data = $req->input("data");
        $col = $req->input("col");
        $id = $req->input("id");
        $actor = Actor::where("_id", "=", $id)->first();
        if ($actor->$col == $data) {
            return 1;
        } else {
            $user = Actor::where($col, "=", $data)->first();
            if ($user) {
                return 0;
            } else {
                return 10;
            }
        }
    }


    public function AddExp(Request $req)
    {
        try {
            $name = $req->input("expName");
            $from = $req->input("expFrom");
            $to = $req->input("expTo");
            $detail = $req->input("detail");
            $id = $req->input("id");
            $actor = Actor::where("_id", "=", $id)->first();
            if (isset($req->current)) {
                $current = 1;
                $to = null;
            } else {
                $current = 0;
            }
            $ok = false;
            if ($actor->experience) {
                foreach ($actor->experience as $item) {
                    # code..
                    if ($item["current"] == 1) {
                        $ok = true;
                        break;
                    }
                }
            }


            $data = [

                "nomExp" => $name,
                "From" => $from,
                "To" => $to,
                "details" => $detail,
                "current" => $current


            ];
            if ($ok && $current==1) {
                return 0;
            } else {
                $actor->push("experience", $data);

                $actor->save();
                return 1;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        # code...
    }
    public function UpdateProfile(Request $req)
    {
        try {
            $id = $req->input("id");
            $actor = Actor::where("_id", "=", $id)->first();
            $fullname = $req->input("name");
            $username = $req->input("username");
            $tel = $req->input("tel");
            $address = $req->input("address");
            $email = $req->input("email");
            $about = $req->input("about");
            if ($req->hasFile("avatar")) {
                $avatar = $req->file('avatar');
                $file = $avatar;
                $file_name = $file->getClientOriginalName();
                $newname = $this->random() . $file_name;
                $file->move(base_path() . '/public/uploads/', $newname);
            } else {
                $newname = $actor->avatar;
            }
            if ($req->input('password') != "") {
                $newPass = bcrypt($req->input('password'));
            } else {
                $newPass = $actor->password;
            }
            $actor->nom = $fullname;
            $actor->username = $username;
            $actor->tel = $tel;
            $actor->email = $email;
            $actor->avatar = $newname;
            $actor->password = $newPass;
            $actor->address = $address;
            $actor->about = $about;
            $actor->save();
            Session::put("username", $username);
            Session::put("email", $email);
            Session::put("avatar", $newname);
            Session::put("nom", $fullname);
            Session::put("tel", $tel);
            Session::put("address", $address);
            Session::put("about", $about);
            return 1;
        } catch (\Throwable $th) {
            return $th->getMessage();
            //throw $th;
        }
        # code...
    }
    function verifUsername(Request $req)
    {
        $data = $req->input("data");
        $col = $req->input("col");
        $actor = Actor::where($col, "=", $data)->first();

        if ($actor) {
            return 1;
        } else {
            return 0;
        }
    }

    function login(Request $req)
    {
        $email = $req->input("email");
        $password = $req->input("password");

        $user = Actor::where('email', '=', $email)->first();
        if ($user) {
            if (\Hash::check($password, $user->password)) {

                Session::put("login", true);
                Session::put("username", $user->username);
                Session::put("email", $user->email);
                Session::put("avatar", $user->avatar);
                Session::put("nom", $user->nom);
                Session::put("tel", $user->tel);
                Session::put("id", $user->_id);
                Session::put("address", $user->address);
                Session::put("about", $user->about);
                $user->logged = 1;
                $user->save();
                return 1;
            } else {
                return 10;
            }
        } else {
            return 0;
        }
    }
    function addActor(Request $req)
    {
        try {
            $actor = new Actor;
            $actor->username = $req->input("username");
            $actor->nom = $req->input("name");
            $actor->date = date("Y-m-d");
            $actor->email = $req->input("email");
            $actor->password = bcrypt($req->input("password"));
            $actor->followers = [];
            $actor->following = [];
            if ($req->hasFile("avatar")) {
                $avatar = $req->file('avatar');
                $file = $avatar;
                $file_name = $file->getClientOriginalName();
                $newname = $file_name;
                $file->move(base_path() . '/public/uploads/', $newname);
                $actor->avatar = $newname;
            } else {
                $actor->avatar = "avatar.png";
            }
            $actor->logged = 0;
            $actor->save();
            return redirect(url('/login'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
