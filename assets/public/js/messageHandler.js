async function sendMessage(content, groupId, senderId) {
    const response = await fetch('/api/users/messages/', {
        method: 'POST',
        body: JSON.stringify({
            contenu,
            groupId,
            senderId
        })
    })

    return response;
}

document.addEventListener("DOMContentLoaded", async function () {
    const discussionLinks = document.querySelectorAll(".discussion-link");
    const messageContainer = document.querySelector("#message-container .d-flex");
    const messageInput = document.querySelector('input[name="message"]');
    const sendButton = document.querySelector('button[type="submit"]');
    const groupIdInput = document.querySelector('#input-message-field');
    const interlocutorName = document.querySelector('#interlocutor-name');
    const interlocutorStatus = document.querySelector('#interlocutor-status');

    let currentGroupId = null;

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


    discussionLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const idGroupe = parseInt(this.dataset.id);
            currentGroupId = idGroupe;
            loadInterlocutorInfo(idGroupe);
            loadMessages(idGroupe);
        });
    });

    sendButton.addEventListener("click", async () => {
        if (!contenu || !id_groupe) return;

        const response = await sendMessage(messageInput, id_groupe, id_envoyeur);
        response.then(data => {
            messageInput.value = "";
            loadMessages(id_groupe);
        })
        .catch(error => {
            console.error("Erreur lors de l'envoi du message :", error);
        });
    });

    messageInput.addEventListener("keydown", async (e) => {
        if (e.key === "Enter") {
            e.preventDefault();

            if (!contenu || !id_groupe) return;

            const response = await sendMessage(messageInput, id_groupe, id_envoyeur);
            response.then(data => {
                messageInput.value = "";
                loadMessages(id_groupe);
            })
            .catch(error => {
                console.error("Erreur lors de l'envoi du message :", error);
            });
        }
    });


    setInterval(() => {
        if (currentGroupId != null) {
            loadMessages(currentGroupId);
        }
    }, 200);





    let allUsers = [];
    const selectedUsers = new Set();

    const guestInput = document.getElementById('guestInput');
    const suggestionsBox = document.getElementById('suggestions');
    const guestsContainer = document.getElementById('guests-container');
    const hiddenGuestsInput = document.getElementById('hiddenGuests');

    const groupNameInput = document.getElementById('groupName');
    const submitButton = document.getElementById('submitGroup');

    try {
        const res = await fetch('/api/users/static/all');
        const data = await res.json();
        allUsers = data.users.map(u => ({ id: u.id, pseudo: u.pseudo }));
    } catch (err) {
        console.error("Erreur lors du chargement des utilisateurs :", err);
    }

    function fetchSuggestionsLocal(query) {
        return allUsers
        .filter(user =>
            user.pseudo.toLowerCase().includes(query.toLowerCase()) &&
            !selectedUsers.has(user.pseudo)
        )
        .slice(0, 5);
    }

    function renderSuggestions(results) {
        suggestionsBox.innerHTML = "";
        results.forEach(user => {
        const item = document.createElement('li');
        item.className = "list-group-item list-group-item-action";
        item.textContent = user.pseudo;
        item.onclick = () => addGuest(user.pseudo);
        suggestionsBox.appendChild(item);
        });
        suggestionsBox.style.display = results.length ? 'block' : 'none';
    }

    function addGuest(pseudo) {
        if (selectedUsers.has(pseudo)) return;

        selectedUsers.add(pseudo);

        const badge = document.createElement('span');
        badge.className = "badge rounded-pill bg-primary";
        badge.textContent = pseudo;
        badge.style.cursor = 'pointer';
        badge.onclick = () => {
        selectedUsers.delete(pseudo);
        guestsContainer.removeChild(badge);
        updateHiddenInput();
        };

        guestsContainer.appendChild(badge);
        updateHiddenInput();

        guestInput.value = "";
        suggestionsBox.innerHTML = "";
    }

    function updateHiddenInput() {
        hiddenGuestsInput.value = Array.from(selectedUsers).join(',');
    }

    guestInput.addEventListener('input', () => {
        const parts = guestInput.value.split(',');
        const lastPart = parts[parts.length - 1].trim();
        if (lastPart.length > 0) {
        const suggestions = fetchSuggestionsLocal(lastPart);
        renderSuggestions(suggestions);
        } else {
        suggestionsBox.innerHTML = "";
        }
    });

    guestInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        const value = guestInput.value.trim().split(',').pop().trim();
        if (value) addGuest(value);
        }
    });

    document.addEventListener('click', (e) => {
        if (!guestInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
        suggestionsBox.innerHTML = "";
        }
    });

    submitButton.addEventListener('click', async () => {
    const name = groupNameInput.value.trim();
    const guests = Array.from(selectedUsers);

    if (!name || guests.length === 0) {
        alert("Veuillez entrer un nom de groupe et au moins un utilisateur.");
        return;
    }

    try {
        const res = await fetch('/api/users/group/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            guests: guests
        })
        });

        const result = await res.json();
        if (res.ok) {
            location.reload();
        } else {
            alert("Erreur : " + (result.error || "Impossible de créer le groupe."));
        }
    } catch (err) {
        console.error(err);
        alert("Erreur lors de la requête.");
    }
    });
});
