<?php require_once __DIR__ . '/header.php'; ?>

<section class="register">
    <form action="/register" method="POST" class="register__form">
        
        <?php if (!empty($error)): ?>
            <div class="form__error">
                <span class="error" style="color: red;"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <div class="form name__form">
            <p class="title name__title">ФИО:</p>
            <input type="text" class="input name__input" name="fullname" required value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
            <?php if (!empty($fullname_error)): ?>
                <span class="error"><?= htmlspecialchars($fullname_error) ?></span>
            <?php endif; ?>
        </div>

        <div class="form email__form">
            <p class="title email__title">Email:</p>
            <input type="email" class="input email__input" name="email" required placeholder="example@mail.ru" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <?php if (!empty($email_error)): ?>
                <span class="error"><?= htmlspecialchars($email_error) ?></span>
            <?php endif; ?>
        </div>

        <div class="form password__form">
            <p class="title password__title">Пароль:</p>
            <input type="password" class="input password__input" name="password" required> 
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

<?php require_once __DIR__ . '/footer.php'; ?>