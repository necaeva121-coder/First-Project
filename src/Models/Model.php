<?php

// Определение область видимости 
namespace App\Models;

use App\Database;
use PDO;

// Создание абстрактный класс
abstract class Model {
    // Инициализация атрибутов
    protected PDO $db;
    protected string $table;

    // Определение конструктора
    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Реализация метода, который возвращает все записи из таблицы
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    // Реализация метода, который ищет записи по ID
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    // Реализация метода, который ищет записи по условиям
    public function where(array $conditions): array {
        $fields = [];
        foreach($conditions as $column => $values){
            $fields[] = "{$column} = :{$column}";
        }

        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $fields);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);

        return $stmt->fetchAll();
    }

    // Реализация метода, который вставлять новую запись в таблицу
    public function create(array $data): bool {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    // Реализация метода, который обновляет записи по ID
    public function update(int $id, array $data): bool {
        $fields = [];
        foreach($data as $column => $values){
            $fields[] = "{$column} = :{$column}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Реализация метода, который удаляет записи по ID
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

