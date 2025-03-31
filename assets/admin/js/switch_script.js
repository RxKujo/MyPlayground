const usersPage = `
            <h2>Gestion des Utilisateurs</h2>
            <input type="text" class="form-control my-3" placeholder="Rechercher un utilisateur...">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jean Dupont</td>
                        <td>jean.dupont@example.com</td>
                        <td>Utilisateur</td>
                        <td>
                            <button class="btn btn-primary btn-sm">Modifier</button>
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Marie Curie</td>
                        <td>marie.curie@example.com</td>
                        <td>Administrateur</td>
                        <td>
                            <button class="btn btn-primary btn-sm">Modifier</button>
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        `;

const dashboardPage = "<h2>Tableau de Bord</h2><p>Bienvenue dans votre tableau de bord administrateur.</p>";

const settingsPage = "<h2>Paramètres</h2><p>Gérez ici les paramètres de l'application.</p>";


function loadContent(page) {
    let content = document.getElementById("content");
    if (page === 'dashboard') {
        content.innerHTML = dashboardPage;
    } else if (page === 'users') {
        content.innerHTML = usersPage;
    } else if (page === 'settings') {
        content.innerHTML = settingsPage;
    }
}