
<style>
body.dark-mode {
    background-color: #181a1b !important;
    color: #e0e0e0 !important;
}
body.dark-mode .container {
    background-color: #23272b !important;
    color: #e0e0e0 !important;
}
body.dark-mode .btn-primary {
    background-color: #222e3c !important;
    border-color: #222e3c !important;
}
body.dark-mode .btn-secondary {
    background-color: #444 !important;
    border-color: #444 !important;
    color: #fff !important;
}
body.dark-mode .bg-light {
    background-color: #2d3238 !important;
    color: #f1f1f1 !important;
}
body.dark-mode .nav-link,
body.dark-mode .text-black {
    color: #f1f1f1 !important;
}
body.dark-mode .alert-warning {
    background-color: #555 !important;
    color: #fff !important;
    border-color: #888 !important;
}
</style>

<button id="theme-toggle"
    class="btn btn-secondary"
    style="position:fixed; top:20px; right:20px; z-index:9999;">
    Mode sombre
</button>
<script>
const themeBtn = document.getElementById('theme-toggle');
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    themeBtn.textContent = 'Mode clair';
}
themeBtn.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    if(document.body.classList.contains('dark-mode')) {
        themeBtn.textContent = 'Mode clair';
        localStorage.setItem('theme', 'dark');
    } else {
        themeBtn.textContent = 'Mode sombre';
        localStorage.setItem('theme', 'light');
    }
});
</script>