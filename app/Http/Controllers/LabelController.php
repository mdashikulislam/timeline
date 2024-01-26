<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function store(Request $request)
    {

        $label = new Label();
        $label->name = $request->name;
        $label->color = $request->color;
        if ($label->save()){
            toast('Label add successfully','success');
        }else{
            toast('Label not add','error');
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $label = Label::where('id',$request->id)->first();
        if (empty($label)){
            toast('Label not found','error');
            return redirect()->back();
        }
        $label->name = $request->title;
        $label->color = $request->color;
        $label->save();
        toast('Label update successfully','success');
        return redirect()->back();
    }

    public function delete($id)
    {
        $label = Label::where('id',$id)->first();
        if (empty($label)){
            toast('Label not found','error');
            return redirect()->back();
        }
        $label->delete();
        toast('Label delete successfully','success');
        return redirect()->back();
    }
}
