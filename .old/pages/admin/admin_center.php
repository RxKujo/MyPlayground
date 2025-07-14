<?php include_once "../../includes/admin/header.php"; ?>

<div class="d-flex">
    <nav class="bg-dark text-white p-3" style="width: 280px; min-height: 100vh;">
        <h4>Admin Dashboard</h4>
        <ul id="sidebar-list" class="nav nav-pills flex-column">
            <li class="nav-item"><a class="nav-link active text-white" href="#" data-page="dashboard">🏠 Dashboard</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" data-page="users">👤 Users</a></li>
            <li class=
            <li class="nav-item"><a class="nav-link text-white" href="#" data-page="settings">⚙ Settings</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" data-page="disconnect">🚪 Disconnect</a></li>
        </ul>
    </nav>
    
    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
    </div>
</div>

<?php include_once "../../includes/global/footer.php"; ?>
