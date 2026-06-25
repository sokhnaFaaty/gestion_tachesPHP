<?php

require_once ROOT . 'models/etatModel.php';

// Récupérer toutes les tâches
function tacheFindAll(): array {
    $sql = "SELECT t.*, e.libelle as etat_libelle
            FROM taches t 
            LEFT JOIN etats e ON t.etat_id = e.id
            ORDER BY t.date ASC";
    return executeSelect($sql) ?: [];
}

// Récupérer une tâche par son ID
function tacheFindById(int $id): ?array {
    $sql = "SELECT t.*, e.libelle as etat_libelle
            FROM taches t 
            LEFT JOIN etats e ON t.etat_id = e.id 
            WHERE t.id = :id";
    return executeSelect($sql, ['id' => $id], true) ?: null;
}

// Récupérer les tâches par état
function tacheFindByEtat(int $etatId): array {
    $sql = "SELECT t.*, e.libelle as etat_libelle
            FROM taches t 
            LEFT JOIN etats e ON t.etat_id = e.id 
            WHERE t.etat_id = :etat_id
            ORDER BY t.date ASC";
    return executeSelect($sql, ['etat_id' => $etatId]) ?: [];
}


// Ajouter une tâche
function tacheCreate(array $data): int|false {
    $etatId = $data['etat_id'] ?? etatGetDefaultId();

    $sql    = "INSERT INTO taches (libele, date, description, etat_id)
               VALUES (:libele, :date, :description, :etat_id)
               RETURNING id";

    $result = executeSelect($sql, [
        'libele'      => $data['libele'],
        'date'        => $data['date'],
        'description' => $data['description'] ?? '',
        'etat_id'     => $etatId
    ], true);

    return $result ? (int)$result['id'] : false;
}

// Modifier une tâche
function tacheUpdate(int $id, array $data): bool {
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
        'etat_id' => $data['etat_id'] ?? etatGetDefaultId()
    ];
    
    $result = executeUpdate($sql, $params);
    return $result !== false;
}

// Supprimer une tâche
function deleteTacheById(int $id): bool {
    $sql = "DELETE FROM taches WHERE id = :id";
    $result = executeUpdate($sql, ['id' => $id]);
    return $result !== false;
}



// CHANGEMENT D'ÉTAT


// Marquer comme "Terminé"
function tacheSetTermine(int $id): bool {
    $etat = etatFindByLibelle('Terminé');
    if (!$etat) return false;
    
    $sql = "UPDATE taches SET etat_id = :etat_id, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
    $result = executeUpdate($sql, [
        'id' => $id,
        'etat_id' => $etat['id']
    ]);
    return $result !== false;
}

// Marquer comme "En cours"
function tacheSetEnCours(int $id): bool {
    $etat = etatFindByLibelle('En cours');
    if (!$etat) return false;
    
    $sql = "UPDATE taches SET etat_id = :etat_id, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
    $result = executeUpdate($sql, [
        'id' => $id,
        'etat_id' => $etat['id']
    ]);
    return $result !== false;
}

// Remettre à "A faire"
function tacheSetAFaire(int $id): bool {
    $etat = etatFindByLibelle('A faire');
    if (!$etat) return false;
    
    $sql = "UPDATE taches SET etat_id = :etat_id, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
    $result = executeUpdate($sql, [
        'id' => $id,
        'etat_id' => $etat['id']
    ]);
    return $result !== false;
}