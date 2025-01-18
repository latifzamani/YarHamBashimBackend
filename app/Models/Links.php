<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;
    protected $fillable=['facebook','instagram','telegram','x','linkedin','youtube','whatsapp','address','phone','email'];
}
