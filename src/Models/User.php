<?php
namespace App\Models;

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        $users = $this->where(['email' => $email]);
        return $users[0] ?? null;
    }
}