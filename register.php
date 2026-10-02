<?php
// Логика формы регистрации
session_start();

// Проверка, что это форма отправки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Извлекаем данные из input select
    $fullname = trim($_POST['fullname']);
    $password = trim($_POST['password']);
    $status = trim($_POST['profile']);

    // Вместо массивов задаём переменные
    $fullname_error = '';
    $password_error = '';

    // Проверка на пустые строки
    if($fullname === '') {
        $fullname_error = 'Введите ФИО';
    }

    if($password === ''){
        $password_error = 'Введите пароль';
    }

    // В случае отсутствия ошибок - редирект
    if($fullname_error === '' && $password_error === ''){
        $_SESSION['fullname'] = $fullname;
        $_SESSION['profile'] = $status;
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Форма регистрации</title>
</head>
<body>
    <header class="header">
        <div class="header__wrapper">
            <img src="logo.jpg" alt="logo" class="header__logo">
            <h3 class="header__title">Калькулятор ЕГЭ 1.0</h3>
        </div>
    </header>
    <section class="register">
        <form action="register.php" method="POST" class = "register__form">
            <div class="form name__form">
                <p class="title name__title">ФИО:</p>
                <input type="text" class="input name__input" name="fullname">
                <?php if (!empty($fullname_error)): ?>
                    <span class="error"><?= htmlspecialchars($fullname_error) ?></span>
                <?php endif; ?>
            </div>
            <div class="form password__form">
                <p class="title password__title">Пароль:</p>
                <input type="password" class="input password__input" name="password"> 
                <?php if (!empty($password_error)): ?>
                    <span class="error"><?= htmlspecialchars($password_error) ?></span>
                <?php endif; ?>
            </div>
            <div class="form profile__form">
                <label for="profile">Выберите профиль:</label>
                    <select id="profile" name="profile">
                      <option value="tech">Технологический</option>
                      <option value="human">Гуманитарный</option>
                      <option value="med">Медицинский</option>
                    </select>
            </div>
            <button type="submit">Зарегистрироваться</button> 
        </form>
    </section>
    <footer class="footer">
        <p class="footer__desc">(c) KISILISTA</p>
    </footer>
</body>
</html>