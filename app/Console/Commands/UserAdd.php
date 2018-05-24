<?php

namespace App\Console\Commands;

use App\User;
use App\UserRole;
use Illuminate\Console\Command;

/**
 * Команда добавления нового пользователя.
 */
class UserAdd extends Command
{
    /**
     * @inheritdoc
     */
    protected $signature = 'user:add';
    /**
     * @inheritdoc
     */
    protected $description = 'Add a new user';

    /**
     * Добавление пользователя.
     */
    public function handle()
    {

        // todo: перенести в сервис

        $name = $this->ask("Enter user name");

        try {
            $password = substr(base64_encode(random_bytes(8)), 0, 8);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            exit(1);
        }

        $user = User::create([
            'name' => $name,
            'role' => UserRole::USER,
            'password_hash' => app('hash')->make($password),
        ]);

        $this->info("User was created");
        $this->line("Username: {$name}");
        $this->line("Password: {$password}");
    }
}