<?php include_once "includes/public/header.php"; ?>

<header class="navbar navbar-dark bg-dark py-0 my-0">
    <div class="container-fluid">
        <a class="navbar-brand pb-0" href="#">
            <img src="assets/public/img/logo.png" alt="Logo" class="logo d-inline-block align-text-center">
            <span class="logo-text" style="font-size: 28px;">My PlayGround</span>
        </a>
    </div>
</header>


<div class="d-flex">
    <nav class="bg-light text-black p-3" style="width: 280px; min-height: 100vh;">
        <ul id="sidebar-list" class="nav nav-pills flex-column">
            <li class="nav-item"><a class="nav-link active text-black" href="#" data-page="home" onclick="loadContent('home')">🏠 Home</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" onclick="loadContent('partners')">🏀 Find Partners</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" onclick="loadContent('home')">🏆 Tournaments</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" onclick="loadContent('profile')">👤 Profile</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" onclick="loadContent('settings')">⚙️ Settings</a></li>
        </ul>
    </nav>
    
    
    <div class="container-fluid px-0" id="content">
    </div>
</div>

<?php include_once "includes/global/footer.php"; ?>
