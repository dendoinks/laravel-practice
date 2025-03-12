<?php

namespace Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Employee\Database\Factories\EmployeeFactory;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id', 'name', 'email', 'position'];

    // protected static function newFactory(): EmployeeFactory
    // {
    //     // return EmployeeFactory::new();
    // }

    public function company()
{
    return $this->belongsTo(\Modules\Company\Models\Company::class);
}

protected static function newFactory()
{
    return EmployeeFactory::new();
}

}
