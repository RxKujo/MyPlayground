<?php 

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $root . "/includes/config/config.php";
include_once $root . "/includes/public/header.php";
?>

<?php
    include_once "navbar/header.html";
?>

<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'tournaments';
        }
        include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid px-0" id="content">        
        <div
            id="carousel"
            class="carousel slide px-5 py-3"
            data-bs-ride="carousel"
            >
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <!-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
            </div>
            
            <div class="carousel-inner d-block bg-secondary w-100 h-100 mx-auto">
                <div class="carousel-item active" data-bs-interval="2000">
                    <img src="../../assets/public/img/morad2.jpg" class="d-block mx-auto" alt="img1" />
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="../../assets/public/img/morad_singe.jpg" class="d-block mx-auto" alt="img2" />
                </div>
                <!-- <div class="carousel-item" data-bs-interval="2000">
                    <img src="../../assets/public/img/morad.png" class="d-block mx-auto" alt="img3" />
                </div> -->
            </div>
            <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carousel"
                data-bs-slide="prev"
            >
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#carousel"
                data-bs-slide="next"
            >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


        <div class="bg-black" style="--bs-bg-opacity: .5;">
            <h1 class="fs-1 fw-bold text-center text-white py-3">Upcoming Tournaments</h1>
            <p class="fs-5 text-center text-white">Stay ahead of the game by participating in these exciting tournaments</p>
            
            <div class="input-group mb-3 mx-auto pt-3 pb-4 w-25">
                <input type="text" class="form-control" id="search-tourney-input" placeholder="Search tournaments">
            </div>

            <div class="d-flex flex-column align-items-center mx-auto mb-5 pb-5">
                <button id="tournament-button" class="btn btn-dark btn-lg">
                    <span class="px-3">View all tournaments</span>
                </button>
            </div>

        </div>

        <div id="reviews" class="d-flex flex-row">
            <div class="p-5 m-5">
                <img src="../../assets/public/img/morad.png" alt="picture">
            </div>

            <div class="m-5">
                <h1 class="fs-1 fw-bold ">Player reviews</h1>
                <p class="fs-5">Discover what players are saying about our tournaments</p>
                <div>
                    <div>
                        <div class="d-flex" role="img & name container">
                            <a href="#" class="d-flex align-items-center text-decoration-none text-dark">
                                <div role="img">
                                    <img class="profile-img-small" src="../../assets/public/img/morad.png" alt="picture">
                                </div>
                                <div class="p-2">
                                    <p class="m-0">Morad De Visch</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            
                        </div>
                        <div>
                            
                        </div>
                        <div>
                
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div id="team-join" class="d-flex flex-row">
            <div class="p-5 m-5">
                <h1 class="fs-1 fw-bold mb-4">Join a team</h1>
                <p class="fs-5">Looking for teammates? Click here to connect to others</p>
            </div>
            
            <div class="d-flex align-items-center m-auto ms-5">
                <a href="partners.php" id="find-button" class="btn btn-dark btn-lg">
                    Find teammates
                </a>
            </div>
        </div>

        <div id="tournament-stats">
            <div class="d-flex flex-column align-items-center mx-auto mb-5">
                <h1 class="fs-1 fw-bold mb-4">Tournament Stats</h1>
                <p class="fs-5">Check out the latest statistics from our tournaments</p>
            </div>
            
            <div class="d-flex justify-content-evenly pb-5" role="infos">
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Total Participants</h1>
                    <p class="fs-3 fw-bold">1500</p>
                </div>
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Prize Pool</h1>
                    <p class="fs-3 fw-bold">$50 000</p>
                </div>
                <div class="border rounded p-3" style="width: 400px;">
                    <h1 class="fs-5 text-body-tertiary">Winning Team</h1>
                    <p class="fs-3 fw-bold">LeBron James</p>
                </div>
            </div>
        </div>
    </div>    
</div>
<?php include_once $includesGlobal . "footer.php"; ?>