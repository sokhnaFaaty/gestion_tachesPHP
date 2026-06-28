<?php

class Database {

    private ?PDO $connexion = null;

    public function __construct() {
        $this->ouvrir();
    }

    private function ouvrir(): void {
        try {
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $this->connexion = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo('Erreur : ' . $e->getMessage());
        }
    }

    private function fermer(): void {
        $this->connexion = null;
    }

    public function select(string $sql, array $data = [], bool $one = false) {
        $statement = $this->connexion->prepare($sql);
        count($data) == 0 ? $statement->execute() : $statement->execute($data);
        return $one ? $statement->fetch() : $statement->fetchAll();
    }

    public function update(string $sql, array $data): bool {
        $statement = $this->connexion->prepare($sql);
        return $statement->execute($data);
    }

    public function __destruct() {
        $this->fermer();
    }
}