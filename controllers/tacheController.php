<?php

require_once ROOT . 'models/tacheModel.php';
require_once ROOT . 'models/etatModel.php';

// DASHBOARD - Liste des tâches
function tacheDashboard() {
    auth();
    
    $taches = tacheFindAll();
    $etats = etatFindAll();
    $user = $_SESSION['user'] ?? null;
    
    loadView('taches/dashboard', [
        'user' => $user,
        'taches' => $taches,
        'etats' => $etats
    ]);
}

// AJOUTER UNE TÂCHE
function tacheAdd() {
    auth();
    
    $errors = [];
    $tache = ['libele' => '', 'date' => '', 'description' => '', 'etat_id' => ''];
    $etats = etatFindAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouTache'])) {
        $tache['libele'] = trim($_POST['libele'] ?? '');
        $tache['date'] = trim($_POST['date'] ?? '');
        $tache['description'] = trim($_POST['description'] ?? '');
        $tache['etat_id'] = (int)($_POST['etat_id'] ?? 0);
        
        $rules = [
            'libele' => 'required',
            'date' => 'required'
        ];
        
        $errors = validations($_POST, $rules);
        
        if (validate($errors)) {
            $id = tacheCreate([
                'libele' => $tache['libele'],
                'date' => $tache['date'],
                'description' => $tache['description'],
                'etat_id' => $tache['etat_id'] ?: null
            ]);
            
            if ($id) {
                redirectTo('tache', 'dashboard');
                return;
            }
        }
    }
    
    loadView('taches/add', [
        'tache' => $tache,
        'etats' => $etats,
        'errors' => $errors
    ]);
}

// MODIFIER UNE TÂCHE
function tacheEdit() {
    auth();
    
    $id = (int)($_GET['id'] ?? 0);
    $tache = tacheFindById($id);
    
    if (!$tache) {
        redirectTo('tache', 'dashboard');
        return;
    }
    
    $etats = etatFindAll();
    $errors = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifTache'])) {
        $updateData = [
            'libele' => trim($_POST['libele'] ?? ''),
            'date' => trim($_POST['date'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'etat_id' => (int)($_POST['etat_id'] ?? 0)
        ];
        
        $rules = [
            'libele' => 'required',
            'date' => 'required'
        ];
        
        $errors = validations($_POST, $rules);
        
        if (validate($errors)) {
            if (tacheUpdate($id, $updateData)) {
                redirectTo('tache', 'detail', ['id' => $id]);
                return;
            }
        }
    }
    
    loadView('taches/edit', [
        'tache' => $tache,
        'etats' => $etats,
        'errors' => $errors
    ]);
}

// DÉTAIL D'UNE TÂCHE
function tacheDetail() {
    auth();
    
    $id = (int)($_GET['id'] ?? 0);
    $tache = tacheFindById($id);
    
    if (!$tache) {
        redirectTo('tache', 'dashboard');
        return;
    }
    
    loadView('taches/detail', [
        'tache' => $tache
    ]);
}

// SUPPRIMER UNE TÂCHE
function tacheDelete() {
    auth();
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id > 0) {
        tacheDelete($id);
    }
    
    redirectTo('tache', 'dashboard');
}

// CHANGER L'ÉTAT D'UNE TÂCHE

// Marquer comme "Terminé"
function tacheMarquerTerminer() {
    auth();
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id > 0) {
        tacheMarquerTerminer($id);
    }
    
    redirectTo('tache', 'dashboard');
}

// Marquer comme "En cours"
function tacheMarquerEnCours() {
    auth();
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id > 0) {
        tacheMarquerEnCours($id);
    }
    
    redirectTo('tache', 'dashboard');
}

// FILTRER PAR ÉTAT
function tacheFiltrerParEtat() {
    auth();
    
    $etatId = (int)($_GET['etat_id'] ?? 0);
    $etats = etatFindAll();
    $user = $_SESSION['user'] ?? null;
    
    if ($etatId > 0) {
        $taches = tacheFindByEtat($etatId);
    } else {
        $taches = tacheFindAll();
    }
    
    loadView('taches/dashboard', [
        'user' => $user,
        'taches' => $taches,
        'etats' => $etats,
        'filtreEtat' => $etatId
    ]);
}