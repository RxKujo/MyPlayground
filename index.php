<?php include_once "includes/public/header.php"; ?>

<header class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <img src="logo.png" alt="Logo" class="logo">
        <a class="navbar-brand" href="#">Basketball Platform</a>
        <h1 class="text-center">My PlayGround</h1>
    </div>
</header>


<div class="d-flex">
    <nav class="bg-light text-black p-3" style="width: 280px; min-height: 100vh;">
        <h4>My PlayGround</h4>
        <ul id="sidebar-list" class="nav nav-pills flex-column">
            <li class="nav-item"><a class="nav-link active text-black" href="#">🏠 Home</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">🏀 Find Partners</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">🏆 Tournaments</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">👤 Profile</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">⚙️ Settings</a></li>
        </ul>
    </nav>
    
    
    <div class="container-fluid px-0">
        <div class="d-flex align-items-center welcome-bg-col p-3">
            <div class="profile-img me-3">👤</div>
            <div>
                <h3>Welcome, User!</h3>
                <button class="btn btn-dark">Join Tournament</button>
                <button class="btn btn-outline-light">Find Partners</button>
            </div>
        </div>


        <div class="mt-4">
            <h3>Search for Partners</h3>
            <p>Select player level, position, and type of request</p>
            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-outline-dark">Beginner</button>
                <button class="btn btn-outline-dark">Intermediate</button>
                <button class="btn btn-outline-dark">Advanced</button>
            </div>
            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-outline-dark">Point Guard</button>
                <button class="btn btn-outline-dark">Winger</button>
                <button class="btn btn-outline-dark">Pivot</button>
                <button class="btn btn-outline-dark">Others</button>
            </div>
            <input type="text" class="form-control mb-3" placeholder="Enter your request here">
            <button class="btn btn-secondary">Clear</button>
            <button class="btn btn-dark">Search</button>
    </div>
        <div class="mt-4">
            <h3>Recommended Partners</h3>
            <div class="d-flex gap-4 recommended-profiles">
                <div class="text-center">
                    <img src="basketball.png" alt="John">
                    <p>John<br><small>Point Guard</small></p>
                </div>
                <div class="text-center">
                    <img src="basketball.png" alt="Sarah">
                    <p>Sarah<br><small>Winger</small></p>
                </div>
                <div class="text-center">
                    <img src="basketball.png" alt="Mike">
                    <p>Mike<br><small>Pivot</small></p>
                </div>
            </div>
            <button class="btn btn-outline-dark">View Profile</button>
            <button class="btn btn-dark">Invite</button>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-4">
    <div>
        <p>© 2025 Basketball Platform. All rights reserved.</p>
        <div class="d-flex justify-content-center gap-4">
            <a href="#" class="text-white">Privacy Policy</a>
            <a href="#" class="text-white">Terms of Service</a>
            <a href="#" class="text-white">Contact Us</a>
        </div>
    </div>
</footer>

<?php include_once "includes/public/footer.php"; ?>
