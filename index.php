<?php
session_start();
// Логика основного раздела

// Получаем данные
$fullname = $_SESSION['fullname'] ?? '';
$status = $_SESSION['profile'] ?? '';

// Предметы для ЕГЭ
$tech = ["Профильная математика","Физика","Информатика","Химия"];
$hum = ["Обществознание","История","Литература","Иностранный язык"];
$med = ["Химия","Биология"];

// Массив для хранения выбранных предметов
$student_subjects = [];
// Массив для хранения сгенерированных баллов
$student_points = [];
// Итоговое количество баллов
$points_sum = 0;

// Добавление предметов по присланному статусу
if($status === "tech"){
    $random_sub = rand(1, 3);
    $student_subjects[0] = "Русский язык";
    $student_subjects[1] = $tech[0];
    $student_subjects[2] = $tech[$random_sub];
}
else if($status === "human"){
    $random_sub = rand(1, 3);
    $student_subjects[0] = "Русский язык";
    $student_subjects[1] = "Базовая математика";
    $student_subjects[2] = $hum[0];
    $student_subjects[3] = $hum[$random_sub];
}
else if($status === "med"){
    $student_subjects[0] = "Русский язык";
    $student_subjects[1] = "Базовая математика";
    $student_subjects[2] = $med[0];
    $student_subjects[3] = $med[1];
}

// Добавление баллов по предметам
if($status === "tech"){
    for($index = 0; $index < count($student_subjects); $index++){
        $random_sub = rand(0, 100);        
        $student_points[$index] = $random_sub;        
    }
    $points_sum = array_sum($student_points);
}

else if($status != "tech"){
    for($index = 0; $index < count($student_subjects); $index++){
        if ($index == 1) {
            $random_sub = rand(2, 5);        
            $student_points[$index] = $random_sub;
        } else {
            $random_sub = rand(0, 100);        
            $student_points[$index] = $random_sub;
        }
    }
    $points_sum = array_sum($student_points) - $student_points[1];
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Сайт абитуриента</title>
</head>
<body>
    <header class="header">
        <div class="header__wrapper">
            <img src="logo.jpg" alt="logo" class="header__logo">
            <h3 class="header__title">Калькулятор ЕГЭ 1.0</h3>
        </div>
    </header>
    <main>
        <section class="welcome">
            <h1 class="welcome__title">Добро пожаловать!</h1>
            <p class="welcome__desc">Это сайт Калькулятор ЕГЭ. Здесь вы можете посмотреть ваши текущие баллы ЕГЭ</p>
        </section>
        <section class="student">
            <div class="container">
                <p class="student__fullname"><?= htmlspecialchars($fullname) ?></p>
                <h3 class="student__title">Ваши баллы</h3>
                    <?php for ($index = 0; $index < count($student_subjects); $index++): ?>
                        <div class="subject__card">
                            <div class="subject"><?= htmlspecialchars($student_subjects[$index]) ?> :</div>
                            <div class="points"><?= htmlspecialchars($student_points[$index]) ?></div>
                        </div>
                    <?php endfor; ?>
                    <div class="point__wrapper">
                        <h3 class="final__title">Итоговая сумма:</h3>
                        <div class="final_score"><?= $points_sum ?></div>
                    </div>
                </div>
        </section>
        
    </main>
    <footer class="footer">
        <p class="footer__desc">(c) KISILISTA</p>
    </footer>
</body>
</html>