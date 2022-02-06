<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //

    public  function post(Request $request)
    {

        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'video' => 'bail|required',
            'lesson_id' => 'bail|required|integer'
        ]);
        $file = $request->file('video');
        $filename = time() . $file->getClientOriginalName().".mp4";
        $path = public_path() . '/uploads/';
        $file->move($path, $filename);
        $data = $request->all();
        $data['url'] = "http://10.0.2.2:8000" . '/uploads/' . $filename;

        $data['full_name'] = $request->user()->full_name;
        return response()->json(["data" => $request->user()->Video()->create($data)]);
    }
    public  function put($id, Request $request)
    {

        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'video' => 'bail|required',
            'lesson_id' => 'bail|required|integer'
        ]);
   
        if (Video::find($id) && Video::find($id)->get()[0]->teacher_id == $request->user()->get()[0]->id) {
            $video =  $request->user()->Video()->where('id', $id)->get();
            if ($video) {
                unlink(explode("http://127.0.0.1:8000/", $video[0]->url)[1]);
                $file = $request->file('video');
                $filename = time() . $file->getClientOriginalName();
                $path = public_path() . '/uploads/';
                $file->move($path, $filename);
                $data = $request->all();
                $data['url'] = "http://127.0.0.1:8000" . '/uploads/' . $filename;
                $data['full_name'] = $request->user()->full_name;
                $operations = $video[0]->update($data);
                return response()->json(["data" => $operations]);
            }

            return response()->json(["message" => "video not found"], 404);
        }
        return response()->json(["message" => "video not found or not authorized"], 401);
    }
    public  function delete($id, Request $request)
    {
        if (Video::find($id) && Video::find($id)->get()[0]->teacher_id == $request->user()->get()[0]->id) {
            $video =  $request->user()->Video()->where('id', $id)->get();

            if ($video) {
                unlink(explode("http://127.0.0.1:8000/", $video[0]->url)[1]);
                $operations = $video[0]->delete();
                return response()->json(["data" => $operations]);
            }
            return response()->json(["message" => "video not found"], 404);
        }
        return response()->json(["message" => "video not found or not authorized"], 401);
    }
    public  function get_videos($id)
    {

        $lesson =  Lesson::find($id);
        if ($lesson) {
            $video = $lesson->Video()->get();
            return response()->json(["data" => $video]);
        }
        return response()->json(["message" => "lesson not found"], 404);
    }
}
