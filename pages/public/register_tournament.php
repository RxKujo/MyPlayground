<?php
include_once '../../includes/global/session.php';
include_once '../../includes/config/config.php';
notLogguedSecurity("../../index.php");

include_once $includesPublic . 'header.php';
include_once 'navbar/header.php';

$message = "";

$id_utilisateur = $_SESSION['user_info']['id'] ?? null;

if (!$id_utilisateur) {
    header("Location: ../../index.php");
    exit;
}


$stmt = $pdo->prepare("SELECT id_equipe, nom FROM equipe WHERE id_capitaine = ?");
$stmt->execute([$id_utilisateur]);
$equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tournois = $pdo->query("SELECT id_tournoi, nom FROM tournoi")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipe = $_POST['id_equipe'] ?? null;
    $id_tournoi = $_POST['id_tournoi'] ?? null;
    $email = trim($_POST['email'] ?? '');

    if (!$id_equipe || !$id_tournoi || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Veuillez remplir tous les champs correctement.</div>";
    } else {
        
        $stmt = $pdo->prepare("SELECT * FROM equipe WHERE id_equipe = ? AND id_capitaine = ?");
        $stmt->execute([$id_equipe, $id_utilisateur]);
        $equipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$equipe) {
            $message = "<div class='alert alert-danger'>Vous n'êtes pas le capitaine de cette équipe.</div>";
        } else {
            /
            $stmt = $pdo->prepare("SELECT * FROM equipe_tournoi WHERE id_equipe = ? AND id_tournoi = ?");
            $stmt->execute([$id_equipe, $id_tournoi]);

            if ($stmt->rowCount() > 0) {
                $message = "<div class='alert alert-warning'>Cette équipe est déjà inscrite à ce tournoi.</div>";
            } else {
                // Inscrit l'équipe au tournoi
                $stmt = $pdo->prepare("INSERT INTO equipe_tournoi (id_equipe, id_tournoi) VALUES (?, ?)");
                $stmt->execute([$id_equipe, $id_tournoi]);

                $message = "<div class='alert alert-success'>L'équipe a été inscrite au tournoi avec succès !</div>";
            }
        }
    }
}
?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Inscrire une équipe à un tournoi</h2>

        <?= $message ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Votre adresse e-mail</label>
                <input type="email" class="form-control" name="email" id="email" required placeholder="Entrez votre adresse e-mail"
                       value="<?= htmlspecialchars($_SESSION['user_info']['email'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="id_equipe" class="form-label">Choisir une équipe (dont vous êtes capitaine)</label>
                <select class="form-select" name="id_equipe" id="id_equipe" required>
                    <option value="" disabled selected>-- Sélectionner une équipe --</option>
                    <?php foreach ($equipes as $equipe): ?>
                        <option value="<?= $equipe['id_equipe'] ?>"><?= htmlspecialchars($equipe['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_tournoi" class="form-label">Choisir un tournoi</label>
                <select class="form-select" name="id_tournoi" id="id_tournoi" required>
                    <option value="" disabled selected>-- Sélectionner un tournoi --</option>
                    <?php foreach ($tournois as $tournoi): ?>
                        <option value="<?= $tournoi['id_tournoi'] ?>"><?= htmlspecialchars($tournoi['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Inscrire l'équipe</button>
        </form>

        <a href="/tournaments" class="btn btn-secondary mt-3">Retour aux tournois</a>
    </div>
</div>

<?php include_once('../../includes/global/footer.php'); ?>
