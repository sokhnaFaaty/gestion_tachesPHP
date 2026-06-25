<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-user-plus auth-icon"></i>
            <h1>Inscription</h1>
            <p>Créez votre compte pour gérer vos tâches</p>
        </div>
        
        <form method="POST" action="<?= WEBROOT ?>auth/register">
            <div class="form-group">
                <label for="nom">
                    <i class="fas fa-user"></i> Nom
                </label>
                <input type="text" id="nom" name="nom" 
                       placeholder="Votre nom" 
                       value="<?= htmlspecialchars($data['nom'] ?? '') ?>">
                <?php if (isset($errors['nom'])): ?>
                    <span class="error-text"><i class="fas fa-times-circle"></i> <?= $errors['nom'] ?></span>
                <?php endif; ?>
            </div>
            
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
                <i class="fas fa-user-check"></i> S'inscrire
            </button>
        </form>
        
        <div class="auth-footer">
            Déjà un compte ? 
            <a href="<?= WEBROOT ?>auth/login">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        </div>
    </div>
</div>