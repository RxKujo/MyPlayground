<?php

function print_error(array $session) {
    if (isset( $session["error"] ) ) {
        $error = $session["error"];

        echo '<div class="alert alert-danger text-center">';
        echo htmlspecialchars($error);
        echo '</div>';
    }
}

function isAuthenticated(array $session) {
    if (isset($session['user_id'])) {
        if (key_exists('user_id', $session)) {
            return true;
        }
    }
    return false;
}

function getUser(PDO $pdo, int $id) {
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserIdFromUsername(PDO $pdo, string $username) {
    $r = $pdo->query(
        "SELECT id FROM utilisateur WHERE pseudo = '$username'"
    );

    return $r->fetch(PDO::FETCH_ASSOC)['id'];
}

function getUsersFromLevel(PDO $pdo, int $level, int $limit = 0) {
    if ($limit) {
        $sql = "SELECT * FROM utilisateur WHERE niveau = $level LIMIT $limit";
        $r = $pdo->query($sql);
        return $r->fetchAll();
    }
    return 0;
}

function isAdmin(array $user) {
    return $user["droits"] == 1;
}

function getUserLevel(array $user) {
    switch ($user['niveau']) {
    case 0:
        $niveau = 'Débutant';
        break;
    case 1:
        $niveau = 'Intérmediaire';
        break;
    case 2:
        $niveau = 'Avancé';
        break;
    case 3:
        $niveau = 'Pro';
        break;
	default:
		$niveau = 'Inconnu';
		break;
    }

    return $niveau;
}

function getUserPosition(array $user) {
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
        default:
            $position = 'Inconnu';
            break;
    }

    return $position;
}

function getUserRole(array $user) {
    switch ($user['role']) {
        case 0:
            $role = 'Joueur';
            break;
        case 1:
            $role = 'Arbitre';
            break;
        case 2:
            $role = 'Organisateur';
            break;
        case 3:
            $role = 'Spectateur';
            break;
        default:
            $role = 'Inconnu';
            break;
    }

    return $role;
}

function getUserRights(array $user) {
    return isAdmin($user) ? 'Oui' : 'Non'; 
}

function alertMessage(string $alert, int $kind) {
  
    global $checkCircleFill, $xCircleFill, $exclamationCircleFill, $infoFill, $gearFill;

    switch ($kind) {
        case 0:
            $kindBtstp = "alert-success";
            $icon = $checkCircleFill;
            break;
        case 1:
            $kindBtstp = "alert-danger";
            $icon = $xCircleFill;
            break;
        case 2:
            $kindBtstp = "alert-warning";
            $icon = $exclamationCircleFill;
            break;
        case 3:
            $kindBtstp = "alert-info";
            $icon = $infoFill;
            break;
        default:
            $kindBtstp = "alert-light";
            $icon = $gearFill;
            break;
    }

    $html = '<div class="alert ' . $kindBtstp . ' text-center mb-0">' . $icon . '
        <span class="ms-1">' . $alert . '</span>
        </div>';
    
    echo $html;
}

function userPdf(array $user) {
    $pdf = new FPDF();
    $pdf->AddPage();

    
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(40, 40, 40);
    $pdf->Cell(0, 15, 'User Profile', 0, 1, 'C');
    $pdf->Ln(10);

  
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 102, 204);
    $pdf->Cell(0, 10, 'User Details', 0, 1);
    $pdf->Ln(3);

  
    foreach ($user as $key => $value) {
        if (in_array($key, ['id', 'mdp', 'pfp', 'id_yeux', 'id_nez', 'id_bouche', 'visage_blob', 'email_verification_token', 'is_online', 'derniere_connexion'])) {
            continue;
        }

        if ($key == 'poste') {
            $value = getUserPosition($user);
        } else if ($key == 'role') {
            $value = getUserRole($user);
        } else if ($key == 'droits') {
            $value = $user['droits'] == 0 ? "Utilisateur ordinaire" : "Administrateur";
        } else if ($key == 'niveau') {
            $value = mb_convert_encoding(getUserLevel($user), 'ISO-8859-1', 'UTF-8');
        } else if ($key == 'is_verified') {
            $value = ($key == 1 ? "Oui" : "Non");
        }
        
        $label = ucfirst(str_replace('_', ' ', $key));

      
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(50, 8, "$label:", 0, 0);

       
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 8, $value);
    }

    return $pdf;
}

function redirectError(string $error, string $errorMessage, string $location) {
    $_SESSION['errors'][$error] = $errorMessage;
    header("Location: " . $location);
    exit();
}

function displayAlert(string $key, int $kind) {
    if (isset($_SESSION[$key]) && !is_null($_SESSION[$key])) {
        alertMessage($_SESSION[$key], $kind);
        $_SESSION[$key] = null;
    }
}

