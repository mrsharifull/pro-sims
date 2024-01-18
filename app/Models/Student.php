<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function class()
    {
        return $this->belongsTo(Class_::class, 'class_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function ad()
    {
        return $this->belongsTo(AcademicDivision::class, 'ad_id');
    }
    public function bg()
    {
        return $this->belongsTo(Bloodgroups::class, 'bg_id');
    }

}
