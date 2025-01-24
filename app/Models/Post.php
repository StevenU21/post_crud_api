<?php

namespace App\Models;

use App\Traits\FindModelOrFail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, FindModelOrFail;

    protected $fillable = [
        'title',
        'content'
    ];
}
