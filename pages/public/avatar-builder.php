<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créateur d'avatar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    #avatarCanvas {
      border: 1px solid #ccc;
    }
  </style>
</head>
<body class="container py-5">

  <h1 class="mb-4">Créer votre avatar</h1>

  <div class="row mb-3">
    <div class="col-md-6">
      <label>Yeux :</label>
      <select id="eyesSelect" class="form-select">
        <option value="eyes1.png">Yeux 1</option>
        <option value="eyes2.png">Yeux 2</option>
      </select>

      <label class="mt-2">Nez :</label>
      <select id="noseSelect" class="form-select">
        <option value="nose1.png">Nez 1</option>
        <option value="nose2.png">Nez 2</option>
      </select>

      <label class="mt-2">Bouche :</label>
      <select id="mouthSelect" class="form-select">
        <option value="mouth1.png">Bouche 1</option>
        <option value="mouth2.png">Bouche 2</option>
      </select>

      <button class="btn btn-primary mt-3" onclick="generateAvatar()">Générer Avatar</button>
      <button class="btn btn-success mt-3 ms-2" onclick="saveAvatar()">Enregistrer Avatar</button>
    </div>

    <div class="col-md-6">
      <canvas id="avatarCanvas" width="200" height="200"></canvas>
    </div>
  </div>

  <div id="resultMessage"></div>

  <script src="avatar-builder.js"></script>
</body>
</html>
