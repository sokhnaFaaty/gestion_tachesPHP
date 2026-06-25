<?php


require_once ROOT . '/db/database.php';

function userFindByEmail(string $email): ?array {
    $sql = "SELECT * FROM users WHERE email = :email";
    return executeSelect($sql, ['email' => $email], true) ?: null;
}

function userFindById(int $id): ?array {
    $sql = "SELECT * FROM users WHERE id = :id";
    return executeSelect($sql, ['id' => $id], true) ?: null;
}

function userCreate(array $data): int|false {
    $sql = "INSERT INTO users (nom, email, password) VALUES (:nom, :email, :password)";
    return executeUpdate($sql, [
        'nom' => $data['nom'],
        'email' => $data['email'],
        'password' => $data['password']
    ]);
}

function userEmailExists(string $email): bool {
    $sql = "SELECT COUNT(*) as total FROM users WHERE email = :email";
    $result = executeSelect($sql, ['email' => $email], true);
    return $result ? (int)$result['total'] > 0 : false;
}