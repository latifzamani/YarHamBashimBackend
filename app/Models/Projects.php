<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $fillable=['title','subtitle','paragraph1','paragraph2','paragraph3','paragraph4','photo1','photo2','date'];

    public function images()
    {
       return $this->hasMany(ProjectImages::class,'projectId','id');
    }
}
