document.addEventListener('DOMContentLoaded', async function () {
    const response = await fetch("/api/logs/", {
            method: 'GET'
    });

    const tbody = document.querySelector('#logsShowing');

    const data = await response.json();
    
    const logs = data.logs;
    const logsPerBatch = 100;

    const userIdSession = data.waiter;
    let tbodyContent = "";

    let visible = logs.slice(0, logsPerBatch);
    let hidden = logs.slice(logsPerBatch);

    for (const log of visible) {
        tbodyContent += `
            <tr>
                <td>${log.created_at}</td>
                <td>${log.pseudo}</td>
                <td>${log.script_name}</td>
                <td>${log.ip}</td>
                <td>${log.status}</td>
                <td>${log.http_referer}</td>
                <td>${log.request_uri}</td>
                <td>${log.request_method}</td>
                <td>${log.server_protocol}</td>
                <td class="truncate-cell">${log.http_user_agent}</td>
            </tr>
        `;
    }

    tbody.innerHTML = tbodyContent;

    if (hidden.length > 0) {
        const showMoreBtn = document.createElement('button');
        showMoreBtn.textContent = `Afficher les ${logsPerBatch < hidden.length ? logsPerBatch : hidden.length} suivants`;
        showMoreBtn.classList.add('btn', 'btn-primary', 'mt-3');
        tbody.parentElement.appendChild(showMoreBtn);

        visible = hidden.slice(0, logsPerBatch);
        hidden = hidden.slice(logsPerBatch);

        showMoreBtn.addEventListener('click', function () {
            let moreRows = '';
            for (const log of visible) {
                moreRows += `
                    <tr>
                        <td>${log.created_at}</td>
                        <td>${log.pseudo}</td>
                        <td>${log.script_name}</td>
                        <td>${log.ip}</td>
                        <td>${log.status}</td>
                        <td>${log.http_referer}</td>
                        <td>${log.request_uri}</td>
                        <td>${log.request_method}</td>
                        <td>${log.server_protocol}</td>
                        <td class="truncate-cell">${log.http_user_agent}</td>
                    </tr>
                `;
            }
            tbody.innerHTML += moreRows;
        });
    } else {
        showMoreBtn.remove();
    }
});