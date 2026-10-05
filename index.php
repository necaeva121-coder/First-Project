<?php

require_once __DIR__ . '/autoload.php';

use App\Services\Router;
use App\Models\Student;
use App\Models\User;
use App\Services\SubjectGenerator;
use App\Services\AuthService;

$router = new Router();
$auth   = new AuthService();

// 1. Главная страница (GET)

$router->get('/', function() use ($auth) {
    if (!$auth->check()) {
        // Главная страница для неавторизованных гостей
        require_once __DIR__ . '/views/header.php';
        ?>
        <main>
            <section class="welcome">
                <h1 class="welcome__title">Добро пожаловать в Калькулятор ЕГЭ!</h1>
                <p class="welcome__desc">Для просмотра и расчёта баллов войдите в аккаунт или зарегистрируйтесь.</p>
            </section>
            <section class="register">
                <div class="form">
                    <a href="/login"><button type="submit">Войти</button></a>
                    <a href="/register"><button type="submit">Зарегистрироваться</button></a>
                </div>
            </section>
        </main>
        <?php
        require_once __DIR__ . '/views/footer.php';
        return;
    }

    // Если пользователь авторизован — берем данные из сессии
    $user     = $auth->user();
    $fullname = $user['fullname'] ?? 'Студент';
    $status   = $user['profile']  ?? 'tech';

    // 1. Проверяем, сохранены ли уже баллы в БД
    $subjectsData = !empty($user['subjects_data']) 
        ? json_decode($user['subjects_data'], true) 
        : null;

    // 2. Если баллов нет (NULL) — генерируем один раз и сохраняем в БД
    if (!$subjectsData) {
        $generator    = new SubjectGenerator();
        $subjectsData = $generator->generateForProfile($status);

        $userModel = new User();
        $userModel->update($user['id'], [
            'subjects_data' => json_encode($subjectsData, JSON_UNESCAPED_UNICODE)
        ]);
        
        // Обновляем данные текущего пользователя в сессии
        $_SESSION['user']['subjects_data'] = json_encode($subjectsData, JSON_UNESCAPED_UNICODE);
    }

    // 3. Создаем модель студента с зафиксированными баллами
    $student = new Student(
        $fullname,
        $user['email'] ?? '',
        $status,
        $subjectsData['subjects'] ?? [],
        $subjectsData['scores']   ?? []
    );

    $subjects = $student->getSubjects();
    $scores   = $student->getScores();

    require_once __DIR__ . '/views/home.php';
});


// 2. Страница входа (GET)

$router->get('/login', function() {
    require_once __DIR__ . '/views/login.php';
});


// 3. Обработка формы входа (POST)

$router->post('/login', function() use ($auth) {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($auth->login($email, $password)) {
        header('Location: /');
        exit;
    }

    $error = "Неверный email или пароль";
    require_once __DIR__ . '/views/login.php';
});


// 4. Страница регистрации (GET)

$router->get('/register', function() {
    require_once __DIR__ . '/views/register.php';
});


// 5. Обработка формы регистрации (POST)

$router->post('/register', function() use ($auth) {
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $profile  = trim($_POST['profile'] ?? 'tech');

    $fullname_error = '';
    $email_error    = '';
    $password_error = '';

    // Валидация полей
    if ($fullname === '') {
        $fullname_error = 'Введите ФИО';
    }
    if ($email === '') {
        $email_error = 'Введите Email';
    }
    if ($password === '') {
        $password_error = 'Введите пароль';
    }

    if ($fullname_error !== '' || $email_error !== '' || $password_error !== '') {
        require_once __DIR__ . '/views/register.php';
        return;
    }

    // Генерация баллов в момент создания аккаунта
    $generator    = new SubjectGenerator();
    $subjectsData = $generator->generateForProfile($profile);

    // Сохранение пользователя вместе со сгенерированными баллами
    if ($auth->register($fullname, $email, $password, $profile, $subjectsData)) {
        $auth->login($email, $password);
        header('Location: /');
        exit;
    }

    $error = 'Пользователь с таким Email уже зарегистрирован';
    require_once __DIR__ . '/views/register.php';
});


// 6. Выход из системы (GET)

$router->get('/logout', function() use ($auth) {
    $auth->logout();
    header('Location: /login');
    exit;
});


// Запуск маршрутизатора

$router->dispatch();