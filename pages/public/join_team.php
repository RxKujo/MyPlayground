<?php
include_once '../../includes/global/session.php';
include_once '../../includes/config/config.php';
notLogguedSecurity("/");

include_once $includesPublic . 'header.php';
include_once 'navbar/header.php';

$message = "";

$stmt = $pdo->query("SELECT * FROM equipe");
$equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipe = $_POST['id_equipe'] ?? null;
    $pseudo_form = trim($_POST['pseudo'] ?? '');
    $poste = trim($_POST['poste'] ?? '');
    $code_saisi = trim($_POST['code'] ?? '');

    $pseudo_session = $_SESSION['user_info']['pseudo'] ?? '';
    $id_utilisateur = $_SESSION['user_info']['id'] ?? null;

    if (!$id_equipe || !$pseudo_form || !$poste) {
        $message = "<div class='alert alert-danger'>Tous les champs sont obligatoires.</div>";
    } elseif (strtolower($pseudo_form) !== strtolower($pseudo_session)) {
        $message = "<div class='alert alert-danger'>Le pseudo ne correspond pas à votre compte.</div>";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM equipe WHERE id_equipe = ?");
        $stmt->execute([$id_equipe]);
        $equipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$equipe) {
            $message = "<div class='alert alert-danger'>L'équipe sélectionnée n'existe pas. Veuillez entrer un nom correct.</div>";
        } elseif ($equipe['privee'] && $equipe['code'] !== $code_saisi) {
            $message = "<div class='alert alert-danger'>Code incorrect pour cette équipe privée.</div>";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM equipe_membre WHERE id_equipe = ? AND id_utilisateur = ?");
            $stmt->execute([$id_equipe, $id_utilisateur]);

            if ($stmt->rowCount() > 0) {
                $message = "<div class='alert alert-warning'>Vous êtes déjà membre de cette équipe.</div>";
            } else {
                $stmt = $pdo->prepare("INSERT INTO equipe_membre (id_equipe, id_utilisateur, pseudo, poste) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id_equipe, $id_utilisateur, $pseudo_form, $poste]);
                $message = "<div class='alert alert-success'>Vous avez rejoint l'équipe avec succès !</div>";
            }
        }
    }
}
?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Rejoindre une équipe</h2>

        <?= $message ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="id_equipe" class="form-label">Choisir une équipe</label>
                <select class="form-select" name="id_equipe" id="id_equipe" required onchange="toggleCodeField()">
                    <option value="" selected disabled>-- Sélectionner une équipe --</option>
                    <?php foreach ($equipes as $equipe): ?>
                        <option value="<?= $equipe['id_equipe'] ?>" data-privee="<?= $equipe['privee'] ? '1' : '0' ?>">
                            <?= htmlspecialchars($equipe['nom']) ?><?= $equipe['privee'] ? " (Privée)" : "" ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3" id="code_field" style="display:none;">
                <label for="code" class="form-label">Code d’accès (équipe privée)</label>
                <input type="text" class="form-control" name="code" id="code" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="pseudo" class="form-label">Votre pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo"
                       value="<?= htmlspecialchars($_SESSION['user_info']['pseudo'] ?? '') ?>" required readonly>
            </div>

<div class="mb-3">
    <label for="poste" class="form-label">Votre poste</label>
    <select class="form-select" name="poste" id="poste" required>
        <option value="" selected disabled>-- Sélectionner un poste --</option>
        <option value="Meneur">Meneur</option>
        <option value="Arrière">Arrière</option>
        <option value="Ailier">Ailier</option>
        <option value="Ailier fort">Ailier fort</option>
        <option value="Pivot">Pivot</option>
    </select>
</div>

            <button type="submit" class="btn btn-primary">Rejoindre l'équipe</button>
        </form>

        <a href="/teams" class="btn btn-secondary mt-3">Retour aux équipes</a>
    </div>
</div>

<script>
function toggleCodeField() {
    const select = document.getElementById('id_equipe');
    const codeField = document.getElementById('code_field');
    const selected = select.options[select.selectedIndex];
    if (selected && selected.dataset.privee === "1") {
        codeField.style.display = 'block';
    } else {
        codeField.style.display = 'none';
        document.getElementById('code').value = '';
    }
}
document.addEventListener('DOMContentLoaded', toggleCodeField);
</script>

<?php include_once('../../includes/global/footer.php'); ?>