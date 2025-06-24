document.addEventListener('DOMContentLoaded', async function () {
    const response = await fetch("/api/captchas/");

    const tbody = document.querySelector('#usersShowing');

    const data = await response.json();
    const captchas = data.captchas;

    for (const captcha of captchas) {
        const { id, question, reponse } = captcha;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${id}</td>
            <td>${question}</td>
            <td>${reponse}</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCaptcha${id}">
                    Modifier
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delCaptcha${id}">
                    Supprimer
                </button>
                ${generateEditModal(id, question, reponse)}
                ${generateDeleteModal(id)}
            </td>
        `;
        tbody.appendChild(tr);
    };

    function generateEditModal(id, question, reponse) {
        return `
        <div class="modal fade" id="editCaptcha${id}" tabindex="-1" aria-labelledby="editCaptchaLabel${id}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../../processes/edit_captcha_process.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCaptchaLabel${id}">Modifier un captcha</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="${id}">
                            <div class="mb-3">
                                <label class="form-label" for="question${id}">Question</label>
                                <input class="form-control" id="question${id}" name="question${id}" type="text" value="${question}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="reponse${id}">Réponse</label>
                                <input class="form-control" id="reponse${id}" name="reponse${id}" type="text" value="${reponse}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;
    }

    function generateDeleteModal(id) {
        return `
        <div class="modal fade" id="delCaptcha${id}" tabindex="-1" aria-labelledby="delCaptchaLabel${id}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../../processes/delete_captcha_process.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delCaptchaLabel${id}">Supprimer un captcha</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer ce captcha ?
                            <input type="hidden" name="id" value="${id}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;
    }
});