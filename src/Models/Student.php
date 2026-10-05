<?php

namespace App\Models;

class Student extends Model {
    protected string $table = 'users';

    private string $fullname;
    private string $email;
    private string $status;
    private array $subjects;
    private array $scores;

    public function __construct(
        string $fullname = '',
        string $email = '',
        string $status = '',
        array $subjects = [],
        array $scores = []
    ) {
        parent::__construct(); // Вызываем конструктор родительской модели

        $this->fullname = $fullname;
        $this->email = $email;
        $this->status = $status;
        $this->subjects = $subjects;
        $this->scores = $scores;
    }

    public function getSubjects(): array {
        return $this->subjects;
    }

    public function getScores(): array {
        return $this->scores;
    }

    public function getSumScore(): int {
        return array_sum($this->scores);
    }
}