function fetchUsersFilter(PDO $pdo, string $filter, string $input) {
    $sql = "SELECT * FROM utilisateur WHERE $filter = $input";
    $results = $pdo->query($sql, PDO::FETCH_ASSOC);
    return $results;    
}

function isBanned(PDO $pdo, int $userId) {
    $r = $pdo->query("SELECT is_banned FROM utilisateur WHERE id = $userId");
    return $r->fetch(PDO::FETCH_COLUMN);
}

function notLogguedSecurity(string $pathToIndex) {
    if (!isset($_SESSION['user_info'])) {
        header("location: " . $pathToIndex);
        exit();
    }
}

function getPfp(PDO $pdo, array $user) {
    $stmt = $pdo->prepare("SELECT pfp FROM utilisateur WHERE id = :id");
    $stmt->execute(['id' => $user['id']]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['pfp'] ?? null;
}

function getPseudoById(PDO $pdo, int $userId) {
    $r = $pdo->query("SELECT pseudo FROM utilisateur WHERE id = $userId");
    return $r->fetch(PDO::FETCH_COLUMN);
}

function fetchColumns(PDO $pdo, string $table, array $cols) {
    $sql = "SELECT " . implode(', ', $cols) . " FROM $table";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayCardUser(array $user) {
    $pseudo = $user['pseudo'];
    $prenom = $user['prenom'];
    $nom = $user['nom'];
    $niveau = getUserLevel($user);
    $poste = getUserPosition($user);
    $localisation = $user['localisation'];

    $html = '
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2">' . htmlspecialchars($prenom . " " . $nom) . '</h5>
                <h6 class="card-subtitle mb-3 text-muted">@' . htmlspecialchars($pseudo) . '</h6>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Niveau :</strong> ' . htmlspecialchars($niveau) . '</li>
                    <li class="list-group-item"><strong>Poste :</strong> ' . htmlspecialchars($poste) . '</li>
                    <li class="list-group-item"><strong>Localisation :</strong> ' . htmlspecialchars($localisation ?? "Inconnu") . '</li>
                </ul>
            </div>
        </div>
    </div>
    ';

    return $html;
}

function displayCardMatch(array $match) {
    
}

function displayCardMessage(int $user_id) {
    $html = '
        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3 mb-3">
            <img src="<?= $pfpSrc ?>" class="rounded-circle" width="48" height="48" alt="">
            <div class="d-flex flex-column">
                <strong>Morad</strong>
                <small class="text-muted">Dernier message...</small>
            </div>
        </a>';
}

function getAllDiscussionsNames(PDO $pdo, int $user_id) {
    $r = $pdo->query(
        "SELECT pgroupe.id_groupe, groupe.nom, groupe.id_dernier_message FROM 
            participation_groupe AS pgroupe 
            INNER JOIN 
            groupe_discussion AS groupe 
            ON pgroupe.id_groupe = groupe.id
            WHERE pgroupe.id_utilisateur = $user_id");
    
    $names = $r->fetchAll(PDO::FETCH_ASSOC);
    return $names;
}

function getFirstUserInDiscussion(PDO $pdo, int $groupe_id, int $userId) {
    $r = $pdo->query(
        "SELECT u.id, u.pfp, u.nom FROM 
        utilisateur AS u 
        INNER JOIN 
        participation_groupe 
        ON participation_groupe.id_utilisateur = u.id 
        WHERE participation_groupe.id_groupe = $groupe_id AND u.id != $userId" 
    );
    $users = $r->fetch(PDO::FETCH_ASSOC);
    return $users;
}

function getAllUsersInDiscussion(PDO $pdo, int $groupe_id, int $userId) {
    $r = $pdo->query(
        "SELECT u.id, u.pfp, u.pseudo FROM 
        utilisateur AS u 
        INNER JOIN 
        participation_groupe 
        ON participation_groupe.id_utilisateur = u.id 
        WHERE participation_groupe.id_groupe = $groupe_id AND u.id != $userId" 
    );
    $users = $r->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function getReceivers(PDO $pdo, int $id_groupe) {
    $r = $pdo->query(
        "SELECT "
    );
}

function getMessagesByGroup(PDO $pdo, int $groupe_id) {
    $r = $pdo->query(
        "SELECT DISTINCT e.id_message, e.id_envoyeur, e.id_groupe, e.message, e.date_envoi, e.lu FROM
        echanger AS e
        INNER JOIN
        participation_groupe
        ON participation_groupe.id_groupe = e.id_groupe
        WHERE participation_groupe.id_groupe = $groupe_id
        ORDER BY date_envoi ASC"
    );

    $messages = $r->fetchAll(PDO::FETCH_ASSOC);

    return $messages;
}

function getMessage(PDO $pdo, int | null $messageId) {
    if (is_null($messageId)) {
        return null;
    }
    $r = $pdo->query("SELECT * FROM echanger WHERE id_message = $messageId");
    $message = $r->fetch(PDO::FETCH_ASSOC);
    return $message;
}

function isUserOnline(PDO $pdo, int $userId) {
    $sql = "SELECT is_online FROM utilisateur WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    
    return $result == 1;
}

function isUserSubscribed(PDO $pdo, int $userId) {
    $sql = (
        "SELECT u.id 
        FROM utilisateur AS u 
        INNER JOIN 
        newsletter as n 
        ON u.id = n.id_utilisateur 
        WHERE $userId = u.id"
    );

    $r = $pdo->query($sql);
    return $r->fetch(PDO::FETCH_ASSOC);
}

function makeOnline(PDO $pdo, $userId) {
    if (!isUserOnline($pdo, $userId)) {
        $sql = "UPDATE utilisateur SET is_online = 1 WHERE id = :id";
    } else {
        return false;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

    $stmt->execute();

    return true;
}

function makeOffline(PDO $pdo, $userId) {
    if (isUserOnline($pdo, $userId)) {
        $sql = "UPDATE utilisateur SET is_online = 0 WHERE id = :id";
    } else {
        return false;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return true;
}

function clearSession(PDO $pdo, int $userId) {
    makeOffline($pdo, $userId);
    $_SESSION = [];
    session_destroy();
}


function logAction(PDO $pdo, $user_id = null) {
    $stmt = $pdo->prepare("
        INSERT INTO logs (
            user_id, script_name, ip, status, http_referer, request_uri, request_method, server_protocol, http_user_agent
        ) VALUES (
            :user_id, :script_name, :ip, :status, :http_referer, :request_uri, :request_method, :server_protocol, :http_user_agent
        )
    ");
    $stmt->bindValue(':user_id', $user_id, is_null($user_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $stmt->bindValue(':script_name', $_SERVER['SCRIPT_NAME'] ?? null);
    $stmt->bindValue(':ip', $_SERVER['REMOTE_ADDR'] ?? null);
    $stmt->bindValue(':status', $_SERVER['REDIRECT_STATUS'] ?? null);
    $stmt->bindValue(':http_referer', $_SERVER['HTTP_REFERER'] ?? null);
    $stmt->bindValue(':request_uri', $_SERVER['REQUEST_URI'] ?? null);
    $stmt->bindValue(':request_method', $_SERVER['REQUEST_METHOD'] ?? null);
    $stmt->bindValue(':server_protocol', $_SERVER['SERVER_PROTOCOL'] ?? null);
    $stmt->bindValue(':http_user_agent', $_SERVER['HTTP_USER_AGENT'] ?? null);
    $stmt->execute();
}

function showPfp(PDO $pdo, array $user) {
    $avatarData = getPfp($pdo, $user) ?? null;

    if ($avatarData) {
        $base64 = base64_encode($avatarData);
        $avatarSrc = "data:image/png;base64," . $base64;
    } else {
        $avatarSrc = "../../assets/public/img/profiledefault.png";
    }

    return $avatarSrc;
}

function showPfpOffline(array $user) {
    $avatarData = $user['pfp'];

    if ($avatarData) {
        $base64 = base64_encode($avatarData);
        $avatarSrc = "data:image/png;base64," . $base64;
    } else {
        $avatarSrc = "../../assets/public/img/profiledefault.png";
    }

    return $avatarSrc;
}


function getAllUsers(PDO $pdo) {
    $r = $pdo->query(
        "SELECT 
            id, nom, prenom, pseudo, 
            localisation, email, tel, poste, 
            droits, role, niveau, derniere_connexion, 
            is_online, is_verified, is_banned, banned_on, 
            ban_count 
        FROM utilisateur");
    return $r->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMatches(PDO $pdo) {
    $r = $pdo->query(
        "SELECT m.*, t.nom AS nom_terrain, t.localisation, u.pseudo AS createur_pseudo
        FROM `match` m
        LEFT JOIN reserver r ON r.id_match = m.id_match
        LEFT JOIN terrain t ON r.id_terrain = t.id_terrain
        LEFT JOIN utilisateur u ON m.id_createur = u.id
        ORDER BY m.id_match DESC"
    );

    return $r->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCaptchas(PDO $pdo) {
    $r = $pdo->query("SELECT id, question, reponse FROM captchas");
    return $r->fetchAll(PDO::FETCH_ASSOC);
}


function getAllTeams(PDO $pdo) {
    $r = $pdo->query("SELECT * FROM equipe");
    return $r->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTourneys(PDO $pdo) {
    $r = $pdo->query("SELECT * FROM tournoi");
    return $r->fetchAll(PDO::FETCH_ASSOC);
}

function getAllNews(PDO $pdo) {
    $r = $pdo->query("SELECT * FROM newsletter_post");
    return $r->fetchAll(PDO::FETCH_ASSOC);
}

function createUser(
    PDO $pdo,

    string $prenom,
    string $nom,
    string $email,
    string $tel,
    string $naissance,
    string $adresse,
    string $pseudo,
    
    int $role,
    int $position,
    int $niveau,

    string $password,
    string $confirm_password,

    string $captcha,
    string $captcha_expected
) {
    if (!$prenom || !$nom || !$email || !$tel || !$naissance || !$adresse || !$pseudo || !$password || !$confirm_password) {
        return ['success' => false, 'message' => "Tous les champs sont obligatoires."];
    } else if ($password !== $confirm_password) {
        return ['success' => false, 'message' => "Les mots de passe ne correspondent pas."];
    } else if (!$captcha_expected || !$captcha || strtolower($captcha) !== strtolower($captcha_expected)) {
        return ['success' => false, 'message' => "Veuillez valider correctement le captcha."];
    }

    $sql = "SELECT id FROM utilisateur WHERE pseudo = :pseudo OR email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return ['success' => false, 'message' => "Nom d'utilisateur ou email déjà utilisé."];
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $verificationToken = bin2hex(random_bytes(32));
    $isVerified = 0;

    $sql = 
    "INSERT INTO utilisateur 
    (pseudo, prenom, nom, date_naissance, email, mdp, tel, poste, role, localisation, niveau, description, email_verification_token, is_verified) 
    VALUES 
    (:pseudo, :prenom, :nom, :naissance, :email, :mdp, :tel, :poste, :role, :localisation, :niveau, :description, :token, :is_verified)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':naissance', $naissance);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mdp', $hashedPassword);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':poste', $position);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':localisation', $adresse);
    $stmt->bindParam(':niveau', $niveau);
    $description = ""; 
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':token', $verificationToken);
    $stmt->bindParam(':is_verified', $isVerified);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => "", 'token' => $verificationToken];
    }
    return ['success' => false, 'message' => "Une erreur est survenue lors de l'inscription. Veuillez réessayer."];
}

function createGroup(PDO $pdo, string $nom_groupe, int $creatorId) {
    $stmt = $pdo->prepare("INSERT INTO groupe_discussion (nom, id_createur) VALUES (:nom, :utilisateur)");
    $stmt->execute(['nom' => $nom_groupe, 'utilisateur' => $creatorId]);
    $groupId = $pdo->lastInsertId();
    return $groupId;
}

function addToGroup(PDO $pdo, int $groupId, int $userId) {
    $stmt = $pdo->prepare("INSERT INTO participation_groupe (id_groupe, id_utilisateur) VALUES (:groupe, :utilisateur)");
    $stmt->execute(['groupe' => $groupId, 'utilisateur' => $userId]);
}

function setUserLastLogin(PDO $pdo, int $userId) {
    $r = $pdo->query("UPDATE utilisateur SET derniere_connexion = NOW() WHERE id = $userId");
}

function e(PDO $pdo) {
    $stmt = $pdo->query(
        "SELECT m.id_match, m.message, m.statut, m.id_createur AS createur, 
                e1.nom AS equipe1, e2.nom AS equipe2, t.nom AS nom_terrain, 
                t.localisation, r.date_reservation, r.heure_debut, r.heure_fin, 
                e1.id_equipe AS id_equipe1, e2.id_equipe AS id_equipe2, 
                r.id_reservation AS id_reservation, t.id_terrain AS id_terrain 
        FROM 
            `match` m 
        LEFT JOIN 
            equipe e1 ON m.id_equipe1 = e1.id_equipe 
        LEFT JOIN 
            equipe e2 ON m.id_equipe2 = e2.id_equipe 
        LEFT JOIN 
            reserver r ON r.id_match = m.id_match 
        LEFT JOIN 
            terrain t ON r.id_terrain = t.id_terrain 
        WHERE 
            m.statut = 'en_attente' 
        ORDER BY m.id_match DESC
    ");

}



function inscrireEquipeTournoi(PDO $pdo, $id_tournoi, $id_equipe) {
    $stmt = $pdo->prepare("SELECT * FROM inscription_tournoi WHERE id_tournoi = ? AND id_equipe = ?");
    $stmt->execute([$id_tournoi, $id_equipe]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Cette équipe est déjà inscrite à ce tournoi.'];
    }

    $stmt = $pdo->prepare("INSERT INTO inscription_tournoi (id_tournoi, id_equipe, statut) VALUES (?, ?, 'en attente')");
    if ($stmt->execute([$id_tournoi, $id_equipe])) {
        return ['success' => true, 'message' => 'Inscription réussie !'];
    }
    return ['success' => false, 'message' => 'Erreur lors de l\'inscription.'];
}