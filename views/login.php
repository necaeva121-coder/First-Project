<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <section class="auth">
        <div class="container">
            <h2>Авторизация</h2>

            <form action="/login" method="POST" class="auth__form">
                <div class="form__group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="example@mail.ru">
                </div>

                <div class="form__group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required placeholder="Введите ваш пароль">
                </div>

                <button type="submit" class="btn">Войти</button>
            </form>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>