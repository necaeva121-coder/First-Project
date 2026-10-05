<?php
/**
 * @var string $fullname
 * @var array<int, string> $subjects
 * @var array<int, int> $scores
 * @var \App\Models\Student $student
 */

require_once __DIR__ . '/header.php'; 
?>

<main>
    <section class="welcome">
        <h1 class="welcome__title">Добро пожаловать!</h1>
        <p class="welcome__desc">Это сайт Калькулятор ЕГЭ. Здесь вы можете посмотреть ваши текущие баллы ЕГЭ</p>
    </section>
    <section class="student">
        <div class="container">
            <p class="student__fullname"><?= htmlspecialchars($fullname ?? 'Гость') ?></p>
            <h3 class="student__title">Ваши баллы</h3>
            
            <?php 
            $subjectsList = $subjects ?? [];
            $scoresList = $scores ?? [];
            ?>

            <?php for ($index = 0; $index < count($subjectsList); $index++): ?>
                <div class="subject__card">
                    <div class="subject"><?= htmlspecialchars($subjectsList[$index] ?? '') ?> :</div>
                    <div class="points"><?= htmlspecialchars($scoresList[$index] ?? 0) ?></div>
                </div>
            <?php endfor; ?>

            <div class="point__wrapper">
                <h3 class="final__title">Итоговая сумма:</h3>
                <div class="final_score"><?= isset($student) ? htmlspecialchars($student->getSumScore()) : 0 ?></div>
            </div>

            <div style="margin-top: 30px;">
                <a href="/logout"><button type="button">Сменить пользователя (Выйти)</button></a>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>