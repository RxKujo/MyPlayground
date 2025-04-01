<?php include_once "../../includes/admin/header.php"; ?>

<div class="d-flex">
    <nav class="bg-dark text-white p-3" style="width: 280px; min-height: 100vh;">
        <h4>Admin Dashboard</h4>
        <ul id="sidebar-list" class="nav nav-pills flex-column">
            <li class="nav-item"><a class="nav-link active text-white" href="#" onclick="loadContent('dashboard')">🏠 Tableau de Bord</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" onclick="loadContent('users')">👤 Utilisateurs</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" onclick="loadContent('settings')">⚙ Paramètres</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">🚪 Déconnexion</a></li>
        </ul>
    </nav>
    
    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
    </div>
</div>

<?php include_once "../../includes/global/footer.php"; ?>
