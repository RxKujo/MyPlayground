document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch("/api/newsletter/", {
            method: 'GET'
    });

    const tbody = document.getElementById('newsletterGShowing');

    const data = await response.json();
    const news = data.news;
    const userIdSession = data.waiter;

    for (const letter of news) {
        const id = letter.id;
        const objet = letter.objet;
        const contenu = letter.contenu;
        const datePublication = letter.datePublication;
    
        const tr = document.createElement('tr');
    
        tr.innerHTML = `
            <td>${id}</td>
            <td>${objet}</td>
            <td>${contenu}</td>
            <td>${datePublication}</td>
        `;
        tbody.appendChild(tr);
    }

    function generateAddModal() {
        return `<div class="modal fade" id="newNewsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/add_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label>Privée</label>
                                        <select class="form-select" name="privee">
                                            <option value="0">Non</option>
                                            <option value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Code (si privée)</label>
                                        <input class="form-control" name="code" type="text" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
    }
});