<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name'=>'mohammad',
            'username'=>'moe',
            'email'=>'moe@test.com',
            'password'=>bcrypt("1234567")
            
        ]);

        dd($user);
    }
}
