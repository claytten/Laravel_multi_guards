<?php

use App\Models\Customers\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'=>'I am User 1',
                'username'=>'user1',
                'email'=>'user1@gmail.com',
                'password'=> bcrypt('User_111'),
                'image' => null,
                'is_active' => true
            ],
            [
                'name'=>'I am User 2',
                'username'=>'user2',
                'email'=>'user2@gmail.com',
                'password'=> bcrypt('User_222'),
                'image' => null,
                'is_active' => true
            ],
            [
                'name'=>'I am User 3',
                'username'=>'user3',
                'email'=>'user3@gmail.com',
                'password'=> bcrypt('User_333'),
                'image' => null,
                'is_active' => true
            ]
        ];

        foreach($users as $item) {
            $user = Customer::where('email', $item['email'])->first();
            if(empty($user)){
                $store = Customer::create([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'username' => $item['username'],
                    'password' => $item['password'],
                    'image'=> $item['image'],
                    'is_active' => $item['is_active']
                ]);
            }
        }
        
    }
}
