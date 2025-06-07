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

function userPdf(array $user) {
    $pdf = new FPDF();
    $pdf->AddPage();

    // Document Title
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(40, 40, 40);
    $pdf->Cell(0, 15, 'User Profile', 0, 1, 'C');
    $pdf->Ln(10); // Line break

    // Section Header
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 102, 204);
    $pdf->Cell(0, 10, 'User Details', 0, 1);
    $pdf->Ln(3);

    // User Data Fields
    foreach ($user as $key => $value) {
        $label = ucfirst(str_replace('_', ' ', $key));

        // Label
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(50, 8, "$label:", 0, 0);

        // Value
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

function clearSession() {
    $_SESSION = [];
    session_destroy();
}

function displayAlert(string $key, int $kind) {
    if (isset($_SESSION[$key]) && !is_null($_SESSION[$key])) {
        alertMessage($_SESSION[$key], $kind);
        $_SESSION[$key] = null;
    }
}

function fetchUsers(PDO $pdo, string $filter, string $input) {
    $sql = "SELECT * FROM utilisateur WHERE $filter = $input";
    $results = $pdo->query($sql, PDO::FETCH_ASSOC);
    return $results;    
}

function notLogguedSecurity(string $pathToIndex) {
    if (!isset($_SESSION['user_info'])) {
        header("location: " . $pathToIndex);
        exit();
    }
}

function getPfp(PDO $pdo, array $user) {
    $sql = "SELECT pfp from utilisateur WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id'=>$user['id']
    ]);

    $pfp = $stmt->fetch(PDO::PARAM_LOB);
    return $pfp;
}