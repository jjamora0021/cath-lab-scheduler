<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Carbon\Carbon;
use DB;

class CreateUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $users = [
        	[
                'user_id' => Str::random(40) . time(),
	            'first_name' => 'John Joshua',
                'middle_name' => 'Alforte',
                'last_name' => 'Jamora',
                'username' => 'jjamora0021',
                'email' => 'jjamora0021@gmail.com',
	            'password' => bcrypt('password'),
	            'remember_token' => Str::random(40) . time(),
	            'user_role' => 'superadmin',
                'status' => 'ACTIVE',
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'user_id' => Str::random(40) . time(),
                'first_name' => 'Maria Theressa',
                'middle_name' => 'Maniquiz',
                'last_name' => 'Maneclang',
                'username' => 'tetay',
                'email' => 'maneclangmariatheressa@yahoo.com',
                'password' => bcrypt('password'),
                'remember_token' => Str::random(40) . time(),
                'user_role' => 'manager',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        foreach ($users as $user) {
        	DB::table('users')->insert($user);
        }
    }
}
