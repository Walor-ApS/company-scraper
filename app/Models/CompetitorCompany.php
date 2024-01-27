<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitorCompany extends Model
{
    use HasFactory;

    protected $fillable = ["name", "page_url", "website", "state", "competitor"];
}
