<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
//        $user = User::create([
//            'name' => 'Super Admin',
//            'email' => 'super_admin@app.com',
//            'password' => bcrypt('123456'),
//            'phone' => '777888999',
//            'type' => 1,
//        ]);

        $user = User::find(1);

        $role = Role::find(1);
        if ($role)
            $user->syncRoles([$role->name]);

//        ClientType::create([
//            'name' => '{"en": "test","ar": "تجربة"}',
//        ]);
//
//        User::create([
//            'name' => 'Employee Name',
//            'email' => 'emp1@app.com',
//            'password' => bcrypt('123456'),
//            'phone' => '111222333',
//            'type' => 2,
//        ]);
//
//        $user2 = User::create([
//            'name' => 'Client Name',
//            'email' => 'client1@app.com',
//            'password' => bcrypt('123456'),
//            'phone' => '333222111',
//            'type' => 3,
//        ]);
//
//        Client::create([
//            'user_id' => $user2->id,
//            'type_id' => 1,
//        ]);
    }
}
