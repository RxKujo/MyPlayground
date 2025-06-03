    <?php

include_once '../../includes/global/session.php';

    if (!isset($_SESSION['user_id'])) {
        header("location: ../../index.php");
        exit();
    }

include_once $includesConfig . 'config.php';


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
                
                if (isset($_SESSION['modif_success'])) {
                    $modif_success = $_SESSION['modif_success'];
                } else {
                    $modif_success = null;
                }
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
                <!-- Avatar cliquable centré -->
                <div class="d-flex justify-content-center">
                    <form id="upload-form" action="upload-avatar.php" method="POST" enctype="multipart/form-data">
                        <div id="pfp" class="position-relative profile-img-wrapper" style="cursor: pointer; width: 150px; height: 150px;">
                            <img src="<?= htmlspecialchars($user['avatar'] ?? '../../assets/public/img/morad.png') ?>" class="w-100 h-100 rounded-circle" style="object-fit: cover;" id="avatar-preview">
                            <div class="overlay-icon d-flex justify-content-center align-items-center">
                                <?= $pen ?>
                            </div>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
                        </div>
                    </form>
                </div>

                <!-- Overlay de création d'avatar (masqué par défaut) -->
                <div id="avatar-builder-overlay" class="overlay-fullscreen" style="display: none;">
                    <div class="back builder-box text-center">
                        <h1 class="mb-4">Créer ton avatar</h1>

                        <canvas id="avatarCanvas" width="200" height="200" class="mb-4"></canvas>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button class="arrow-btn" onclick="prevPart('eyes')">&lt;</button>
                                <span>Yeux</span>
                                <button class="arrow-btn" onclick="nextPart('eyes')">&gt;</button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button class="arrow-btn" onclick="prevPart('nose')">&lt;</button>
                                <span>Nez</span>
                                <button class="arrow-btn" onclick="nextPart('nose')">&gt;</button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button class="arrow-btn" onclick="prevPart('mouth')">&lt;</button>
                                <span>Bouche</span>
                                <button class="arrow-btn" onclick="nextPart('mouth')">&gt;</button>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-success me-2 px-4 py-2" onclick="saveAvatar()">Enregistrer Avatar</button>
                            <button class="btn btn-secondary px-3 py-2" onclick="hideAvatarBuilder()">Annuler</button>
                        </div>
                        <div id="resultMessage" class="mt-3 text-center"></div>
                    </div>
                </div>

                <!-- Styles CSS -->
                <style>
                    .overlay-fullscreen {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                        background-color: rgba(33, 37, 41, 0.95); /* fond sombre */
                        z-index: 9999;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    .builder-box {
                        background-color: #343a40;
                        color: white;
                        font-family: monospace;
                        padding: 30px;
                        border-radius: 12px;
                        max-width: 400px;
                        width: 100%;
                    }

                    .arrow-btn {
                        background: none;
                        border: none;
                        font-size: 2rem;
                        color: white;
                        cursor: pointer;
                    }

                    canvas {
                        background-color: white;
                        border: 2px solid black;
                        image-rendering: pixelated;
                    }

                    .overlay-icon {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        opacity: 0;
                        transition: opacity 0.3s;
                    }

                    .profile-img-wrapper:hover .overlay-icon {
                        opacity: 1;
                        background-color: rgba(0, 0, 0, 0.5);
                    }
                
                </style>

                <!-- JS -->
                <script>
                    document.getElementById('pfp').addEventListener('click', function () {
                        document.getElementById('avatar-builder-overlay').style.display = 'flex';
                    });

                    function hideAvatarBuilder() {
                        document.getElementById('avatar-builder-overlay').style.display = 'none';
                    }
                </script>

                <!-- Lien vers le JS du builder -->
                <script src="avatar-builder.js"></script>


                
                <div class="me-auto">
                    <div>
                        <h3 class="text-white mb-0"><?= $user["prenom"] ?> <?= $user["nom"] ?></h3>
                        <span class="badge bg-dark-subtle my-2">
                            <p class="text-black my-0"><?= $position ?></p>
                        </span>
                    </div>
                </div>
                
                <div class="d-flex flex-column m-auto">
                    <a href="edit-profile" id="edit-profile" class="btn btn-dark btn-lg m-2 px-5">Modifier le profil</a>
                </div>
            </div>

            <div class="mb-3" id="profile-stats">
                <div class="d-flex flex-column align-items-center mb-3" role="profile stats header">
                    <h1 class="fs-1 fw-bold mb-4">Vos statistiques</h1>
                    <p class="fs-5">Revue des dernières performances</p>
                    <button id="" class="btn btn-dark btn-lg m-2 px-5">Voir les détails</button>
                </div>

                <div class="d-flex justify-content-evenly pb-5" role="infos">
                    <div class="border rounded p-3" style="width: 400px;">
                        <h1 class="fs-5 text-body-tertiary">Points marqués</h1>
                        <p class="fs-3 fw-bold mb-1">45</p>
                        <p>+15</p>
                    </div>
                    <div class="border rounded p-3" style="width: 400px;">
                        <h1 class="fs-5 text-body-tertiary">Assistances</h1>
                        <p class="fs-3 fw-bold mb-1">30</p>
                        <p>+8</p>
                    </div>
                    <div class="border rounded p-3" style="width: 400px;">
                        <h1 class="fs-5 text-body-tertiary">Matchs jouer</h1>
                        <p class="fs-3 fw-bold mb-1">50</p>
                    </div>
                </div>

            </div>

            <div class="mb-3" id="tournament-participation">
                <div class="d-flex flex-column align-items-center mb-3" role="tournament participation header">
                    <h1 class="fs-1 fw-bold mb-4">Participation aux Tournois</h1>
                    <p class="fs-5">Dernière participation aux tournois</p>
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
                    <h1 class="fs-1 fw-bold mb-4">Retour de vos coéquipiers</h1>
                    <p class="fs-5">Ce que vos coéquipiers on dit à propos de vous </p>
                </div>
                
                <div>
                    
                </div>
            </div>

            </div>
        </div>
    </div>
        
    <?php include_once $includesGlobal . "footer.php"; ?>