<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCorporation extends Model
{
    use HasFactory;

    protected $fillable = ['country', 'founded_at', 'name', 'description', 'link'];
}
