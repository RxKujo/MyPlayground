// 15 mn
const timeLim = 15 * 60 * 1000;

document.addEventListener('DOMContentLoaded', async () => {
    setTimeout( async () => {
        const reponse = await fetch("/api/users/dynamic/disconnect/", {
            method: "POST"
        });

        const r = await reponse.json();
    }, timeLim);
});