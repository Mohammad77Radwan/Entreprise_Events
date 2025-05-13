-- Création de la base de données
CREATE DATABASE IF NOT EXISTS events_db;

USE events_db;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'organizer', 'employee') DEFAULT 'employee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des organisateurs
CREATE TABLE organizers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    department VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des événements
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organizer_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME NOT NULL,
    location VARCHAR(100) NOT NULL,
    max_participants INT,
    status ENUM('planned', 'ongoing', 'completed', 'cancelled') DEFAULT 'planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES organizers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des participants
CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    department VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    participant_id INT NOT NULL,
    reservation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('confirmed', 'pending', 'cancelled', 'waiting_list') DEFAULT 'pending',
    comments TEXT,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES participants(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données de test
-- Admin user
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Organizers
INSERT INTO users (username, email, password, role) VALUES 
('org1', 'org1@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'organizer'),
('org2', 'org2@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'organizer');

INSERT INTO organizers (user_id, first_name, last_name, phone, department) VALUES
(2, 'Jean', 'Dupont', '0123456789', 'RH'),
(3, 'Marie', 'Martin', '0987654321', 'Marketing');

-- Participants
INSERT INTO users (username, email, password, role) VALUES 
('part1', 'part1@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee'),
('part2', 'part2@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee'),
('part3', 'part3@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee');

INSERT INTO participants (user_id, first_name, last_name, email, phone, department) VALUES
(4, 'Pierre', 'Durand', 'pierre.durand@entreprise.com', '0612345678', 'IT'),
(5, 'Sophie', 'Leroy', 'sophie.leroy@entreprise.com', '0698765432', 'Finance'),
(6, 'Thomas', 'Moreau', 'thomas.moreau@entreprise.com', '0678945612', 'Marketing');

-- Events
INSERT INTO events (organizer_id, title, description, start_datetime, end_datetime, location, max_participants, status) VALUES
(1, 'Réunion trimestrielle', 'Réunion pour faire le point sur les objectifs du trimestre', '2025-06-15 09:00:00', '2025-06-15 12:00:00', 'Salle A', 50, 'planned'),
(2, 'Formation PHP avancé', 'Formation sur les concepts avancés de PHP et les bonnes pratiques', '2025-06-20 14:00:00', '2025-06-20 17:00:00', 'Salle B', 20, 'planned'),
(1, 'Team building', 'Activité de team building pour renforcer la cohésion', '2025-07-05 10:00:00', '2025-07-05 18:00:00', 'Parc des Loisirs', 30, 'planned');

-- Reservations
INSERT INTO reservations (event_id, participant_id, status, comments) VALUES
(1, 1, 'confirmed', 'Présent toute la durée'),
(1, 2, 'confirmed', NULL),
(2, 1, 'confirmed', 'Intéressé par les bonnes pratiques'),
(2, 3, 'pending', NULL),
(3, 2, 'confirmed', 'Avec collègues du service');