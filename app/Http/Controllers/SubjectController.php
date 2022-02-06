<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    //
    public function get_lessons($id)
    {
        return response()->json(['data' => Subject::find($id)->Lesson()->get()]);
    }
    public function post(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',


        ]);
        return response()->json(['data' => Subject::create($request->all())]);
    }
    public function get()
    {

        $temp = [];
        $allSubjects = Subject::all();
        foreach ($allSubjects as $item) {
            # code...
            $item["lessons"] = $item->Lesson()->get();
            array_push($temp, $item);
        }
        return response()->json(['data' => $temp]);
    }
    public function delete($id, Request $request)

    {
        $subject = Subject::find($id);
        if ($subject)
            return response()->json(['data' => $subject->delete()]);
        return response()->json(['message' => 'subject dosen\'t exist'], 404);
    }
}
