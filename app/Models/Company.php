<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;    

    protected $fillable = ['municipality_id', 'country', 'cvr', 'founded_at', 'ended_at', 'name', 'address', 'zip_code', 'city', 'company_type', 'industry', 'phone', 'email', 'advertising_protected', 'employees', 'link', 'noticed_at', 'employees_range'];

    public function employeeHistory()
    {
        return $this->hasMany(CompanyEmployee::class)->latest();
    }
}
