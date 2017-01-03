<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];
}
