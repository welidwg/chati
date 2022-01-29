<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Database\QueryException;
use Session;
use Illuminate\Support\Facades\Input;

class dataB extends Controller
{
    //
    public function addUser(Request $req)
    {
        try {
        $username=$req->input("username");
        $name=$req->input("name");
        $date=date("Y-m-d");
        $email=$req->input("email");
        $password=$req->input("password");
        if($req->hasFile("avatar")){
        $avatar=$req->file('avatar');
        $file=$avatar;
        $file_name = $file->getClientOriginalName();
         $newname = $file_name;
         $file->move(base_path().'/public/uploads/', $newname);
        }else{
            $file_name=NULL;
        }
        $hash= bcrypt($password);    
         DB::insert('insert into users (username,name,email,password,avatar,joinDate,logged) values(?,?,?,?,?,?,?)',[$username,$name,$email,$hash,$file_name,$date,0]);
         return redirect(url('/login'));

        } catch (QueryException $th) {
            return redirect(url('/register?'.$th->getMessage()));
            
        }
          
    }
    public function login(Request $req)
    { try {
           $email=$req->input("email");
        $password=$req->input("password");
         $user = User::where("email",$email)->first();
         if($user){
             if(Hash::check($password, $user->password)){
                 Session::put("login",true);
                 Session::put("username",$user->username);
                 Session::put("email",$user->email);
                 Session::put("avatar",$user->avatar);
                 Session::put("nom",$user->name);
                 DB::update('update users set logged = 1 where email = ?', [$email]);

                 


                 return 1;    
               
             }else{
                return 10;
             }
             
         }else{
                return 0;

         }

        //code...
      
    } catch (QueryException $th) {
            return redirect(url('/login?'.$th->getMessage()));
    }
       

        
    }
    public function GetAllUser()
    {

        $result = User::All();
        # code...
        return $result;
    }

}
