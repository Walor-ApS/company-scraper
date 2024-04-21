<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyEmployee extends Model
{
    use HasFactory;
    protected $fillable = ['year', 'month', 'employees', 'company_id', 'week', 'employees_range'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
