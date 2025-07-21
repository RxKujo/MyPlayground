<?php 

include_once '../../includes/global/session.php';
notLogguedSecurity("/");

include_once $assetsShared . 'icons/icons.php';
include_once $includesAdmin . 'header.php';

?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php'; ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Gestion des inscrits à la newsletter</h2>
        <input
            id="searchNewsletterField"
            type="text"
            class="form-control my-3"
            placeholder="Rechercher un email..."
        />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody id="newsletterShowing">
                <?php
                $stmt = $pdo->query("SELECT id, email, date_inscription FROM newsletter ORDER BY date_inscription DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_inscription']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('searchNewsletterField').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#newsletterShowing tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
    });
});
</script>

<?php include_once $includesGlobal . "footer.php"; ?>