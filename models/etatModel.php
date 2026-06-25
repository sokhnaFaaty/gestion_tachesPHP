<?php


require_once ROOT . '/db/database.php';

function etatFindAll(): array {
    $sql = "SELECT * FROM etats ORDER BY id";
    return executeSelect($sql) ?: [];
}

function etatFindById(int $id): ?array {
    $sql = "SELECT * FROM etats WHERE id = :id";
    return executeSelect($sql, ['id' => $id], true) ?: null;
}

function etatFindByLibelle(string $libelle): ?array {
    $sql = "SELECT * FROM etats WHERE libelle = :libelle";
    return executeSelect($sql, ['libelle' => $libelle], true) ?: null;
}

function etatGetDefaultId(): int {
    $etat = etatFindByLibelle('A faire');
    return $etat ? (int)$etat['id'] : 1;
}