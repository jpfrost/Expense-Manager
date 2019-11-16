<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\User;
Use App\Role;
use App\UserRole;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);

        User::create([
        	'name'		=>	'admin',
        	'email'		=>	'admin@admin.com',
        	'password'	=>	bcrypt('admin'),
        	'role_id'	=> 	(Role::where('name','Admin')->first())->id
        ]);

        User::create([
        	'name'		=>	'user',
        	'email'		=>	'user@admin.com',
        	'password'	=>	bcrypt('admin'),
        	'role_id'	=> 	(Role::where('name','User')->first())->id
        ]);

        /*Roles Types
		1: 'Expense'
		2: 'User'
        */
       
       UserRole::create([
       		'role_id'	=> (Role::where('name','Admin')->first())->id,
       		'type'		=> 1,
       ]);

       UserRole::create([
       		'role_id'	=> (Role::where('name','Admin')->first())->id,
       		'type'		=> 2,
       ]);

       UserRole::create([
       		'role_id'	=> (Role::where('name','User')->first())->id,
       		'type'		=> 1,
       ]);

    }
}
