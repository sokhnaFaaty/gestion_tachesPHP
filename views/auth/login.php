<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-tasks auth-icon"></i>
            <h1>Connexion</h1>
            <p>Entrez vos identifiants pour accéder à votre espace</p>
        </div>
        
        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= $errors['general'] ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= WEBROOT ?>auth/login">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" id="email" name="email" 
                       placeholder="exemple@gmail.com" 
                       value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                <?php if (isset($errors['email'])): ?>
                    <span class="error-text"><i class="fas fa-times-circle"></i> <?= $errors['email'] ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-key"></i> Mot de passe
                </label>
                <input type="password" id="password" name="password" placeholder="••••••••">
                <?php if (isset($errors['password'])): ?>
                    <span class="error-text"><i class="fas fa-times-circle"></i> <?= $errors['password'] ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <div class="auth-footer">
            Pas encore de compte ? 
            <a href="<?= WEBROOT ?>auth/register">
                <i class="fas fa-user-plus"></i> Créer un compte
            </a>
        </div>
    </div>
</div>