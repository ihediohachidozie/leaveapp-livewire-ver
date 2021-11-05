<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    /*
        protected $fillable = [
        'name',
        'email',
        'password',
    ]; */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the company for the users.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the category for the users.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
 
    /**
     * Get the department for the users.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);  
    }    



    /**
     * Get the department for the users.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);  
    }

    
    public function Leaves()
    {
        return $this->hasMany(Leave::class);     
    } 

    
    public function rosters()
    {
        return $this->hasMany(Roster::class);     
    } 

    /**
 * Send a password reset notification to the user.
 *
 * @param  string  $token
 * @return void
 */
    public function sendPasswordResetNotification($token)
    {
        $url = 'https://leaveapp.ecmterminals.com/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
