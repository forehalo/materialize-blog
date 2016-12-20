<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Hidden attributes when select
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * Set the user's password.
     *
     * @param $val
     */
    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = bcrypt($val);
    }
}
