<?php

use CodeEduUser\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create([
            'name' => 'Admin Editora',
            'email' => 'admin@editora.com'
        ]);

        factory(User::class, 1)->create([
            'name' => 'Admin2 Editora',
            'email' => 'admin2@editora.com'
        ]);
    }
}
