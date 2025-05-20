<?php

function print_error($session) {
    if (isset( $session["error"] ) ) {
        $error = $session["error"];

        echo '<div class="alert alert-danger text-center">';
        echo htmlspecialchars($error);
        echo '</div>';
    }
}

function deleteCookie($key) {
    if (isset($_COOKIE[$key])) {
        unset($_COOKIE[$key]);
        setcookie($key, '', time() - 3600,'/');
    }
}

function isAuthenticated($session) {
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

function getUserLevel($user) {
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

function getUserPosition($user) {
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

function getUserRole($user) {
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

function alertMessage(string $alert, int $kind) {
    // 0 = success, 1 = danger, 2 = warning, 3 = info
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