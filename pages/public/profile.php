<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: ../../index.php");
    exit();
}

include_once '../../includes/config/variables.php';
include_once $includesConfig . 'config.php';
include_once $includesConfig . 'functions.php';


$user = getUser($pdo, $_SESSION['user_id']);

switch ($user['poste']) {
    case 0:
        $position = 'Meneur de jeu';
        break;
    case 1:
        $position = 'Arrière';
        break;
    case 2:
        $position = 'Ailier';
        break;
    case 3:
        $position = 'Ailier fort';
        break;
    case 4:
        $position = 'Pivot';
        break;
}

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

?>

<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'profile';
            $modif_success = $_SESSION['modif_success'];
        }
        include_once "navbar/navbar.php";
    ?>
    
    <div class="container-fluid px-0" id="content">        

        <?php 
            if (!is_null($modif_success)) {
                alertMessage("Votre compte a été modifié avec succès !", 0);
                $_SESSION['modif_success'] = null;
            } 
        ?>
        
        <div class="d-flex align-items-center welcome-section mb-3">
            <div class="ms-5 px-5">
                <img class="profile-img" src="../../assets/public/img/morad.png"></img>
            </div>
            
            <div class="me-auto">
                <div>
                    <h3 class="text-white mb-0"><?= $user["prenom"] ?> <?= $user["nom"] ?></h3>
                    <span class="badge bg-dark-subtle my-2">
                        <p class="text-black my-0"><?= $position ?></p>
                    </span>
                </div>
            </div>
            
            <div class="d-flex flex-column m-auto">
                <a href="edit-profile" id="edit-profile" class="btn btn-dark btn-lg m-2 px-5">Edit profile</a>
            </div>
        </div>

        <div class="mb-3" id="profile-stats">
            <div class="d-flex flex-column align-items-center mb-3" role="profile stats header">
                <h1 class="fs-1 fw-bold mb-4">Profile stats</h1>
                <p class="fs-5">Latest perfomance metrics</p>
                <button id="" class="btn btn-dark btn-lg m-2 px-5">View details</button>
            </div>

            <div class="d-flex justify-content-evenly pb-5" role="infos">
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Points Scored</h1>
                    <p class="fs-3 fw-bold mb-1">45</p>
                    <p>+15</p>
                </div>
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Assists</h1>
                    <p class="fs-3 fw-bold mb-1">30</p>
                    <p>+8</p>
                </div>
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Matches Played</h1>
                    <p class="fs-3 fw-bold mb-1">50</p>
                </div>
            </div>

        </div>

        <div class="mb-3" id="tournament-participation">
            <div class="d-flex flex-column align-items-center mb-3" role="tournament participation header">
                <h1 class="fs-1 fw-bold mb-4">Tournament Participation</h1>
                <p class="fs-5">All past tournament experiences</p>
            </div>

            <div class="d-flex flex-wrap justify-content-evenly pb-5" role="tournament tiles container">
                <div class="d-flex border rounded p-3" style="width: 400px;">
                    <div class="pe-2 m-2">
                        <img src="../../assets/public/img/morad.png" alt="tournament thumbnail" style="width: 110px;">
                    </div>
                    <div class="d-flex flex-column">
                        <h1 class="fs-5 mb-0" role="tournament name">TournaBron</h1>
                        <p class="fs-6 fw-bold mb-1" role="tournament date">15/02/2025</p>
                        <p class="m-0" role="description">
                            Reached semi-finals in the 
                            <span class="fst-italic">Warriors</span>
                            team
                        </p>
                        <div class="me-auto">
                            <div>
                                <span class="badge bg-dark-subtle my-2">
                                    <p class="text-black my-0">Semi-finalist</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex border rounded p-3" style="width: 400px;">
                    <div class="pe-2 m-2">
                        <img src="../../assets/public/img/morad.png" alt="tournament thumbnail" style="width: 110px;">
                    </div>
                    <div class="d-flex flex-column">
                        <h1 class="fs-5 mb-0" role="tournament name">Curry Cup</h1>
                        <p class="fs-6 fw-bold mb-1" role="tournament date">24/03/2025</p>
                        <p class="m-0" role="description">
                            Finished last in the 
                            <span class="fst-italic">Warriors</span>
                            team
                        </p>
                        <div class="me-auto">
                            <div>
                                <span class="badge bg-dark-subtle my-2">
                                    <p class="text-black my-0">Good loser</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="teammates-feedback" class="d-flex align-items-center mb-3">
            <div>
                <h1 class="fs-1 fw-bold mb-4">Feedback from teammates</h1>
                <p class="fs-5">What teammates have said about you</p>
            </div>
            
            <div>
                
            </div>
        </div>

        </div>
    </div>
</div>
    
<?php include_once $includesGlobal . "footer.php"; ?>