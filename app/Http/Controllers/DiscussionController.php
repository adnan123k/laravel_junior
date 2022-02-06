<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;

use App\Models\User;
use App\Models\Video;



class DiscussionController extends Controller
{
    //


    public function get_discussion(Request $request)
    {

        $temp = [];
        $discussionArray = $request->user()->Discussion()->get();;
        foreach ($discussionArray as  $value) {
            $discussionLikes = $value->Discussion_likes()->get();
            $value["username"] = User::find($value["user_id"])->username;
            $value["likes"] = count($discussionLikes);
            $value["liked"] = count($value->Discussion_likes()->where('user_id', $request->user()->id)->get()) == 0 ? false : true;
            array_push($temp, $value);
        }


        return response()->json(["data" => $temp]);
    }
    public function get_video_discussion($id, Request $request)
    {
        $video = Video::find($id);
        if ($video) {
            $temp = [];
            $discussionArray = $video->Discussion()->get();
            foreach ($discussionArray as  $value) {
                $discussionLikes = $value->Discussion_likes()->get();
                $value["username"] = User::find($value["user_id"])->username;
                $value["likes"] = count($discussionLikes);
                $value["liked"] = count($value->Discussion_likes()->where('user_id', $request->user()->id)->get()) == 0 ? false : true;
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
        return response()->json(['message' => 'video not found'], 404);
    }
    public function post_discussion(Request $request)
    {
        $request->validate([
            'body' => 'bail|required',

            'video_id' => 'bail|required|integer'
        ]);
        $data = $request->all();

        $isCreated = $request->user()->Discussion()->create($data);
        if ($isCreated) {
            $value = Discussion::find($isCreated["id"]);



            $discussionLikes = $value->Discussion_likes()->get();
            $value["username"] = User::find($value["user_id"])->username;
            $value["likes"] = count($discussionLikes);
            $value["liked"] = count($value->Discussion_likes()->where('user_id', $request->user()->id)->get()) == 0 ? false : true;


            return response()->json(['data' => $value]);
        }
        return response()->json(['message' => "something went wrong"], 500);
    }

    public function delete_discussion($id, Request $request)
    {
        if (Discussion::find($id) && Discussion::find($id)->get()[0]->user_id == $request->user()->id ) {
            return response()->json(['data' => $request->user()->Discussion()->where('id', $id)->delete()]);
        }
elseif(Discussion::find($id) &&  $request->user()->role == "teacher"){
 
    return response()->json(['data' =>Discussion::find( $id)->delete()]);
    
}
        return response()->json(['message' =>  'discussion not found or you\'re not authorized '], 401);
    }
}
