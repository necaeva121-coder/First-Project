<?php
session_start();
// Логика основного раздела

// Подключение классов 
require_once __DIR__ . '/src/Student.php';
require_once __DIR__ . '/src/SubjectGenerator.php';

// Получение данных
$fullname = $_SESSION['fullname'] ?? '';
$email = $_SESSION['email'] ?? '';
$status = $_SESSION['profile'] ?? '';

// Генерация предметов и создание объекта абитуриента
$generator = new SubjectGenerator();
$data = $generator->generateForProfile($status);
$student = new Student(
    $fullname, 
    $email, 
    $status, 
    $data['subjects'], 
    $data['scores']
    );

// Для удобства работы с массивами в цикле
$subjects = $student->getSubjects();
$scores = $student->getScores();

?>

<?php require_once __DIR__ . '/views/header.php'; ?>
    <main>
        <section class="welcome">
            <h1 class="welcome__title">Добро пожаловать!</h1>
            <p class="welcome__desc">Это сайт Калькулятор ЕГЭ. Здесь вы можете посмотреть ваши текущие баллы ЕГЭ</p>
        </section>
        <section class="student">
            <div class="container">
                <p class="student__fullname"><?= htmlspecialchars($fullname) ?></p>
                <h3 class="student__title">Ваши баллы</h3>
                    <?php for ($index = 0; $index < count($subjects); $index++): ?>
                        <div class="subject__card">
                            <div class="subject"><?= htmlspecialchars($subjects[$index]) ?> :</div>
                            <div class="points"><?= htmlspecialchars($scores[$index]) ?></div>
                        </div>
                    <?php endfor; ?>
                    <div class="point__wrapper">
                        <h3 class="final__title">Итоговая сумма:</h3>
                        <div class="final_score"><?= $student->getSumScore() ?></div>
                    </div>
                </div>
        </section>
        
    </main>
<?php require_once __DIR__ . '/views/footer.php'; ?>