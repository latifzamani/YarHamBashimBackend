<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImages extends Model
{
    use HasFactory;
    protected $fillable=['projectId','project','photo'];

    public function project()
    {
       return  $this->belongsTo(Projects::class,'projectId','id');
    }
}
