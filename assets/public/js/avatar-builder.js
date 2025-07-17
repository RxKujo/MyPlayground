const parts = {
  base: ["base2.png"],
  hair: ["hair1.png", "hair2.png", "hair3.png", "hair4.png", "hair5.png"],
  eyes: ["eyes1.png", "eyes2.png", "eyes3.png", "eyes4.png", "eyes5.png", "eyes6.png", "eyes7.png"],
  nose: ["nose1.png", "nose2.png", "nose3.png", "nose4.png", "nose5.png"],
  mouth: ["mouth1.png", "mouth2.png", "mouth3.png", "mouth4.png", "mouth5.png", "mouth6.png"]
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
    img.src = 'assets/public/img/avatars/' + src;
  });
}

async function drawAvatar() {
  const canvas = document.getElementById('avatarCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  const base = parts.base[currentIndex.base];
  const hair = parts.hair[currentIndex.hair];
  const eyes = parts.eyes[currentIndex.eyes];
  const nose = parts.nose[currentIndex.nose];
  const mouth = parts.mouth[currentIndex.mouth];

  const [baseImg, hairImg, eyesImg, noseImg, mouthImg] = await Promise.all([
    loadImage("base/" + base),
    loadImage("hairs/" + hair),
    loadImage("eyes/" + eyes),
    loadImage("noses/" + nose),
    loadImage("mouths/" + mouth)
  ]);

  ctx.drawImage(baseImg, 0, 0, canvas.width, canvas.height);
  ctx.drawImage(hairImg, 24, 5, 145, 160);
  ctx.drawImage(eyesImg, 37, 69, 120, 60);
  ctx.drawImage(noseImg, 30, 95, 130, 40);
  ctx.drawImage(mouthImg, 57, 120, 80, 30);
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

function addPhotoImportOption() {
  const container = document.querySelector('.builder-box');
  if (!container) return;

  const form = document.createElement('form');
  form.id = 'import-photo-form';
  form.method = 'POST';
  form.enctype = 'multipart/form-data';
  form.action = 'upload-avatar';
  form.className = 'mt-4';

  const label = document.createElement('label');
  label.className = 'btn btn-outline-light';
  label.htmlFor = 'avatar-file-input';
  label.innerText = 'Importer une photo';

  const input = document.createElement('input');
  input.type = 'file';
  input.name = 'avatar';
  input.accept = 'image/*';
  input.id = 'avatar-file-input';
  input.style.display = 'none';
  input.onchange = () => form.submit();

  label.appendChild(input);
  form.appendChild(label);
  container.appendChild(form);
}

document.addEventListener('DOMContentLoaded', () => {
  drawAvatar();
  addPhotoImportOption();
});
