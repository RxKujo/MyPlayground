<?php 

include_once "../../includes/config/variables.php";
include_once $includesConfig . "functions.php";

if (!isset($_SESSION['user_info'])) {
    header("location: ../../index.php");
    exit();
}

if (!isAdmin($_SESSION['user_info'])) {
    http_response_code(401);
    exit();
}

include_once $includesAdmin . "header.php"; 

?>

<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>
    
    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Dashboard</h2>
        <p>Here is the dashboard menu.</p>
    </div>
</div>

<?php include_once "../../includes/global/footer.php"; ?>