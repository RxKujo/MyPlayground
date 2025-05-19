function loadImage(src) {
  return new Promise((resolve) => {
    const img = new Image();
    img.onload = () => resolve(img);
    img.src = 'assets/' + src;
  });
}

async function generateAvatar() {
  const canvas = document.getElementById('avatarCanvas');
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  const eyes = document.getElementById('eyesSelect').value;
  const nose = document.getElementById('noseSelect').value;
  const mouth = document.getElementById('mouthSelect').value;

  const [eyesImg, noseImg, mouthImg] = await Promise.all([
    loadImage(eyes),
    loadImage(nose),
    loadImage(mouth)
  ]);

  ctx.drawImage(eyesImg, 0, 0);
  ctx.drawImage(noseImg, 0, 0);
  ctx.drawImage(mouthImg, 0, 0);
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
        `<div class="alert alert-success">Avatar sauvegardé avec succès : ${xhr.responseText}</div>`;
    }
  };
  xhr.send('image=' + encodeURIComponent(imageData));
}
