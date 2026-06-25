-- ============================================
-- GESTION DES TÂCHES - Version simplifiée
-- (Sans user_id - mono-utilisateur)
-- ============================================

-- Supprimer les tables si elles existent
DROP TABLE IF EXISTS taches CASCADE;
DROP TABLE IF EXISTS etats CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- ============================================
-- 1. TABLE DES ÉTATS
-- ============================================
CREATE TABLE etats (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 2. TABLE DES TÂCHES (SANS user_id)
-- ============================================
CREATE TABLE taches (
    id SERIAL PRIMARY KEY,
    libele VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    description TEXT,
    etat_id INTEGER REFERENCES etats(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 3. INSERTION DES DONNÉES
-- ============================================

-- Insertion des états
INSERT INTO etats (libelle, description) VALUES 
    ('A faire', 'Tâche à réaliser'),
    ('En cours', 'Tâche en cours de réalisation'),
    ('Terminé', 'Tâche terminée');

-- Insertion des tâches test (sans user_id)
INSERT INTO taches (libele, date, description, etat_id) 
VALUES 
    (
        'Apprendre PHP', 
        '2025-01-15', 
        'Suivre le cours PHP et faire les exercices', 
        (SELECT id FROM etats WHERE libelle = 'A faire')
    ),
    (
        'Préparer examen', 
        '2025-02-01', 
        'Réviser tous les chapitres', 
        (SELECT id FROM etats WHERE libelle = 'En cours')
    ),
    (
        'Projet final', 
        '2025-03-10', 
        'Développer l\'application selon MVC', 
        (SELECT id FROM etats WHERE libelle = 'Terminé')
    )

