<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionAttempController extends Controller
{
    //
    public function post(Request $request)
    {

        $request->validate(["questions" => "bail|required|array"]);
        $data = $request->all();
        foreach ($data["questions"] as $item) {
            # code...

            $item["passed"] = (bool)$item["passed"];

            $request->User()->Question_attemp()->create($item);
        }

        return response()->json(["data" => "done"]);
    }
}
