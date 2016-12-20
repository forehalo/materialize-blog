<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

// Manually change dashboard password.
Artisan::command(
    'passwd 
    {user : The name of the user}', function ($user) {
    $admin = \App\Models\Admin::where('name', $user)->first();
    if (is_null($admin)) {
        $this->error('non-existent username');
    } else {
        $password = $this->secret('What is the password');
        $confirm = $this->secret('Confirm password');
        if($password !== $confirm) {
            $this->error('The password must match the one above.');
        } else {
            $admin->update(['password' => $password]);
            $this->info('Change password successfully.');
        }
    }
})->describe('Change password of given user.');
