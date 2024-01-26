<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Timeline;
use App\Models\TimelineItem;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $timeline = Timeline::orderBy('created_at','ASC')->get();
        $labels = Label::all();
        return view('main')
            ->with([
                'timelines'=>$timeline,
                'labels'=>$labels
            ]);
    }

    public function store(Request $request)
    {
        $datetime = $request->date.' '.$request->time;
        $timeline = new TimelineItem();
        $timeline->title = $request->title;
        $timeline->date = $request->date;
        $timeline->time = $request->time;
        $timeline->date_time = $datetime;
        $timeline->comment = $request->comment;
        if ($request->file){
            $timeline->attachment = $this->uploadSingleFile($request->file,'attachment','at');
        }
        if ($timeline->save()){
            toast('Timeline add successfully','success');
        }else{
            toast('Something wrong','error');
        }
        return redirect()->back();
    }
    function uploadSingleFile($request = null, $path = '', $prefix = ''): string
    {
        $file = $request;
        $fileName = $prefix.'_'.time().rand(0000,9999).'.'.$file->getClientOriginalExtension();
        $destination = $path;
        $file->storeAs($destination,$fileName,'public');
        return $destination . '/'.$fileName;
    }

    public function delete($id)
    {
        $exist = TimelineItem::where('id',$id)->first();
        if (empty($exist)){
            toast('Timeline not found','error');
            return redirect()->back();
        }
        $exist->delete();
        toast('Timeline delete successful','success');
        return redirect()->back();
    }

    public function deleteAttachment($id)
    {
        $exist = TimelineItem::where('id',$id)->first();
        if (empty($exist)){
            toast('Timeline not found','error');
            return redirect()->back();
        }
        $exist->attachment = '';
        $exist->save();
        toast('Attachment delete successful','success');
        return redirect()->back();
    }
    public function editData(Request $request)
    {
        $exist = Timeline::where('id',$request->id)->first();
        if (empty($exist)){
            return response()->json([
                'status'=>false,
                'data'=>null
            ]);
        }
        return response()->json([
            'status'=>true,
            'data'=>'<div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="'.route('update-data').'" method="POST" enctype="multipart/form-data" id="add-form">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="id" value="'.$exist->id.'">
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Edit timeline </h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="mb-3">
                            <label class="col-form-label" for="recipient-name">Title:</label>
                            <input class="form-control" name="title"  type="text" value="'.$exist->title.'" required/>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-lg-6">
                                <label class="col-form-label" for="recipient-name">Date:</label>
                                <input class="form-control" name="date"  type="date" value="'.$exist->date.'" required/>
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label class="col-form-label" for="recipient-name">Time:</label>
                                <input class="form-control" name="time"  value="'.$exist->time.'" type="time" required/>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label" for="recipient-name">Attachment:</label>
                            <input class="form-control" name="file" id="file1" type="file"/>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="recipient-name">Comment:</label>
                            <textarea name="comment" class="form-control">'.$exist->comment.'</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>'
        ]);
    }

    public function update(Request $request)
    {
        $timeline = TimelineItem::where('id',$request->id)->first();
        if (empty($timeline)){
            toast('Timeline not found','error');
            return redirect()->back();
        }
        $datetime = $request->date.' '.$request->time;
        $timeline->title = $request->title;
        $timeline->date = $request->date;
        $timeline->time = $request->time;
        $timeline->date_time = $datetime;
        $timeline->comment = $request->comment;
        if ($request->file){
            $timeline->attachment = $this->uploadSingleFile($request->file,'attachment','at');
        }
        if ($timeline->save()){
            toast('Timeline update successfully','success');
        }else{
            toast('Something wrong','error');
        }
        return redirect()->back();
    }
}
