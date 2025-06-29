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
        const envoyeur = letter.name_requester;
        const datePublication = letter.datePublication;
    
        const tr = document.createElement('tr');
    
        tr.innerHTML = `
            <td>${id}</td>
            <td>${objet}</td>
            <td>${contenu}</td>
            <td>${envoyeur}</td>
            <td>${datePublication}</td>
        `;
        tbody.appendChild(tr);
    }

});