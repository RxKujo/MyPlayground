document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById('captcha-checkbox');
    const captchaSelection = document.getElementById('captcha-selection');
    const response = document.getElementById('reponse');
    const submitBtn = document.getElementById('submit-btn');

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            captchaSelection.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            captchaSelection.style.display = 'none';
            submitBtn.disabled = true;
        }
    });

    response.addEventListener('input', () => {
        submitBtn.disabled = false;
    });
});