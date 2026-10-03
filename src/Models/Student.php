<?php
// Создание класса Student
class Student {
    // атрибуты основные
    private string $fullName;
    private string $email;
    private string $profile;
    private array $subjects;
    private array $scores;

    // конструктор
    public function __construct(string $fullName, string $email, string $profile, array $subjects, array $scores)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->profile = $profile;
        $this->subjects = $subjects;
        $this->scores = $scores;
    }

    // геттеры
    public function getFullName(): string {return $this->fullName;}
    public function getSubjects() : array {return $this->subjects;}
    public function getScores(): array {return $this->scores;}
    public function getEmail(): string { return $this->email; }
    public function getProfile(): string { return $this->profile; }
    
    // Метод расчёта суммы баллов
    public function getSumScore(): int 
    {
        return array_sum($this->scores);
    }
}
?>