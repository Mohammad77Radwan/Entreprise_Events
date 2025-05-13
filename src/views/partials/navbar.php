<?php if (!defined('BASE_URL')) {
    define('BASE_URL', '/'); // fallback if BASE_URL is not defined
} ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL; ?>/home">Gestion Événements</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL; ?>/event">Événements</a>
                </li>
                <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === ROLE_ORGANIZER || $_SESSION['user_role'] === ROLE_ADMIN)): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL; ?>/organizers">Organisateurs</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === ROLE_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL; ?>/participants">Participants</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> <?= htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= BASE_URL; ?>/profile">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL; ?>/auth/logout">
                                    <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL; ?>/auth/login">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL; ?>/auth/register">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
