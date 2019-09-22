<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder.
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        /*
         * Superadmin
         */
        factory(User::class)->create([
            'name'  => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);

        /*
         * Editors
         */
        for ($i = 1; $i <= 5; $i++) {
            factory(User::class)->create([
                'name'  => "Editor $i",
                'email' => "editor-$i@example.com",
                'roles' => ['editor'],
            ]);
        }

        /*
         * Authors
         */
        for ($i = 1; $i <= 5; $i++) {
            factory(User::class)->create([
                'name'  => "Author $i",
                'email' => "author-$i@example.com",
                'roles' => ['author'],
            ]);
        }
    }
}
