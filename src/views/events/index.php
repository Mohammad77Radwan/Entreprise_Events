<?php include 'views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Gestion des Événements</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Liste des Événements</h5>
<?php
    $role = $_SESSION['user_role'] ?? null;
    if ($role === ROLE_ORGANIZER || $role === ROLE_ADMIN): ?>
                    <a href="<?= BASE_URL; ?>/event/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer un événement
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="<?= BASE_URL; ?>/event/search" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Titre" value="<?= htmlspecialchars($_GET['title'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="location" class="form-control" placeholder="Lieu" value="<?= htmlspecialchars($_GET['location'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Tous les statuts</option>
                            <option value="planned" <?= (($_GET['status'] ?? '') === 'planned' ? 'selected' : ''); ?>>Planifié</option>
                            <option value="ongoing" <?= (($_GET['status'] ?? '') === 'ongoing' ? 'selected' : ''); ?>>En cours</option>
                            <option value="completed" <?= (($_GET['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Terminé</option>
                            <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" placeholder="Date début" value="<?= htmlspecialchars($_GET['start_date'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="end_date" class="form-control" placeholder="Date fin" value="<?= htmlspecialchars($_GET['end_date'] ?? ''); ?>">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Organisateur</th>
                            <th>Date et Heure</th>
                            <th>Lieu</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= htmlspecialchars($event['title']); ?></td>
                                <td><?= htmlspecialchars($event['organizer_first_name'] . ' ' . $event['organizer_last_name']); ?></td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($event['start_datetime'])); ?> - 
                                    <?= date('H:i', strtotime($event['end_datetime'])); ?>
                                </td>
                                <td><?= htmlspecialchars($event['location']); ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $event['status'] === 'planned' ? 'bg-primary' : ''; ?>
                                        <?= $event['status'] === 'ongoing' ? 'bg-warning text-dark' : ''; ?>
                                        <?= $event['status'] === 'completed' ? 'bg-success' : ''; ?>
                                        <?= $event['status'] === 'cancelled' ? 'bg-danger' : ''; ?>">
                                        <?= ucfirst($event['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
<?php
    $role = $_SESSION['user_role'] ?? null;
    if ($role === ROLE_ORGANIZER || $role === ROLE_ADMIN): ?>
                                        <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>/edit" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= BASE_URL; ?>/event/<?= $event['id']; ?>/delete" method="POST" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>