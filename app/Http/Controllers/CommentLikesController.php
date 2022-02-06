<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class CommentLikesController extends Controller
{
    //
    public function toggle_likes($id, Request $request)
    {
        if (count($request->user()->Comment_likes()->where('comment_id', $id)->get()) == 0) {
            $request->user()->Comment_likes()->create(['comment_id' => $id]);
        } else {
            $request->user()->Comment_likes()->where('comment_id', $id)->first()->delete();
        }
        return response()->json(["data" => "done"]);
    }
}
