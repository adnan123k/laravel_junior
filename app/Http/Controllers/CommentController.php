<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function get_discussion_comment($id, Request $request)
    {
        $discussion = Discussion::find($id);
        if ($discussion) {
            $temp = [];
            $commentArray = $discussion->Comment()->get();
            foreach ($commentArray as  $value) {
                $commentLikes = $value->Comment_likes()->get();
                $value["username"] = User::find($value["user_id"])->username;
                $value["likes"] = count($commentLikes);
                $value["liked"] = count($value->Comment_likes()->where('user_id', $request->user()->id)->get()) == 0 ? false : true;
                array_push($temp, $value);
            }

            usort($temp, function ($a, $b) {
                $key = 'likes';
                if ($a[$key] < $b[$key]) {
                    return 1;
                } else if ($a[$key] > $b[$key]) {
                    return -1;
                }
                return 0;
            });
            return response()->json(['data' => $temp]);
        }
        return response()->json(['message' => 'Discussion not found'], 404);
    }
    public function post_comment(Request $request)
    {
        $request->validate([
            'body' => 'bail|required',

            'discussion_id' => 'bail|required|integer'
        ]);

        $isCreated = $request->user()->Comment()->create($request->all());
        if ($isCreated) {
            $value = Comment::find($isCreated["id"]);

            $commentLikes = $value->Comment_likes()->get();
            $value["username"] = User::find($value["user_id"])->username;
            $value["likes"] = count($commentLikes);
            $value["liked"] = count($value->Comment_likes()->where('user_id', $request->user()->id)->get()) == 0 ? false : true;


            return response()->json(['data' => $value]);
        }
        return response()->json(['message' => "something went wrong"], 500);
    }

    public function delete_comment($id, Request $request)
    {

        if (Comment::find($id) && (Comment::find($id)->get()[0]->user_id == $request->user()->id || $request->user()->role == "teacher")) {

            return response()->json(['data' => $request->user()->Comment()->where('id', $id)->delete()]);
        }

        return response()->json(['message' =>  'comment not found or you\'re not authorized '], 401);
    }
}
