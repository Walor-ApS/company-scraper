<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'municipality_id', 'country', 'cvr', 'founded_at', 'ended_at', 'name', 'address', 'zip_code', 'city', 'company_type', 'industry', 'phone', 'email', 'advertising_protected', 'employees', 'website', 'noticed_at', 'employees_range', 'state'];

    public function employeeHistory()
    {
        return $this->hasMany(CompanyEmployee::class)->latest();
    }

    public function employees()
    {
        $company_employees  = $this->employeeHistory()->get()->first();
        return $company_employees->employees ?? $company_employees->employees_range;
    }
}
