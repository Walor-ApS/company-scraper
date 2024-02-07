<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCorporation extends Model
{
    use HasFactory;

    protected $table = 'bcorporations';
    protected $fillable = ['country', 'founded_at', 'name', 'employees', 'website', 'state'];
}
