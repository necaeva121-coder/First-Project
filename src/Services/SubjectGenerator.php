<?php

namespace App\Services;

class SubjectGenerator
{
    private array $tech = ["Профильная математика", "Физика", "Информатика", "Химия"];
    private array $hum = ["Обществознание", "История", "Литература", "Иностранный язык"];
    private array $med = ["Химия", "Биология"];

    /**
     * Генерирует массив предметов и баллов для указанного профиля
     */
    public function generateForProfile(string $profile): array
    {
        $subjects = [];
        $scores = [];

        // Переносим вашу существующую логику
        if ($profile === "tech") {
            $randomSub = rand(1, 3);
            $subjects = ["Русский язык", $this->tech[0], $this->tech[$randomSub]];

            // Генерация баллов
            foreach ($subjects as $index => $subject) {
                $scores[$index] = rand(0, 100);
            }
        } 
        else if ($profile === "human") {
            $randomSub = rand(1, 3);
            $subjects = ["Русский язык", $this->hum[0], $this->hum[$randomSub]];

            foreach ($subjects as $index => $subject) {
                $scores[$index] = rand(0, 100);
            }
        } 
        else if ($profile === "med") {
            $subjects = ["Русский язык", $this->med[0], $this->med[1]];

            foreach ($subjects as $index => $subject) {
                $scores[$index] = rand(0, 100);
            }
        }

        return [
            'subjects' => $subjects,
            'scores'   => $scores
        ];
    }
}