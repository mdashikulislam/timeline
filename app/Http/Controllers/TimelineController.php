<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function store(Request $request)
    {

        $timeline = new Timeline();
        $timeline->name = $request->title;
        $timeline->first_name = $request->first_name;
        $timeline->last_name = $request->last_name;
        $timeline->email = $request->email;
        $timeline->is_edit = $request->is_edit;
        if ($timeline->save()){
            $copyLink = route('shared.timeline',['id'=>(base64_encode($timeline->id))]);
            $email = $request->email;
            \Mail::to($email)->send(new SendMail($copyLink));
            toast('Timeline add successfully','success');
        }else{
            toast('Timeline not add','error');
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $timeline = Timeline::where('id',$request->id)->first();
        if (empty($timeline)){
            toast('Timeline not found','error');
            return redirect()->back();
        }
        $timeline->name = $request->title;
        $timeline->first_name = $request->first_name;
        $timeline->last_name = $request->last_name;
        $timeline->email = $request->email;
        $timeline->is_edit = $request->is_edit;
        $timeline->save();
        toast('Timeline update successfully','success');
        return redirect()->back();
    }

    public function delete($id)
    {
        $timeline = Timeline::where('id',$id)->first();
        if (empty($timeline)){
            toast('Timeline not found','error');
            return redirect()->back();
        }
        $timeline->delete();
        toast('Timeline delete successfully','success');
        return redirect()->back();
    }

    public function timeline($id)
    {
        $id = base64_decode($id);
        $timeline = Timeline::with(['items'=>function($q){
            $q->orderByDesc('date_time');
        }])->where('id',$id)->first();
        if (empty($timeline)){
            abort(404);
        }
        return view('timeline')->with([
           'timeline'=>$timeline
        ]);
    }
}
