<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("/");

$user = $_SESSION['user_info'];

$position = getUserPosition($user);
$niveau = getUserLevel($user);

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
                <div class="d-flex justify-content-center">
                    <form id="upload-form" action="upload-avatar.php" method="POST" enctype="multipart/form-data">
                        <div id="pfp" class="position-relative profile-img-wrapper" style="cursor: pointer; width: 150px; height: 150px;">
                            <img src="<?= showPfp($pdo, $user) ?>" class="w-100 h-100 rounded-circle" style="object-fit: cover;" id="avatar-preview">

                            <div class="overlay-icon d-flex justify-content-center align-items-center">
                                <?= $pen ?>
                            </div>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
                        </div>
                    </form>
                </div>

                <div id="avatar-builder-overlay" class="overlay-fullscreen" style="display: none;">
                    <div class="back builder-box text-center">
                        <h1 class="mb-4">Créer ton avatar</h1>

                        <canvas id="avatarCanvas" width="200" height="200" class="mb-4"></canvas>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button class="arrow-btn" onclick="prevPart('hair')">&lt;</button>
                                <span>Cheveux</span>
                                <button class="arrow-btn" onclick="nextPart('hair')">&gt;</button>
                            </div>
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

      
                <style>
                    .overlay-fullscreen {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                        background-color: rgba(33, 37, 41, 0.95);
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

              
                <script>
                    document.getElementById('pfp').addEventListener('click', function () {
                        document.getElementById('avatar-builder-overlay').style.display = 'flex';
                    });

                    function hideAvatarBuilder() {
                        document.getElementById('avatar-builder-overlay').style.display = 'none';
                    }
                </script>



                
                <div class="me-auto">
                    <div>
                        <h3 class="text-white mb-0"><?= $user["prenom"] ?> <?= $user["nom"] ?></h3>
                        <span class="badge bg-dark-subtle my-2">
                            <p class="text-black my-0"><?= $position ?></p>
                        </span>
                        <span class="badge bg-dark-subtle my-2">
                            <p class="text-black my-0"><?= $niveau ?></p>
                        </span>
                    </div>
                </div>
                
                <div class="d-flex flex-column m-auto">
                    <a href="edit-profile" id="edit-profile" class="btn btn-dark btn-lg m-2 px-5">Modifier le profil</a>
                </div>
            </div>
            
            
            <div id="teammates-feedback" class="d-flex align-items-center mb-3">
                <div>
                    
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="/assets/public/js/avatar-builder.js"></script>
    
    <?php include_once $includesGlobal . "footer.php"; ?>