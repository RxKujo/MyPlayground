document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById('captcha-checkbox');
    const captchaSelection = document.getElementById('captcha-selection');
    const captchaShapeText = "<?= strtolower($reponse) ?>";
    const shapeButtons = document.querySelectorAll('.shape-button');
    const captchaInput = document.getElementById('captcha-input');
    const submitBtn = document.getElementById('submit-btn');

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            captchaSelection.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            captchaSelection.style.display = 'none';
            captchaInput.value = '';
            submitBtn.disabled = true;
            shapeButtons.forEach(btn => btn.classList.remove('selected'));
        }
    });

    shapeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const selectedShape = button.getAttribute('data-shape');
            shapeButtons.forEach(btn => btn.classList.remove('selected'));

            button.classList.add('selected');
            captchaInput.value = selectedShape;
            submitBtn.disabled = false;
        });
    });
});