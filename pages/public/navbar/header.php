<?php

include_once '../../includes/config/config.php';

?>

<header class="container-fluid bg-dark py-0 my-0">
    <div class="container ms-0 ps-0">
        <div class="row align-items-center">
            <a class="col-8 pb-0 text-white text-decoration-none" href="index.php" data-page="home">
                <div class="pt-0">
                    <img 
                        src="../../assets/public/img/logo.png"
                        alt="Logo"
                        class="logo"
                        >
                    <span class="text-reset fs-1">My PlayGround</span>
                </div>
            </a>

            <span class="col text-white"><?= $chatLeftTextFill ?></a></span>
            <span class="col text-white"><?= $bellFill ?></span>
            <span class="col text-white"><a class="text-decoration-none" href="profile"><?= $personFill ?></a></span>
        </div>
    </div>
</header>