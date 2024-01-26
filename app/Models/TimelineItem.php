<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineItem extends Model
{
    use SoftDeletes;
    protected $table = 'timeline_items';

    public function labels()
    {
        return $this->hasOne(Label::class,'id','label_id');
    }
}
