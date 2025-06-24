<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];

include_once $includesPublic . 'header.php';
?>

<?php
    include_once $assetsShared . 'icons/icons.php';
    include_once 'navbar/header.php';
?>
<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'tournaments';
        } else {
            header('location: index.php');
        }
        include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid px-0" id="content">        
        <div id="carousel" class="carousel slide px-5 py-3" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
           
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="bg-black" style="--bs-bg-opacity: .5;">
            <h1 class="fs-1 fw-bold text-center text-white py-3">Tournois à venir</h1>
            <p class="fs-5 text-center text-white">Gardez une longueur d’avance en participant à ces tournois passionnants</p>
            
            <div class="input-group mb-3 mx-auto pt-3 pb-4 w-25">
                <input type="text" class="form-control" id="search-tourney-input" placeholder="Rechercher un tournoi">
            </div>

            <div class="d-flex flex-column align-items-center mx-auto mb-5 pb-5">
                <button id="tournament-button" class="btn btn-dark btn-lg">
                    <span class="px-3">Voir tous les tournois</span>
                </button>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mx-auto mb-4">
            <a href="create_tournament" class="btn btn-primary btn-lg">
                Créer un tournoi
            </a>
        </div>

        <div id="reviews" class="d-flex flex-row">
            <div class="p-5 m-5">
                <img src="../../assets/public/img/morad.png" alt="picture">
            </div>

            <div class="m-5">
                <h1 class="fs-1 fw-bold">Revues des joueurs</h1>
                <p class="fs-5">Découvrer ce que les joueurs disent à propos de vos tournois</p>
                <div>
                    <div class="d-flex">
                        <a href="#" class="d-flex align-items-center text-decoration-none text-dark">
                            <div role="img">
                                <img class="profile-img-small" src="../../assets/public/img/morad.png" alt="picture">
                            </div>
                            <div class="p-2">
                                <p class="m-0">Morad De Visch</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="team-join" class="d-flex flex-row">
            <div class="p-5 m-5">
                <h1 class="fs-1 fw-bold mb-4">Rejoindre une équipe</h1>
                <p class="fs-5">À la recherche de coéquipiers ? Cliquez ici pour en trouver</p>
            </div>
            
            <div class="d-flex align-items-center m-auto ms-5">
                <a href="partners" id="find-button" class="btn btn-dark btn-lg">
                    Trouver des coéquipiers
                </a>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mx-auto mb-4">
            <a href="create_match" class="btn btn-primary btn-lg">
                Créer un match
            </a>
        </div>

        <div id="tournament-stats">
            <div class="d-flex flex-column align-items-center mx-auto mb-5">
                <h1 class="fs-1 fw-bold mb-4">Statistique de Tournoi</h1>
                <p class="fs-5">Regardez les dernières statistiques de vos tournois</p>
            </div>
            
            <div class="d-flex justify-content-evenly pb-5">
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Participants total</h1>
                    <p class="fs-3 fw-bold">1500</p>
                </div>
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Montant à gagner</h1>
                    <p class="fs-3 fw-bold">$50 000</p>
                </div>
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Équipe gagnante</h1>
                    <p class="fs-3 fw-bold">LeBron James</p>
                </div>
            </div>
        </div>
    </div>    
</div>

<script src="../../assets/public/js/carouselLoader.js"></script>


<script>
    document.getElementById('tournament-button').addEventListener('click', function () {
        window.location.href = 'tournaments_list'; 
    });
</script>

<?php include_once $includesGlobal . "footer.php"; ?>
