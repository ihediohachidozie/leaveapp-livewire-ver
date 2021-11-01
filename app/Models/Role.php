<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const IS_ADMIN = 1;
    public const IS_SUPERUSER = 2;
    public const IS_USER = 3;

    
    /**
     * Get the department that the user belongs to.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
