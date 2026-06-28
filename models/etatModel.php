<?php

require_once ROOT . '/db/Database.php';

class EtatModel {

    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function findAll(): array {
        $sql = "SELECT * FROM etats ORDER BY id";
        return $this->db->select($sql) ?: [];
    }

    public function findById(int $id): ?array {
        $sql = "SELECT * FROM etats WHERE id = :id";
        return $this->db->select($sql, ['id' => $id], true) ?: null;
    }

    public function findByLibelle(string $libelle): ?array {
        $sql = "SELECT * FROM etats WHERE libelle = :libelle";
        return $this->db->select($sql, ['libelle' => $libelle], true) ?: null;
    }

    public function getDefaultId(): int {
        $etat = $this->findByLibelle('A faire');
        return $etat ? (int)$etat['id'] : 1;
    }
}