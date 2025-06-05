const parts = {
  base: ["base.png"], // silhouette de fond
  hair: ["hair1.png", "hair2.png"],
  eyes: ["eyes1.png", "eyes2.png", "eyes3.png", "eyes4.png", "eyes5.png",],
  nose: ["nose1.png", "nose2.png", "nose3.png" ,"nose4.png" , "nose5.png"],
  mouth: ["mouth1.png", "mouth2.png", "mouth3.png", "mouth4.png", "mouth5.png"]
};

const currentIndex = {
  base: 0,
  hair: 0,
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

  const base = parts.base[currentIndex.base];
  const hair = parts.hair[currentIndex.hair];
  const eyes = parts.eyes[currentIndex.eyes];
  const nose = parts.nose[currentIndex.nose];
  const mouth = parts.mouth[currentIndex.mouth];

  const [baseImg, hairImg, eyesImg, noseImg, mouthImg] = await Promise.all([
    loadImage(base),
    loadImage(hair),
    loadImage(eyes),
    loadImage(nose),
    loadImage(mouth)
  ]);

  const centerX = canvas.width / 2;
  const centerY = canvas.height / 2;
  const size = 80;
  const half = size / 2;

  // Base
  ctx.drawImage(baseImg, 0, 0, canvas.width, canvas.height);

  // Superposition des éléments
  ctx.drawImage(hairImg, centerX - half, centerY - 100, size, size);  // cheveux
  ctx.drawImage(eyesImg, centerX - half, centerY - 60, size, size);   // yeux
  ctx.drawImage(noseImg, centerX - half, centerY - 20, size, size);   // nez
  ctx.drawImage(mouthImg, centerX - half, centerY + 20, size, size);  // bouche
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
  xhr.open('POST', 'save-avatar', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById('resultMessage').innerHTML = 
        `<div class="alert alert-success">Avatar sauvegardé : ${xhr.responseText}</div>`;
    }
  };
  xhr.send('image=' + encodeURIComponent(imageData));
}

// Auto-chargement
drawAvatar();
