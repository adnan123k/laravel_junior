<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use App\Models\Lesson;
use Throwable;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function post($id, Request $request)
    {
        $request->validate(['subject_id' => 'bail|required|integer', 'questions' => 'bail|required|array|min:10']);
        $data = $request->all();


        $level = Level::where('subject_id', $data['subject_id'])->where('lesson_id',$id)->first();
        try {
            if ($level) {
                foreach ($data["questions"] as $item) {
                    # code...
                   $item['lesson_id']=$id;
                    $level->Question()->create($item);
                }
                return response()->json(["data" => "done"]);
            } else {
                $subject = Subject::find($data['subject_id']);
                if ($subject) {
                    $temp = "level ";
                    $index = 1;
                    foreach ($subject->Lesson()->get() as $value) {
                        # code...
                        if ($value->id == $id) {
                            $s = $subject->Level()->create(["title" => $temp . $index,"lesson_id"=>$id]);
                            foreach ($data["questions"] as $item) {
                                # code...
$item["lesson_id"]=$id;
                                $s->Question()->create($item);
                            }
                            return response()->json(["data" =>   "done"]);
                        }
                        $index++;
                    }
                }
            }
        } catch (Throwable $e) {
            return response()->json(["message" =>   $e->getMessage()], 500);
        }
        return response()->json(["message" => "subject not found"], 404);
    }

    public function get($id,Request $request){
       $subject= Subject::find($id);
       if($subject){
        $temp=[];
           foreach ($subject->Lesson()->get() as $lesson) {
               # code...
           
         $questions=  $lesson->Question()->get();
         
         foreach ( $questions as $i ) {
             # code...
             
             $i["attemp"]=$i->User_attemp()->where('passed',true)->count()/ ($i->User_attemp()->count()==0?1:$i->User_attemp()->count());
             $t=0;
             foreach ($i->User_attemp()->get() as $j){
          
               $t+=  $j->User()->get()[0]->points;
             }
             $i["points"]=$t/($i->User_attemp()->count()==0?1:$i->User_attemp()->count());
           array_push( $temp,$i);
         }}
         return response()->json(["data"=>$temp]);
       }
    }
}
