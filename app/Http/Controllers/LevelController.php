<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Question;
use App\Models\Level;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //
    public function get($id, Request $request)
    {
        $subject = Subject::find($id);

        if ($subject) {
            
            $temp = [];
            $subjectLevels = $subject->Level()->get();

            foreach ($subjectLevels as $item) {
                # code...
                $tmp = [];
                $items = $item->Question()->get();
      
                $c = count($items);
        
                while (count($tmp) != 10) {
                  
                    $i = rand($items[0]["id"], $items[sizeof($items)-1]["id"]);

                    $q = Question::find($i);
if($q["level_id"]==$item["id"]){
                    $isFound = false;
          
                    foreach ($tmp as $v) {
             
                        if ($v["id"] == $i) $isFound = true;
                    }
                    if (!$isFound){
                        array_push($tmp, $q);
                   
                    }}
                }
                $item["passed"] = count($item->User_level()->where('user_id', $request->user()->id)->get()) == 0 ? false : true;
                $item["questions"] = $tmp;
                array_push($temp, $item);
              
            }
            return response()->json(["data" => $temp]);
        }
        return response()->json(["message" => "subject not found"], 404);
    }
}
