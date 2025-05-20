<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créateur d'avatar pixel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #343a40;
      color: white;
      font-family: monospace;
    }
    .pixel-frame {
      border: 3px solid black;
      image-rendering: pixelated;
    }
    .arrow-btn {
      background: none;
      border: none;
      font-size: 2rem;
      color: white;
    }
    canvas {
      background-color: white;
      border: 2px solid black;
      image-rendering: pixelated;
    }
  </style>
</head>
<body class="d-flex flex-column align-items-center justify-content-center vh-100">

  <h1 class="mb-4">Créer ton avatar</h1>

  <!-- Canvas -->
  <canvas id="avatarCanvas" width="200" height="200" class="mb-4"></canvas>

  <!-- Contrôles fléchés -->
  <div class="d-flex flex-column gap-3">
    <!-- YEUX -->
    <div class="d-flex align-items-center justify-content-center gap-3">
      <button class="arrow-btn" onclick="prevPart('eyes')">&lt;</button>
      <span>Yeux</span>
      <button class="arrow-btn" onclick="nextPart('eyes')">&gt;</button>
    </div>

    <!-- NEZ -->
    <div class="d-flex align-items-center justify-content-center gap-3">
      <button class="arrow-btn" onclick="prevPart('nose')">&lt;</button>
      <span>Nez</span>
      <button class="arrow-btn" onclick="nextPart('nose')">&gt;</button>
    </div>

    <!-- BOUCHE -->
    <div class="d-flex align-items-center justify-content-center gap-3">
      <button class="arrow-btn" onclick="prevPart('mouth')">&lt;</button>
      <span>Bouche</span>
      <button class="arrow-btn" onclick="nextPart('mouth')">&gt;</button>
    </div>
  </div>

  <!-- Bouton enregistrer -->
  <button class="btn btn-success mt-4" onclick="saveAvatar()">Enregistrer Avatar</button>
  <div id="resultMessage" class="mt-3"></div>

  <script src="avatar-builder.js"></script>
</body>
</html>
