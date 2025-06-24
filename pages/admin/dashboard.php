<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once $includesAdmin . "header.php";

?>

<div class="d-flex">
    <?php
    include_once "navbar/navbar.php";
    ?>

    <div class="container py-5">
        <h1 class="mb-4">Gestion des utilisateurs</h1>

        <!-- Statistiques -->
        <div class="row g-3 mb-4" id="statCards">
            <div class="col-md-3">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <h6>Total</h6>
                        <p id="totalUsers" class="fs-4 mb-0">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-success">
                    <div class="card-body">
                        <h6>Admins</h6>
                        <p id="adminUsers" class="fs-4 mb-0">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-warning">
                    <div class="card-body">
                        <h6>En ligne</h6>
                        <p id="onlineUsers" class="fs-4 mb-0">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-danger">
                    <div class="card-body">
                        <h6>Non vérifiés</h6>
                        <p id="unverifiedUsers" class="fs-4 mb-0">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Chart (Rôles) -->
        <h5>Utilisateurs par rôle</h5>

        <div class="d-flex align-items-end mt-4">
            <div class="text-end me-2" style="height: 200px; display: flex; flex-direction: column; justify-content: space-between;">
                <div id="graphMaxLabel" style="font-size: 0.9rem;">11</div>
                <div style="font-size: 0.9rem;">0</div>
            </div>
            <div class="bar-container" id="roleChartBars"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <div class="bar-label">Joueur</div>
            <div class="bar-label">Arbitre</div>
            <div class="bar-label">Organisateur</div>
            <div class="bar-label">Spectateur</div>
        </div>


        <!-- Tableau -->
        <div class="table-responsive mt-5">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pseudo</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Admin</th>
                        <th>En ligne</th>
                        <th>Vérifié</th>
                    </tr>
                </thead>
                <tbody id="userTable"></tbody>
            </table>
        </div>
    </div>

    <script>
        function getUserRole(role) {
            return ['Joueur', 'Arbitre', 'Organisateur', 'Spectateur'][parseInt(role)] || 'Inconnu';
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const response = await fetch('/api/users/');
            const data = await response.json();
            const users = data.users || data;

            let adminCount = 0;
            let onlineCount = 0;
            let notVerifiedCount = 0;
            const roleCounts = [0, 0, 0, 0];

            const tbody = document.getElementById('userTable');
            users.forEach(user => {
                const tr = document.createElement('tr');

                if (user.droits == 1) adminCount++;
                if (user.is_online == 1) onlineCount++;
                if (user.is_verified == 0) notVerifiedCount++;
                if (user.role >= 0 && user.role <= 3) roleCounts[user.role]++;

                tr.innerHTML = `
          <td>${user.pseudo}</td>
          <td>${user.nom}</td>
          <td>${user.email}</td>
          <td>${getUserRole(user.role)}</td>
          <td><span class="badge bg-${user.droits == 1 ? 'success' : 'secondary'}">${user.droits == 1 ? 'Oui' : 'Non'}</span></td>
          <td><span class="badge bg-${user.is_online == 1 ? 'success' : 'danger'}">${user.is_online == 1 ? '🟢 En ligne' : '🔴 Hors ligne'}</span></td>
          <td><span class="badge bg-${user.is_verified == 1 ? 'success' : 'warning'}">${user.is_verified == 1 ? 'Oui' : 'Non'}</span></td>
        `;
                tbody.appendChild(tr);
            });

            document.getElementById('totalUsers').textContent = users.length;
            document.getElementById('adminUsers').textContent = adminCount;
            document.getElementById('onlineUsers').textContent = onlineCount;
            document.getElementById('unverifiedUsers').textContent = notVerifiedCount;

            // Custom Chart
            const chart = document.getElementById('roleChartBars');
            
            const maxCount = Math.max(...roleCounts) || 1;
            roleCounts.forEach((count, index) => {
                const div = document.createElement('div');
                div.className = 'bar';
                div.style.height = `${(count / maxCount) * 100}%`;
                div.title = `${count} utilisateur(s)`;
                div.style.backgroundColor = ['#0d6efd', '#198754', '#ffc107', '#6c757d'][index];
                chart.appendChild(div);
            });
            console.log("roleCounts =", roleCounts);
            console.log("maxCount =", maxCount);
            console.log("Bar container =", chart);
        });
        </script>
</div>

<?php include_once "../../includes/global/footer.php"; ?>