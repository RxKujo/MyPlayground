const parts = {
  eyes: ["eyes1.png", "eyes2.png"],
  nose: ["nose1.png"],
  mouth: ["mouth1.png", "mouth2.png"]
};

const currentIndex = {
  eyes: 0,
  nose: 0,
  mouth: 0
};

function loadImage(src) {
  return new Promise((resolve) => {
    const img = new Image();
    img.onload = () => resolve(img);
    img.src = 'assets/public/img/' + src;
    
  });
}

async function drawAvatar() {
  const canvas = document.getElementById('avatarCanvas');
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  const eyes = parts.eyes[currentIndex.eyes];
  const nose = parts.nose[currentIndex.nose];
  const mouth = parts.mouth[currentIndex.mouth];

  const [eyesImg, noseImg, mouthImg] = await Promise.all([
    loadImage(eyes),
    loadImage(nose),
    loadImage(mouth)
  ]);

  // Redimensionnement centré
  const centerX = canvas.width / 2;
  const centerY = canvas.height / 2;

  // Paramètres fixes pour chaque partie
  const size = 80; // Taille standard pour chaque élément
  const half = size / 2;

  // Positions personnalisées
  ctx.drawImage(eyesImg, centerX - half, centerY - 60, size, size);  // yeux plus haut
  ctx.drawImage(noseImg, centerX - half, centerY - 20, size, size);  // nez au centre
  ctx.drawImage(mouthImg, centerX - half, centerY + 20, size, size); // bouche plus bas
}


function prevPart(part) {
  currentIndex[part] = (currentIndex[part] - 1 + parts[part].length) % parts[part].length;
  drawAvatar();
}

function nextPart(part) {
  currentIndex[part] = (currentIndex[part] + 1) % parts[part].length;
  drawAvatar();
}

function saveAvatar() {
  const canvas = document.getElementById('avatarCanvas');
  const imageData = canvas.toDataURL('image/png');

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'save-avatar.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById('resultMessage').innerHTML = 
        `<div class="alert alert-success">Avatar sauvegardé : ${xhr.responseText}</div>`;
    }
  };
  xhr.send('image=' + encodeURIComponent(imageData));
}

// Auto-chargement de l'avatar par défaut
drawAvatar();
