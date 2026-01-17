<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetStudentPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:student-password {username} {new_password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for a student user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');
        $newPassword = $this->argument('new_password');

        $user = User::where('username', $username)->first();

        if (!$user) {
            $this->error("User dengan username {$username} tidak ditemukan.");
            return;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info("Password untuk user {$username} berhasil diubah.");
    }
}