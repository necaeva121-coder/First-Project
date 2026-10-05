<?php

namespace App\Services;

use App\Models\User;

class AuthService {
    private User $userModel;

    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $this->userModel = new User();
    }

    // Метод регистрации пользователя
    public function register(string $fullname, string $email, string $password, string $profile, array $subjectsData = []): bool
    {
        // Хэшируем пароль
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Кодируем баллы в JSON
        $jsonSubjects = !empty($subjectsData) ? json_encode($subjectsData, JSON_UNESCAPED_UNICODE) : null;
    
        return $this->userModel->create([
            'fullname'      => $fullname,
            'email'         => $email,
            'password'      => $hashedPassword,
            'profile'       => $profile,
            'subjects_data' => $jsonSubjects
        ]);
    }

    // Метод авторизации пользователя по email и паролю
    public function login(string $email, string $password): bool {
        $user = $this->userModel->findByEmail($email);

        if(!$user){
            return false;
        }

        // Проверка соответствия введенного пароля хэшу
        if(password_verify($password, $user['password'])){
            unset($user['password']);
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

        // Проверка на регистрацию пользователя
        public function check(): bool {
            return isset($_SESSION['user']);
        }

        // Получение текущего пользователя
        public function user(): ?array{
            return $_SESSION['user'] ?? null;
        }

        // Выход из системы
        public function logout(): void {
            unset($_SESSION['user']);
            session_destroy();
        }
}