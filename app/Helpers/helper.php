<?php
function getTimelineDropdown($selected = 0): string
{
    $options = \App\Models\Timeline::get();
    $html = '<option value="">Select Timeline</option>';
    if (!empty($options)){
        foreach ($options as $item){
            $html .='<option value="'.$item->id.'"';
            if ($item->id == $selected){
                $html .=' selected ';
            }
            $html .=' >'.$item->name.'</option>';
        }
    }
    return $html;
}
function getLabelDropdown($selected = 0): string
{
    $options = \App\Models\Label::get();
    $html = '<option value="">Select Label</option>';
    if (!empty($options)){
        foreach ($options as $item){
            $html .='<option value="'.$item->id.'"';
            if ($item->id == $selected){
                $html .=' selected ';
            }
            $html .=' >'.$item->name.'</option>';
        }
    }
    return $html;
}
function getStatusDropdown($selected = 0): string
{
    $options = ['Inactive','Active'];
    $html = '<option value="">Select Status</option>';
    if (!empty($options)){
        foreach ($options as $item){
            $html .='<option value="'.$item.'"';
            if ($item == $selected){
                $html .=' selected ';
            }
            $html .=' >'.$item.'</option>';
        }
    }
    return $html;
}
