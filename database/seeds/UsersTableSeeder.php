<?php

use App\Task;
use App\User;
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
        $user = factory(User::class)->create([
            'email' => 'dev.omrc@gmail.com'
        ]);

        $user->tasks()->saveMany(
            factory(Task::class, 10)->create()
        );

        factory(User::class, 50)->create()->each(function ($user) {
            $user->tasks()->saveMany(
                factory(Task::class, 10)->create()
            );
        });
    }
}
