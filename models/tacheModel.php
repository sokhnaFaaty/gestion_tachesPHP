<?php

require_once ROOT . '/db/Database.php';
require_once ROOT . '/models/EtatModel.php';

class TacheModel {

    private Database $db;
    private EtatModel $etatModel;

    public function __construct() {
        $this->db = new Database();
        $this->etatModel = new EtatModel();
    }

    // Récupérer toutes les tâches
    public function findAll(): array {
        $sql = "SELECT t.*, e.libelle as etat_libelle
                FROM taches t
                LEFT JOIN etats e ON t.etat_id = e.id
                ORDER BY t.date ASC";
        return $this->db->select($sql) ?: [];
    }

    // Récupérer une tâche par son ID
    public function findById(int $id): ?array {
        $sql = "SELECT t.*, e.libelle as etat_libelle
                FROM taches t
                LEFT JOIN etats e ON t.etat_id = e.id
                WHERE t.id = :id";
        return $this->db->select($sql, ['id' => $id], true) ?: null;
    }

    // Récupérer les tâches par état
    public function findByEtat(int $etatId): array {
        $sql = "SELECT t.*, e.libelle as etat_libelle
                FROM taches t
                LEFT JOIN etats e ON t.etat_id = e.id
                WHERE t.etat_id = :etat_id
                ORDER BY t.date ASC";
        return $this->db->select($sql, ['etat_id' => $etatId]) ?: [];
    }

    // Ajouter une tâche
    public function create(array $data): int|false {
        $etatId = $data['etat_id'] ?? $this->etatModel->getDefaultId();

        $sql = "INSERT INTO taches (libele, date, description, etat_id)
                VALUES (:libele, :date, :description, :etat_id)
                RETURNING id";

        $result = $this->db->select($sql, [
            'libele'      => $data['libele'],
            'date'        => $data['date'],
            'description' => $data['description'] ?? '',
            'etat_id'     => $etatId
        ], true);

        return $result ? (int)$result['id'] : false;
    }

    // Modifier une tâche
    public function update(int $id, array $data): bool {
        $sql = "UPDATE taches SET
                libele = :libele,
                date = :date,
                description = :description,
                etat_id = :etat_id,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

        $params = [
            'id' => $id,
            'libele' => $data['libele'],
            'date' => $data['date'],
            'description' => $data['description'] ?? '',
            'etat_id' => $data['etat_id'] ?? $this->etatModel->getDefaultId()
        ];

        $result = $this->db->update($sql, $params);
        return $result !== false;
    }

    // Supprimer une tâche
    public function delete(int $id): bool {
        $sql = "DELETE FROM taches WHERE id = :id";
        $result = $this->db->update($sql, ['id' => $id]);
        return $result !== false;
    }

    // ===== CHANGEMENT D'ÉTAT =====

    private function changerEtat(int $id, string $libelleEtat): bool {
        $etat = $this->etatModel->findByLibelle($libelleEtat);
        if (!$etat) return false;

        $sql = "UPDATE taches SET etat_id = :etat_id, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $result = $this->db->update($sql, [
            'id' => $id,
            'etat_id' => $etat['id']
        ]);
        return $result !== false;
    }

    // Marquer comme "Terminé"
    public function setTermine(int $id): bool {
        return $this->changerEtat($id, 'Terminé');
    }

    // Marquer comme "En cours"
    public function setEnCours(int $id): bool {
        return $this->changerEtat($id, 'En cours');
    }

    // Remettre à "A faire"
    public function setAFaire(int $id): bool {
        return $this->changerEtat($id, 'A faire');
    }
}