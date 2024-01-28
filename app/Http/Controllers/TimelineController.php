<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function store(Request $request)
    {
        $timeline = new Timeline();
        $timeline->name = $request->title;
        if ($timeline->save()){
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
        $timeline = Timeline::where('id',$id)->first();
        if (empty($timeline)){
            abort(404);
        }
        return view('timeline')->with([
           'timeline'=>$timeline
        ]);
    }
}
