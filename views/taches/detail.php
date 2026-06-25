<div class="dashboard">
    <nav class="navbar">
        <div class="nav-brand">
            <i class="fas fa-tasks"></i>
            <span>Détail de la tâche</span>
        </div>
        <div class="nav-user">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?></span>
        </div>
    </nav>
    
    <div class="dashboard-content">
        <div class="header-section">
            <h1><i class="fas fa-info-circle"></i> Détail</h1>
            <a href="<?= WEBROOT ?>tache/dashboard" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
        
        <div class="detail-card" style="max-width: 700px; margin: 0 auto; background: #f7fafc; border-radius: 12px; padding: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <h2 style="color: #1a1a2e;"><?= htmlspecialchars($tache['libele']) ?></h2>
                <span class="status-badge" style="font-size: 14px; padding: 6px 16px;">
                    <?php if (($tache['etat_libelle'] ?? '') == 'A faire'): ?>
                        <i class="fas fa-clock"></i>
                    <?php elseif (($tache['etat_libelle'] ?? '') == 'En cours'): ?>
                        <i class="fas fa-spinner fa-spin"></i>
                    <?php elseif (($tache['etat_libelle'] ?? '') == 'Terminé'): ?>
                        <i class="fas fa-check-circle"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($tache['etat_libelle'] ?? 'A faire') ?>
                </span>
            </div>
            
            <hr style="margin: 20px 0; border-color: #e2e8f0;">
            
            <div style="display: grid; gap: 15px;">
                <div>
                    <strong><i class="fas fa-calendar-alt"></i> Date :</strong>
                    <span style="margin-left: 10px;"><?= $tache['date'] ?? 'Non définie' ?></span>
                </div>
                <div>
                    <strong><i class="fas fa-file-alt"></i> Description :</strong>
                    <p style="margin-top: 5px; color: #4a5568;"><?= htmlspecialchars($tache['description'] ?? 'Aucune description') ?></p>
                </div>
                <div>
                    <strong><i class="fas fa-clock"></i> Créé le :</strong>
                    <span style="margin-left: 10px;"><?= $tache['created_at'] ?? 'N/A' ?></span>
                </div>
                <?php if (isset($tache['updated_at']) && $tache['updated_at'] != $tache['created_at']): ?>
                    <div>
                        <strong><i class="fas fa-edit"></i> Modifié le :</strong>
                        <span style="margin-left: 10px;"><?= $tache['updated_at'] ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 25px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="<?= WEBROOT ?>tache/edit?id=<?= $tache['id'] ?>" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <?php if (($tache['etat_libelle'] ?? '') != 'Terminé'): ?>
                    <a href="<?= WEBROOT ?>tache/marquerTerminer?id=<?= $tache['id'] ?>" 
                       class="btn btn-complete" 
                       onclick="return confirm('Terminer cette tâche ?')">
                        <i class="fas fa-check-double"></i> Terminer
                    </a>
                <?php endif; ?>
                <a href="<?= WEBROOT ?>tache/delete?id=<?= $tache['id'] ?>" 
                   class="btn btn-delete" 
                   onclick="return confirm('Supprimer cette tâche ?')">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </a>
            </div>
        </div>
    </div>
</div>