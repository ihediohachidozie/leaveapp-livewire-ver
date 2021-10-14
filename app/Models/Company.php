<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    /**
     * Get the company that the user belongs to.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}