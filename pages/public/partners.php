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
            $_SESSION['current_page'] = 'settings';
        }
        include_once "navbar/navbar.php";
    ?>    

    <div class="container-fluid px-0" id="content">                
        <div id="partners-page">
            <div class="bg-black" style="--bs-bg-opacity: .65;" role="partners header">
                <div class="container py-5">
                    <h1 class="fs-1 fw-bold text-center text-white mb-4">Filter Your Teammates</h1>
                    <p class="fs-6 text-center text-white mb-0">Find teammates who match your criteria.</p>

                </div>
            </div>
            
            <div class="container py-4">
                <h2 class="fs-2 fw-bold">Filters</h1>
                <div class="accordion" id="accordion-filter1">
                        <form class="d-flex flex-row gap-3 align-items-baseline">
                            <div class="accordion-item" style="width: 180px;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Level
                                    </button>
                                </h2>

                                <div id="collapseOne" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <fieldset>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl1" id="lvl1">
                                                <label class="form-check-label" for="lvl1">Beginner</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl2" id="lvl2">
                                                <label class="form-check-label" for="lvl2">Intermediate</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Advanced</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="anylvl" id="anylvl">
                                                <label class="form-check-label" for="anylvl">Any</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                
                            </div>


                            <div class="accordion-item border-top" style="width: 180px; border-top-left-radius: 0.375rem; border-top-right-radius: 0.375rem;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Position
                                    </button>    
                                </h2>

                                <div id="collapseTwo" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <fieldset>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl1" id="lvl1">
                                                <label class="form-check-label" for="lvl1">Point Guard</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl2" id="lvl2">
                                                <label class="form-check-label" for="lvl2">Shooting Guard</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Small Forward</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Power Forward</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Center Forward</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Any</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>            
</div>

<?php include_once $includesGlobal . "footer.php"; ?>