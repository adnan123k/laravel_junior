<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    //
    public function post($id, Request $request)
    {
        $request->validate(["subject_id" => "bail|required|integer"]);
        $data = $request->all();
        $data["level_id"] = $id;
        return response()->json(["data" => $request->user()->User_level()->create($data)]);
    }
}
