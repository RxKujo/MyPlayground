document.addEventListener("DOMContentLoaded", function () {
    const discussionLinks = document.querySelectorAll(".discussion-link");
    const messageContainer = document.querySelector("#message-container .d-flex");
    const messageInput = document.querySelector('input[name="message"]');
    const sendButton = document.querySelector('button[type="submit"]');
    const groupIdInput = document.querySelector('#input-message-field');
    const interlocutorName = document.querySelector('#interlocutor-name');
    const interlocutorStatus = document.querySelector('#interlocutor-status');

    let currentGroupId = null;

    // Chargement des messages
    function loadMessages(groupId) {
        fetch(`/api/users/messages/?id_groupe=${groupId}`)
            .then(response => response.json())
            .then(messages => {
                messageContainer.innerHTML = "";

                if (messages.length === 0) {
                    messageContainer.innerHTML = '<p class="text-muted">Aucun message pour le moment.</p>';
                    return;
                }

                messages.forEach(msg => {
                    const msgDiv = document.createElement("div");
                    msgDiv.classList.add("p-2", "rounded", "mb-2", "message-bubble");

                    if (parseInt(msg.id_envoyeur) === parseInt(user_id)) {
                        msgDiv.classList.add("bg-primary", "text-white", "align-self-end");
                    } else {
                        msgDiv.classList.add("bg-white", "text-dark", "align-self-start");
                    }

                    msgDiv.textContent = msg.message;
                    messageContainer.appendChild(msgDiv);
                });

                messageContainer.scrollTop = messageContainer.scrollHeight;
            })
            .catch(error => {
                console.error("Erreur lors du chargement des messages :", error);
                messageContainer.innerHTML = '<p class="text-danger">Erreur lors du chargement.</p>';
            });
    }

    function loadInterlocutorInfo(groupId) {
        fetch(`/api/users/interlocutors/?id_groupe=${groupId}`)
            .then(response => response.json())
            .then(data => {
                if (data.noms) {
                    document.getElementById("interlocutor-pfp").removeAttribute("hidden");
                    document.getElementById("interlocutor-pfp").src = data.pfps[data.noms[0]];
                    document.getElementById("interlocutor-name").textContent = data.noms.join(', ');
                    document.getElementById("interlocutor-status").textContent = data.status ?? '';
                }
            })
            .catch(err => {
                console.error("Erreur lors du chargement des interlocuteurs :", err);
        });
    }

    // Clic sur une discussion
    discussionLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const idGroupe = parseInt(this.dataset.id);
            currentGroupId = idGroupe;
            loadInterlocutorInfo(idGroupe);
            loadMessages(idGroupe);
        });
    });

    // Envoi du message
    sendButton.addEventListener("click", function () {
        const contenu = messageInput.value.trim();
        const id_groupe = currentGroupId;

        if (!contenu || !id_groupe) return;

        fetch('/api/users/messages/', {
            method: 'POST',
            body: JSON.stringify({
                contenu,
                id_groupe,
                user_id
            })
        })
        .then(response => {
            response.json();
        })
        .then(data => {
            messageInput.value = "";
            loadMessages(id_groupe);
        })
        .catch(error => {
            console.error("Erreur lors de l'envoi du message :", error);
        });
    });
});
