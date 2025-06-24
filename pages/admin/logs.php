<?php
session_start();
require_once __DIR__ . '/../../includes/config/config.php';
require_once __DIR__ . '/../../includes/config/functions.php';

$stmt = $pdo->query("
    SELECT logs.*, utilisateur.pseudo
    FROM logs
    LEFT JOIN utilisateur ON utilisateur.id = logs.user_id
    ORDER BY logs.created_at DESC
");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once '../../includes/admin/header.php';
?>


<link rel="stylesheet" href="/assets/admin/css/style.css">

<div class="d-flex flex-column flex-md-row">
    <?php include_once(__DIR__ . '/navbar/navbar.php'); ?>
    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2 class="mb-4 text-center">Historique des connexions et actions</h2>

        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Script</th>
                        <th>IP</th>
                        <th>Statut</th>
                        <th>Référent</th>
                        <th>URI</th>
                        <th>Méthode</th>
                        <th>Protocole</th>
                        <th>Agent</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['created_at']) ?></td>
                        <td><?= htmlspecialchars($log['pseudo'] ?? 'Anonyme') ?></td>
                        <td><?= htmlspecialchars($log['script_name']) ?></td>
                        <td><?= htmlspecialchars($log['ip']) ?></td>
                        <td><?= htmlspecialchars($log['status']) ?></td>
                        <td><?= htmlspecialchars($log['http_referer']) ?></td>
                        <td><?= htmlspecialchars($log['request_uri']) ?></td>
                        <td><?= htmlspecialchars($log['request_method']) ?></td>
                        <td><?= htmlspecialchars($log['server_protocol']) ?></td>
                        <td class="truncate-cell"><?= htmlspecialchars($log['http_user_agent']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../../includes/global/footer.php'; ?>
