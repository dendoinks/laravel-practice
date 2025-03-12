<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Company\Database\Factories\CompanyFactory;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'address'];

    // protected static function newFactory(): CompanyFactory
    // {
    //     // return CompanyFactory::new();
    // }

    public function employees()
    {
        return $this->hasMany(\Modules\Employee\Models\Employee::class);
    }

}
