<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'blog_settings';
    /**
     * The mass assignable attributes.
     * 
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * Disable timestamps record.
     */
    public $timestamps = false;
}
