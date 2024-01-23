<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriggerLead extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'company_id', 'country', 'employees', 'month', 'year'];
}
