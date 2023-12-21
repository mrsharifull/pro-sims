<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends BaseModel
{
    use HasFactory;

    public function class_(){
        return $this->belongsTo(Class_::class, 'class_id');
    }
}




