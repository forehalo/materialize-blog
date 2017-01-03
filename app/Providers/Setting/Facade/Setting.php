<?php 
namespace App\Providers\Setting\Facade;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
}