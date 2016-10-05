<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $user = app()->make('App\Auth\User');
        $hasher = app()->make('hash');

        $user->fill([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => $hasher->make('user1234'),
            'is_admin' => 1
        ]); 
        $user->save();
    }

}

?>