<?php
require_once ROOT . '/models/authModel.php';

function authLogin() {
    $errors = [];
    $data = ['email' => '', 'password' => ''];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data['email'] = trim($_POST['email'] ?? '');
        $data['password'] = trim($_POST['password'] ?? '');
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        
        $errors = validations($data, $rules);
        
        if (validate($errors)) {
            $user = userFindByEmail($data['email']);
            
            if ($user && $user['password'] === $data['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email']
                ];
                
                redirectTo('tache', 'dashboard');
                return;
            } else {
                $errors['general'] = 'Email ou mot de passe incorrect';
            }
        }
    }
    
    loadView('auth/login', [
        'errors' => $errors,
        'data' => $data
    ], 'auth');
}

function authRegister() {
    $errors = [];
    $data = ['nom' => '', 'email' => '', 'password' => ''];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data['nom'] = trim($_POST['nom'] ?? '');
        $data['email'] = trim($_POST['email'] ?? '');
        $data['password'] = trim($_POST['password'] ?? '');
        
        $rules = [
            'nom' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ];
        
        $errors = validations($data, $rules);
        
        if (validate($errors) && userEmailExists($data['email'])) {
            $errors['email'] = 'Cet email est déjà utilisé';
        }
        
        if (validate($errors)) {
            $userId = userCreate($data);
            
            if ($userId) {
                redirectTo('auth', 'login');
                return;
            }
        }
    }
    
    loadView('auth/register', [
        'errors' => $errors,
        'data' => $data
    ], 'auth');
}

function authLogout() {
    $_SESSION = [];
    session_destroy();
    redirectTo('auth', 'login');
}