<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    User::create(array(
        'name' => 'sevilayha',
        'email'    => 'chris@scotch.io',
        'password' => Hash::make('awesome'),
		'permissions' => 'user',
    ));
}

}

?>