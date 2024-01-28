<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email','chrissh0485@gmail.com')->first();
        if (empty($user)){
            $user = new User();
            $user->name = 'Christopher Shawn';
            $user->email = 'chrissh0485@gmail.com';
            $user->password = Hash::make('123456');
            $user->save();
        }else{
            $user->email = 'chrissh0485@gmail.com';
            $user->password = Hash::make('123456');
            $user->save();
        }
    }
}
