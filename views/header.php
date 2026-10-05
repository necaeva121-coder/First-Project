<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор ЕГЭ</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<header>
    <div class="container header__wrapper" style="display: flex; justify-content: space-between; align-items: center;">
        <a href="/">
            <img src="/logo.jpg" alt="Логотип" class="header__logo">
        </a>
        <nav class="header__nav" style="display: flex; gap: 15px; align-items: center;">
            <?php if (isset($_SESSION['user'])): ?>
                <span style="font-weight: bold;"><?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Студент') ?></span>
                <a href="/logout"><button type="button">Выйти</button></a>
            <?php else: ?>
                <a href="/login"><button type="button">Войти</button></a>
                <a href="/register"><button type="button">Зарегистрироваться</button></a>
            <?php endif; ?>
        </nav>
    </div>
</header>