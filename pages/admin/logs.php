<?php

include_once '../../includes/global/session.php';

include_once $includesAdmin . 'header.php';
?>


<link rel="stylesheet" href="/assets/admin/css/style.css">

<div class="d-flex flex-column flex-md-row">
    <?php include_once 'navbar/navbar.php'; ?>
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
                <tbody id="logsShowing">
                
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="/assets/admin/js/dynamicLogs.js"></script>
<?php include_once $includesGlobal . 'footer.php'; ?>
