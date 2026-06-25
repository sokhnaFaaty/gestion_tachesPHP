<div class="dashboard">
    <nav class="navbar">
        <div class="nav-brand">
            <i class="fas fa-tasks"></i>
            <span>Modifier la tâche</span>
        </div>
        <div class="nav-user">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?></span>
        </div>
    </nav>
    
    <div class="dashboard-content">
        <div class="header-section">
            <h1><i class="fas fa-edit"></i> Modifier la tâche</h1>
            <a href="<?= WEBROOT ?>?controller=tache&action=dashboard" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
        
        <div class="form-container" style="max-width: 600px; margin: 0 auto;">
            <form method="POST" action="<?= WEBROOT ?>?controller=tache&action=edit&id=<?= $tache['id'] ?>">
                <div class="form-group">
                    <label for="libele">
                        <i class="fas fa-tag"></i> Libellé <span style="color: red;">*</span>
                    </label>
                    <input type="text" id="libele" name="libele" 
                           value="<?= htmlspecialchars($tache['libele'] ?? '') ?>">
                    <?php if (isset($errors['libele'])): ?>
                        <span class="error-text"><i class="fas fa-times-circle"></i> <?= $errors['libele'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="date">
                        <i class="fas fa-calendar-alt"></i> Date <span style="color: red;">*</span>
                    </label>
                    <input type="date" id="date" name="date" 
                           value="<?= $tache['date'] ?? '' ?>">
                    <?php if (isset($errors['date'])): ?>
                        <span class="error-text"><i class="fas fa-times-circle"></i> <?= $errors['date'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="description">
                        <i class="fas fa-file-alt"></i> Description
                    </label>
                    <textarea id="description" name="description" rows="3"><?= htmlspecialchars($tache['description'] ?? '') ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="etat_id">
                        <i class="fas fa-info-circle"></i> Statut
                    </label>
                    <select id="etat_id" name="etat_id">
                        <?php foreach ($etats as $etat): ?>
                            <option value="<?= $etat['id'] ?>" 
                                    <?= ($tache['etat_id'] ?? '') == $etat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($etat['libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>