<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;


class LessonController extends Controller
{
    //
    public function post(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'subject_id' => 'bail|required'

        ]);
        return response()->json(['data' => Lesson::create($request->all())]);
    }

    public function delete($id, Request $request)

    {
        $lesson = Lesson::find($id);
        if ($lesson)
            return response()->json(['data' => $lesson->delete()]);
        return response()->json(['message' => 'lesson dosen\'t exist'], 404);
    }
}
