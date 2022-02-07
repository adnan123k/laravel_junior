<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    //
    public function sign_up(Request $request)
    {

        $request->validate([
            'username' => 'bail|required|unique:users,username',
            'password' => array('bail', 'required'),
            "full_name" => "bail|required",
            "mother_name" => "bail|required",
            "father_name" => "bail|required",

        ]);
        $data = $request->all();
        $data["points"] = 0;
        $data["role"] = "student";
        
        $currentUser =    User::create($data);
        $token = $currentUser->createToken("myapp")->plainTextToken;
       $currentUser->remember_token=$token;
        $currentUser->update();
        
        return response()->json(["data" => $currentUser, "token" => $token]);
    }
    public function sign_in(Request $request)
    {


        $request->validate([
            'username' => 'bail|required',
            'password' => 'bail|required'
        ]);

        $data = $request->all();


        $currentUser = User::where('username',  $data['username'])->where( 'password',  $data["password"]
          )->first();

        if ($currentUser) {
         
            if($currentUser->remember_token!=""){
                return response()->json(["message" => "please log out of any other device first"]);
   
            }
            if ($currentUser->blocked)
                return response()->json(["message" => "the user is blocked"], 401);

            $token = $currentUser->createToken("myapp")->plainTextToken;
            $currentUser->remember_token=$token;
            $currentUser->update();
            return response()->json(["data" => $currentUser, "token" => $token]);
        }
        return response()->json(["message" => "check your username and password then try again"]);
    }
    public function sign_out(Request $request)
    {$request->user()->remember_token="";
        $request->user()->update();
        $request->user()->currentAccessToken()->delete();
        return response()->json(["data" => "succesfully logged out"]);
    }

    public function top_10_students()
    {
        return response()->json(["data" => User::orderBy("points", "desc")->where('role', 'student')->take(10)->get()]);
    }
    public function point_update(Request $request)
    {
        $request->validate([
            'points' => 'bail|required|integer',

        ]);
        $user = $request->user();
        $user->points += $request->all()["points"];
        return response()->json(["data" => $user->save()]);
    }
    public function add_teacher(Request $request)
    {
        $request->validate([
            'username' => 'bail|required|unique:users,username',
            'password' => array('bail', 'required'),
            "full_name" => "bail|required",
            "mother_name" => "bail|required",
            "father_name" => "bail|required",

        ]);
        $data = $request->all();
        $data["points"] = 0;
        $data["role"] = "teacher";

        $currentUser =    User::create($data);
        return response()->json(["data" => $currentUser]);
    }
    public function get_teacher()
    {
        return response()->json(["data" => User::where('role', 'teacher')->get()]);
    }
    public function put_teacher($id, Request $request)
    {
        $request->validate([
            
            'password' => array('bail', 'required'),
            "full_name" => "bail|required",
            "mother_name" => "bail|required",
            "father_name" => "bail|required",

        ]);
        $data = $request->all();
        $data["points"] = 0;
        $data["role"] = "teacher";

        $teacher =    User::find($id);
        if ($teacher && $teacher->role == "teacher") {

            $operations = $teacher->update($data);
            return response()->json(["data" => $operations]);
        }
        return response()->json(["message" => "teacher not found"], 404);
    }
    public function delete_teacher($id, Request $request)
    {
        $teacher =    User::find($id);
        if ($teacher && $teacher->role == "teacher") {

            $operations = $teacher->delete();
            return response()->json(["data" => $operations]);
        }
        return response()->json(["message" => "teacher not found"], 404);
    }

    public function block_user($id, Request $request)
    {
        $user =    User::find($id);
        if ($user) {
            $temp = [];
            foreach ($user->tokens as  $value) {
                # code...
                $value->delete();
            }

            $user->blocked = true;
            return response()->json(["data" => $user->save()]);
        }
        return response()->json(["message" => "user not found"], 404);
    }
}
