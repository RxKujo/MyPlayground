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
            <li class="nav-item"><a class="nav-link active text-black" href="#">🏠 Home</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">🏀 Find Partners</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">🏆 Tournaments</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">👤 Profile</a></li>
            <li class="nav-item"><a class="nav-link text-black" href="#">⚙️ Settings</a></li>
        </ul>
    </nav>
    
    
    <div class="container-fluid px-0">
        <div class="d-flex align-items-center welcome-section">
            <div class="ms-5 px-5">
                <img class="profile-img" src="assets/public/img/morad.png"></img>
            </div>

            <div class="me-auto">
                <div>
                    <h3 class="text-white mb-0">Welcome, User!</h3>
                    <span class="badge bg-dark-subtle my-2">
                        <p class="text-black my-0">Pick up games near you</p>
                    </span>
                    <span class="badge bg-dark-subtle my-2">
                        <p class="text-black my-0">NEW Tournaments</p>
                    </span>
                </div>
            </div>

            <div class="d-flex flex-column m-auto">
                <button class="btn btn-dark m-2">Join Tournament</button>
                <button class="btn btn-outline-light m-2">Find Partners</button>
            </div>
        </div>


        <div class="d-flex mt-4">
            <div class="d-flex align-items-center mx-5 search-partners-section">
                <div class="d-flex align-items-center flex-column">
                    <h3 class="fs-2 fw-bold">Search for Partners</h3>
                    <p>Select player level, position, and type of request</p>
                </div>
            </div>

            <div class="d-flex flex-column align-items-start mx-5">
                <div class="my-3 me-5">
                    <h4>Player level</h4>
                    <span>
                        <button class="btn btn-outline-dark">Beginner</button>
                        <button class="btn btn-outline-dark">Intermediate</button>
                        <button class="btn btn-outline-dark">Advanced</button>
                    </span>
                </div>
                <div class="my-3">
                    <h4>Position</h4>
                    <div>
                        <button class="btn btn-outline-dark">Point Guard</button>
                        <button class="btn btn-outline-dark">Winger</button>
                        <button class="btn btn-outline-dark">Pivot</button>
                        <button class="btn btn-outline-dark">Others</button>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly mt-5 mx-auto">
                    <button class="btn btn-secondary">Clear</button>
                    <button class="btn btn-dark">Search</button>
                </div>
            </div>
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

<?php include_once "includes/global/footer.php"; ?>
