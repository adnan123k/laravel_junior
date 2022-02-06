<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscussionLikesController extends Controller
{
    //
    public function toggle_likes($id, Request $request)
    {
        if (count($request->user()->Discussion_likes()->where('discussion_id', $id)->get()) == 0) {
            $request->user()->Discussion_likes()->create(['discussion_id' => $id]);
        } else {
            $request->user()->Discussion_likes()->where('discussion_id', $id)->first()->delete();
        }
        return response()->json(["data" => "done"]);
    }
}
