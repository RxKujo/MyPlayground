<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $root . "/includes/config/variables.php";

include_once $includesConfig . "config.php";
include_once $includesConfig . "functions.php";

include_once $includesPublic . "header.php";

include_once "navbar/header.html";
?>

<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>    

    <div class="container-fluid px-0" id="content">
        
        <?php
            if (!isset($_SESSION['user_id'])) {
                header("location: ../../index.php");
                exit();
            }

            $user = getUser($pdo, $_SESSION['user_id']);
        ?>

        <div class="d-flex align-items-center welcome-section">
            <div class="ms-5 px-5">
                <img class="profile-img" src="../../assets/public/img/morad.png"></img>
            </div>

            <div class="me-auto">
                <div>
                    <h3 class="text-white mb-0">Welcome, <?= $user["prenom"] ?>!</h3>
                    <span class="badge bg-dark-subtle my-2">
                        <p class="text-black my-0">Pick up games near you</p>
                    </span>
                    <span class="badge bg-dark-subtle my-2">
                        <p class="text-black my-0">NEW Tournaments</p>
                    </span>
                </div>
            </div>
            
            <div class="d-flex flex-column m-auto">
                <a href="partners" id="find-button" class="btn btn-outline-light m-2">Find Partners</a>
                <a href="tournaments" id="tournament-button" class="btn btn-dark m-2">Join Tournament</a>
            </div>
        </div>


        <div class="d-flex mt-4 mx-auto">
            <div class="d-flex align-items-center mx-5 search-partners-section">
                <div class="d-flex align-items-center flex-column">
                    <h3 class="fs-2 fw-bold">Search for Partners</h3>
                    <p>Select player level, position, and type of request</p>
                </div>
            </div>

            <div id="search-filters" class="d-flex flex-column align-items-start mx-5">
                <div class="my-3 me-5">
                    <h4>Player level</h4>
                    <span class="d-inline-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="beginner">Beginner</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="intermediate">Intermediate</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="advanced">Advanced</button>
                    </span>
                </div>
                <div class="my-3">
                    <h4>Position</h4>
                    <div class="d-inline-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="PG">Point Guard</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="SG">Shooting Guard</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="SF">Small Forward</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="PF">Power Forward</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="C">Center</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="NA">Any</button>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly mt-5 mx-auto">
                    <button id="clear-button" class="btn btn-dark me-5 px-xl py-2">Clear</button>
                    <button id="search-button" class="btn btn-outline-dark ms-5 px-xl py-2">Search</button>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex flex-column align-items-center mx-5">
                <h3 class="fs-2 fw-bold">Recommended Partners</h3>
                <div class="d-flex justify-content-evenly mx-auto">
                    <button class="btn btn-dark me-5 px-4 py-2">View Profile</button>
                    <button class="btn btn-outline-dark ms-5 px-5 py-2">Invite</button>
                </div>
            </div>
            <div class="d-flex gap-4 recommended-profiles">
                <div class="text-center">
                    <img src="" alt="John">
                    <p>John<br><small>Point Guard</small></p>
                </div>
                <div class="text-center">
                    <img src="" alt="Sarah">
                    <p>Sarah<br><small>Winger</small></p>
                </div>
                <div class="text-center">
                    <img src="" alt="Mike">
                    <p>Mike<br><small>Pivot</small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
