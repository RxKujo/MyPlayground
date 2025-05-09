<?php 

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $root . "/includes/config/config.php";
include_once $root . "/includes/public/header.php";
?>

<header class="navbar navbar-dark bg-dark py-0 my-0">
    <div class="container-fluid">
        <a id="nav-logo" class="navbar-brand pb-0" href="index.php" data-page="home">
            <img 
                src="assets/public/img/logo.png"
                alt="Logo"
                class="logo d-inline-block align-text-center"
                >
            <span class="logo-text" style="font-size: 28px;">My PlayGround</span>
        </a>
    </div>
</header>


<div class="d-flex">
    <nav class="bg-light text-black p-3" style="width: 280px; min-height: 100vh;">
        <ul id="sidebar-list" class="nav nav-pills flex-column">
            <li class="nav-item"><a class="nav-link text-black" href="#" data-page="home">🏠 Home</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" data-page="partners">🏀 Find Partners</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" data-page="tournaments">🏆 Tournaments</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#" data-page="profile">👤 Profile</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="pages/public/settings.php" data-page="settings">⚙️ Settings</a></li>
        </ul>
    </nav>
    
    
    <div class="container-fluid px-0" id="content">
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
