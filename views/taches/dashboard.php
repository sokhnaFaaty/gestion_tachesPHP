<div class="dashboard">
    <nav class="navbar">
        <div class="nav-brand">
            <i class="fas fa-tasks"></i>
            <span>Gestion de tâches</span>
        </div>
        <!-- <div class="nav-user">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($user['nom'] ?? 'Utilisateur') ?></span>
            <button class="btn btn-logout" style="margin-left: 15px;">
                <a href="<?= WEBROOT ?>?controller=auth&action=logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </button>
        </div> -->
    </nav>

    <div class="dashboard-content">
        <div class="header-section">
            <h1><i class="fas fa-list"></i> Mes tâches</h1>
            <a href="<?= WEBROOT ?>?controller=tache&action=add" class="btn btn-add">
                <i class="fas fa-plus-circle"></i> Ajouter
            </a>
        </div>

        <div class="filter-section">
            <span class="filter-label"><i class="fas fa-filter"></i> Filtrer :</span>
            <a href="<?= WEBROOT ?>?controller=tache&action=dashboard"
               class="filter-btn <?= !isset($filtreEtat) || $filtreEtat == 0 ? 'active' : '' ?>">
                Toutes
            </a>
            <?php foreach ($etats as $etat): ?>
                <a href="<?= WEBROOT ?>?controller=tache&action=filtrerParEtat&etat_id=<?= $etat['id'] ?>"
                   class="filter-btn <?= isset($filtreEtat) && $filtreEtat == $etat['id'] ? 'active' : '' ?>">
                    <?php if ($etat['libelle'] == 'A faire'): ?>
                        <i class="fas fa-clock"></i>
                    <?php elseif ($etat['libelle'] == 'En cours'): ?>
                        <i class="fas fa-sync-alt"></i>
                    <?php elseif ($etat['libelle'] == 'Terminé'): ?>
                        <i class="fas fa-check-circle"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($etat['libelle']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-tag"></i> Libellé</th>
                        <th><i class="fas fa-calendar-alt"></i> Date</th>
                        <th><i class="fas fa-info-circle"></i> Statut</th>
                        <th style="text-align: center;"><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($taches)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #718096;">
                                <i class="fas fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                Aucune tâche
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($taches as $tache): ?>
                            <tr>
                                <td><?= htmlspecialchars($tache['libele']) ?></td>
                                <td><?= $tache['date'] ?></td>
                                <td>
                                    <span class="status-badge">
                                        <?php if (($tache['etat_libelle'] ?? '') == 'A faire'): ?>
                                            <i class="fas fa-clock"></i>
                                        <?php elseif (($tache['etat_libelle'] ?? '') == 'En cours'): ?>
                                            <i class="fas fa-sync-alt"></i>
                                        <?php elseif (($tache['etat_libelle'] ?? '') == 'Terminé'): ?>
                                            <i class="fas fa-check-circle"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($tache['etat_libelle'] ?? 'A faire') ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px; justify-content: center; flex-wrap: wrap;">
                                        <a href="<?= WEBROOT ?>?controller=tache&action=detail&id=<?= $tache['id'] ?>" class="btn btn-detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if (($tache['etat_libelle'] ?? '') != 'Terminé'): ?>
                                            <a href="<?= WEBROOT ?>?controller=tache&action=marquerTerminer&id=<?= $tache['id'] ?>"
                                               class="btn btn-complete"
                                               onclick="return confirm('Terminer cette tâche ?')">
                                                <i class="fas fa-check-double"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= WEBROOT ?>?controller=tache&action=edit&id=<?= $tache['id'] ?>" class="btn btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= WEBROOT ?>?controller=tache&action=delete&id=<?= $tache['id'] ?>"
                                           class="btn btn-delete"
                                           onclick="return confirm('Supprimer cette tâche ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
