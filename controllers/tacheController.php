<?php

require_once ROOT . '/models/TacheModel.php';
require_once ROOT . '/models/EtatModel.php';

class TacheController {

    private TacheModel $tacheModel;
    private EtatModel $etatModel;

    public function __construct() {
        $this->tacheModel = new TacheModel();
        $this->etatModel = new EtatModel();
    }

    public function dashboard(): void {
        $taches = $this->tacheModel->findAll();
        $etats = $this->etatModel->findAll();

        loadView('taches/dashboard', [
            'taches' => $taches,
            'etats' => $etats
        ]);
    }

    // AJOUTER UNE TÂCHE
    public function add(): void {
        $errors = [];
        $tache = ['libele' => '', 'date' => '', 'description' => '', 'etat_id' => ''];
        $etats = $this->etatModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $id = $this->tacheModel->create([
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

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $tache = $this->tacheModel->findById($id);

        if (!$tache) {
            redirectTo('tache', 'dashboard');
            return;
        }

        $etats = $this->etatModel->findAll();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                if ($this->tacheModel->update($id, $updateData)) {
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
    public function detail(): void {
        $id = (int)($_GET['id'] ?? 0);
        $tache = $this->tacheModel->findById($id);

        if (!$tache) {
            redirectTo('tache', 'dashboard');
            return;
        }

        loadView('taches/detail', [
            'tache' => $tache
        ]);
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->tacheModel->delete($id);
        }

        redirectTo('tache', 'dashboard');
    }

    // Marquer comme "Terminé"
    public function marquerTerminer(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->tacheModel->setTermine($id);
        }

        redirectTo('tache', 'dashboard');
    }

    // Marquer comme "En cours"
    public function marquerEnCours(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->tacheModel->setEnCours($id);
        }

        redirectTo('tache', 'dashboard');
    }

    // FILTRER PAR ÉTAT
    public function filtrerParEtat(): void {
        $etatId = (int)($_GET['etat_id'] ?? 0);
        $etats = $this->etatModel->findAll();

        if ($etatId > 0) {
            $taches = $this->tacheModel->findByEtat($etatId);
        } else {
            $taches = $this->tacheModel->findAll();
        }

        loadView('taches/dashboard', [
            'taches' => $taches,
            'etats' => $etats,
            'filtreEtat' => $etatId
        ]);
    }
}