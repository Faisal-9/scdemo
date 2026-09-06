<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statecorps:create-admin
                            {--name= : Full name}
                            {--email= : Email address}
                            {--role=super_admin : super_admin, admin, or editor}
                            {--password= : Password (omit to enter it privately)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update an active State Corps CMS user.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $role = $this->option('role');

        if (! in_array($role, ['super_admin', 'admin', 'editor'], true)) {
            $this->error('Role must be super_admin, admin, or editor.');

            return self::FAILURE;
        }

        $name = $this->option('name') ?: $this->ask('Full name');
        $email = $this->option('email') ?: $this->ask('Email address');
        $password = $this->option('password') ?: $this->secret('Password (minimum 12 characters)');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($password) < 12) {
            $this->error('Provide a valid email and a password of at least 12 characters.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => mb_strtolower($email)],
            ['name' => $name, 'password' => Hash::make($password), 'role' => $role, 'is_active' => true],
        );

        $this->info('CMS user saved.');

        return self::SUCCESS;
    }
}
